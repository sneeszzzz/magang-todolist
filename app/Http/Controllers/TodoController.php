<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Mendapatkan daftar Todos berdasarkan peran pengguna.
     */
    public function index()
    {
        $user = auth()->user();

        $todos = match ($user->role) {
            'reviewerA', 'reviewerB' => Todo::with('tasks')->get(), // Reviewer melihat semua Todos
            'revieweeB' => Todo::whereHas('user', function ($query) {
                $query->where('role', 'revieweeA'); // Reviewee B melihat Todos milik Reviewee A
            })->with('tasks')->get(),
            default => Todo::where('user_id', $user->id)->with('tasks')->get() // Reviewee A melihat Todos miliknya
        };

        return response()->json([
            'status' => 'success',
            'data' => $todos,
        ]);
    }

    /**
     * Membuat Todo baru (hanya untuk Reviewee A).
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi peran pengguna
        if ($user->role !== 'revieweeA') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action. Only Reviewee A can create Todos.',
            ], 403);
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan Todo baru
        $todo = Todo::create([
            'name' => $request->name,
            'user_id' => $user->id,
            'progress' => 0,
            'status' => 'in progress',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Todo berhasil ditambahkan!',
            'data' => $todo,
        ]);
    }

    /**
     * Menghapus Todo (hanya untuk pemilik).
     */
    public function destroy(Todo $todo)
    {
        $user = auth()->user();

        // Validasi kepemilikan Todo
        if ($user->id !== $todo->user_id || $user->role !== 'revieweeA') {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action.',
            ], 403);
        }

        // Hapus Todo
        $todo->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Todo berhasil dihapus!',
        ]);
    }
}
