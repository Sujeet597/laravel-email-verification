<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'task' => 'required|string',
        ]);

        // Get the logged-in user
        $user = Auth::user();

        // Create a new task
        $task = Task::create([
            'task' => $validatedData['task'],
            'user_id' => $user->id,
            'status' => 'pending' // Default status
        ]);

        // Return the response
        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => 'Successfully created a task'
        ], 201);
    }

    public function updateStatus(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'status' => 'required|in:pending,done'
        ]);

        // Find the task
        $task = Task::find($validatedData['task_id']);
        if (!$task) {
            return response()->json([
                'status' => 0,
                'message' => 'Task not found'
            ], 404);
        }

        // Update the status
        $task->status = $validatedData['status'];
        $task->save();

        $message = $validatedData['status'] == 'done' ? 'Marked task as done' : 'Marked task as pending';

        // Return the response
        return response()->json([
            'task' => $task,
            'status' => 1,
            'message' => $message
        ]);
    }
}