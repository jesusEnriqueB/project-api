<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if($request->filled('project_id')){
            $query->where('project_id', $request->project_id);
        }

        if($request->filled('user_id')){
            $query->where('user_id', $request->user_id);
        }

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:pending,in_progress,completed',
            'percentage' => 'nullable|integer|min:0|max:100'
        ]);

        $task = Task::create($validated);

        $this->updateProjectProgress($task->project_id);

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:pending,in_progress,completed',
            'percentage' => 'nullable|integer|min:0|max:100'
        ]);

        $task->update($validated);

        $this->updateProjectProgress($task->project_id);

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $projectId = $task->project_id;
        $task->delete();

        $this->updateProjectProgress($projectId);

        return response()->json(['message' => 'Task deleted successfully']);
    }

    private function updateProjectProgress($projectId)
    {
        $project = \App\Models\Project::find($projectId);
        if (!$project) return;

        $totalTasks = $project->tasks()->count();
        $completedTasks = $project->tasks()->where('status', 'completed')->count();

        $project->progress = $totalTasks ? round(($completedTasks / $totalTasks) * 100) : 0;
        $project->save();
    }
}
