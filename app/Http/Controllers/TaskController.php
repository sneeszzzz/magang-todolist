<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Menyimpan task atau subtask ke dalam Todo tertentu.
     */
    public function store(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'progress' => 'required|integer|min:0|max:100',
            'parent_id' => 'nullable|exists:tasks,id',
        ]);

        // Simpan task/subtask
        $task = new Task([
            'title' => $request->title,
            'progress' => $request->progress,
            'parent_id' => $request->parent_id,
            'todo_id' => $todo->id,
            'user_id' => auth()->id(),
            'status' => $request->progress == 100 ? 'done' : 'in progress',
        ]);

        $task->save();

        // Update progres Todo
        $this->updateTodoProgress($todo);

        return response()->json([
            'status' => 'success',
            'message' => 'Task berhasil ditambahkan!',
            'data' => $task,
        ], 201);
    }

    /**
     * Memperbarui progress task tertentu.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $task->progress = $request->progress;
        $task->status = $request->progress == 100 ? 'done' : 'in progress';
        $task->save();

        // Update progres Todo
        $this->updateTodoProgress($task->todo);

        return response()->json([
            'status' => 'success',
            'message' => 'Progress task berhasil diperbarui!',
            'data' => $task,
        ]);
    }

    /**
     * Menghitung dan memperbarui progres Todo berdasarkan progres semua tasks dan subtasks.
     */
    private function updateTodoProgress(Todo $todo)
    {
        // Ambil semua task dan subtask dari Todo
        $allTasks = $this->getAllTasksRecursive($todo->tasks);

        $totalTasks = count($allTasks);
        $totalProgress = array_sum(array_column($allTasks, 'progress'));

        // Update progres dan status Todo
        $todo->progress = $totalTasks > 0 ? round($totalProgress / $totalTasks, 2) : 0;
        $todo->status = $todo->progress == 100 ? 'done' : 'in progress';
        $todo->save();
    }

    /**
     * Rekursi untuk mendapatkan semua task dan subtask dari koleksi tasks.
     */
    private function getAllTasksRecursive($tasks)
    {
        $allTasks = [];

        foreach ($tasks as $task) {
            $allTasks[] = ['id' => $task->id, 'progress' => $task->progress];

            if ($task->children()->exists()) {
                $allTasks = array_merge($allTasks, $this->getAllTasksRecursive($task->children));
            }
        }

        return $allTasks;
    }
}
