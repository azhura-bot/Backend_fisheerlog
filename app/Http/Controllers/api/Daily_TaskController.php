<?php

namespace App\Http\Controllers;

use App\Models\Daily_Task;
use Illuminate\Http\Request;

class Daily_TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Daily_Task::all();
        return response()->json($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_name' => 'required|string',
            'description' => 'required|string',
            'status' => 'in:not started,in progress,completed',
            'manager_id' => 'required|exists:users,id',
            'due_date' => 'required|date',
        ]);
    
        $tasks = Daily_Task::create([
            'task_name' => $request->task_name,
            'description' => $request->description,
            'status' => $request->status ?? 'not started',
            'manager_id' => $request->manager_id,
            'due_date' => $request->due_date,
            'completed' => $request->completed ?? false,
        ]);
    
        return response()->json($tasks);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tasks = Daily_Task::findOrFail($id); 
        return response()->json($tasks);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tasks = Daily_Task::findOrFail($id);
    
        $request->validate([
            'task_name' => 'string',
            'description' => 'string',
            'status' => 'in:not started,in progress,completed',
            'manager_id' => 'exists:users,id',
            'due_date' => 'date',
        ]);
    
        $tasks->update([
            'task_name' => $request->task_name ?? $tasks->task_name,
            'description' => $request->description ?? $tasks->description,
            'status' => $request->status ?? $tasks->status,
            'manager_id' => $request->manager_id ?? $tasks->manager_id,
            'due_date' => $request->due_date ?? $tasks->due_date,
            'completed' => $request->completed ?? $tasks->completed,
        ]);
    
        return response()->json($tasks);
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tasks = Daily_Task::findOrFail($id);
        $tasks->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
