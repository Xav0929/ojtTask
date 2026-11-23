<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
   
    public function index(Request $request)
    {
       $tasks = [];
        $category = $request->query('category');

        if ($category) {
            $tasks = array_filter($tasks, function ($task) use ($category) {
                return $task['category'] === $category;
            });
        }

        return view('tasks.index', compact('tasks'));
    }

   
    public function create()
    {
        return view('tasks.create');
    }

    
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
        
    }

    public function destroy(string $id)
    {
        
    }
}