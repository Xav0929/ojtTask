<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user  = $request->user();
        $query = $user->tasks()->with('category');

        if ($request->search) {
            $query->where('title', 'ilike', '%' . $request->search . '%');
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderByRaw("status = 'done'")
                       ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
                       ->orderBy('due_date')
                       ->paginate(6);

        $total = $user->tasks()->count();
        $done  = $user->tasks()->where('status', 'done')->count();

        return TaskResource::collection($tasks)->additional([
            'stats' => ['total' => $total, 'done' => $done, 'pending' => $total - $done],
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date|after_or_equal:today',
        ], [
            'category_id.required' => 'Please choose a category.',
            'due_date.required'    => 'Please pick a due date.',
        ]);

        $task = $request->user()->tasks()->create($data + ['status' => 'pending']);

        return (new TaskResource($task->load('category')))
            ->response()->setStatusCode(201);
    }

    public function show(Request $request, Task $task)
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        return new TaskResource($task->load('category'));
    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:pending,done',
            'priority'    => 'required|in:low,medium,high',
            'due_date'    => 'required|date',
        ]);

        $task->update($data);

        return new TaskResource($task->load('category'));
    }

    public function destroy(Request $request, Task $task)
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }

    public function toggle(Request $request, Task $task)
    {
        abort_if($task->user_id !== $request->user()->id, 403);

        $task->update(['status' => $task->status === 'done' ? 'pending' : 'done']);

        return new TaskResource($task->load('category'));
    }

    public function markAll(Request $request)
    {
        $status = $request->status === 'done' ? 'done' : 'pending';

        $request->user()->tasks()->whereIn('id', $request->input('ids', []))->update(['status' => $status]);

        return response()->json(['message' => 'Tasks updated']);
    }
}