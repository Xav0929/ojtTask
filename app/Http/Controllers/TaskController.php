<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   public function index(Request $request)
{
    $query = Task::with('category');

    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
    if ($request->category) {
        $query->where('category_id', $request->category);
    }
    if ($request->status) {
        $query->where('status', $request->status);
    }

    $tasks      = $query->orderByRaw("status = 'done'")
                        ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
                        ->orderBy('due_date')
                        ->paginate(6)
                        ->withQueryString();
    $categories = Category::all();

    $total   = Task::count();
    $done    = Task::where('status', 'done')->count();
    $pending = $total - $done;

    return view('tasks.index', compact('tasks', 'categories', 'total', 'pending', 'done'));
}
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date|after_or_equal:today',
        ]);

        Task::create([
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'status'      => 'pending',
            'priority'    => $request->priority,
            'due_date'    => $request->due_date,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created!');
    }

    public function markAll(Request $request)
    {
        $status = $request->status === 'done' ? 'done' : 'pending';

        Task::whereIn('id', $request->input('ids', []))->update(['status' => $status]);

        return redirect()->back()->with('success', 'Tasks updated!');
    }

    public function markDone(Task $task)
    {
        $task->update(['status' => $task->status === 'done' ? 'pending' : 'done']);

        return redirect()->back()->with('success', 'Task updated!');
    }

    public function show(string $id)
    {
        return view('tasks.show', compact('id'));
    }

    public function edit(Task $task)
    {
        $categories = Category::all();

        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:pending,done',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'nullable|date|after_or_equal:today',
        ]);

        $task->update($request->only('title', 'description', 'category_id', 'status', 'priority', 'due_date'));

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted!')->with('type', 'danger');
    }
}