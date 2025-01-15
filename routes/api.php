<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Rute API untuk Reviewee A (Hanya Reviewee A yang bisa membuat Todo)
Route::middleware(['auth:sanctum', 'role:revieweeA'])->group(function () {
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');
});

// Rute API untuk Reviewee A & B (Tambah Task/Subtask di Todo milik Reviewee A)
Route::middleware(['auth:sanctum', 'role:revieweeA,revieweeB'])->group(function () {
    Route::post('/todos/{todo}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
});

// Rute API untuk Semua Role yang Bisa Melihat Todos
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
});

?>
