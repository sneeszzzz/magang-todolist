<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Menampilkan informasi profil pengguna.
     */
    public function edit(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Profil pengguna berhasil diambil.',
            'data' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Profil pengguna berhasil diperbarui.',
            'data' => $user,
        ]);
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Logout pengguna
        Auth::logout();

        // Hapus akun pengguna
        $user->delete();

        // Invalidasi sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Akun pengguna berhasil dihapus.',
        ]);
    }
}
