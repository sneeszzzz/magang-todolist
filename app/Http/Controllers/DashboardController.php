<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Todo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todosCount = Todo::where('user_id', auth()->id())->count();
        $completedTasksCount = Task::where('status', 'done')->whereHas('todo', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();
        $inProgressTasksCount = Task::where('status', 'in progress')->whereHas('todo', function ($query) {
            $query->where('user_id', auth()->id());
        })->count();

        return view('welcome', compact('todosCount', 'completedTasksCount', 'inProgressTasksCount'));
    }
}
