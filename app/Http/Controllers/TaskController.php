<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = [];

        // Counts for the stat cards (before filtering)
        $total   = count($tasks);
        $done    = count(array_filter($tasks, fn($t) => $t['status'] === 'Done'));
        $pending = $total - $done;

        // Filters from the URL: ?search=...&category=...&status=...
        $search   = $request->query('search');
        $category = $request->query('category');
        $status   = $request->query('status');

        if ($search) {
            $tasks = array_filter($tasks, fn($t) => stripos($t['title'], $search) !== false);
        }
        if ($category) {
            $tasks = array_filter($tasks, fn($t) => $t['category'] === $category);
        }
        if ($status) {
            $tasks = array_filter($tasks, fn($t) => $t['status'] === $status);
        }

        return view('tasks.index', compact('tasks', 'total', 'pending', 'done'));
    }

    // public function create()
    // {
    //     return view('tasks.create');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category'    => 'required|in:Work,School,Personal',
            'status'      => 'required|in:pending,done',
            'due_date'    => 'nullable|date',
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task validated! (saving comes Tuesday)');
    }

    public function show(string $id)
    {
        return view('tasks.show', compact('id'));
    }

    public function edit(string $id)
    {
        return view('tasks.edit', compact('id'));
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}