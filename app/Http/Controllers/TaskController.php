<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    public function addTask(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'task' => 'required|string',
            ]);
            $user = Auth::user();
            $task = Task::create([
                'task' => $validatedData['task'],
                'user_id' => $user->id,
                'status' => 'pending'
            ]);
            return redirect('/home')->with('status', 'Task created successfully');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to create task. Please try again.']);
        }
    }


    public function updateStatus($id)
   {
    try {
        $user = Auth::user();
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['status' => 0,
             'message' => 'Task not found'], 404);
        }

        if($task->status == 'done'){
            $task->status = 'pending';
        } else {
            $task->status = 'done';
        }
        $task->save();

        return response()->json(['status' => 1,
         'message' => 'Task marked as done'], 201);
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to update task. Please try again.']);
    }

   }
}
