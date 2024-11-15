<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::where('user_id', auth()->user()->id)->with('user')->paginate(10);
        return successResponse($tasks, 'Tasks retrieved successfully.', 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskStoreRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
        ]);

        return successResponse($task, 'Task created successfully.', 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        if ($task->user_id !== $request->user()->id) {
            return errorResponse('Unauthorized access', 403);
        }

        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
        ]);

        return successResponse($task, 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->user()->id) {
            return errorResponse('Unauthorized access', 403);
        }

        $task->delete();

        return successResponse([], 'Task deleted successfully.');
    }

    public function destroyAll()
    {
        $tasks = auth()->user()->tasks; // Ambil semua tugas milik pengguna yang sedang login
        $tasks->each->delete(); // Hapus semua tugas

        return successResponse([], 'All tasks deleted successfully.');
    }

    public function markAsComplete(Task $task)
    {
        if ($task->user_id !== auth()->user()->id) {
            return errorResponse('Unauthorized access', 403);
        }

        if ($task->status === 'completed') {
            return successResponse($task, 'Task is already completed.', 200);
        }

        $task->update(['status' => 'completed']);

        return successResponse($task, 'Task marked as completed successfully.');
    }

    public function markAllAsComplete()
    {
        $tasks = auth()->user()->tasks()->where('status', '!=', 'completed')->get();

        if ($tasks->isEmpty()) {
            return successResponse([], 'No tasks to mark as completed.', 200);
        }
        
        foreach ($tasks as $task) {
            $task->update(['status' => 'completed']);
        }

        return successResponse([], 'All tasks marked as completed successfully.');
    }

}
