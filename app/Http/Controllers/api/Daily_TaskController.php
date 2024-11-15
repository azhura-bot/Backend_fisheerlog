<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Daily_Task;
use App\Models\User;
use Illuminate\Http\Request;

class Daily_TaskController extends Controller
{
    /**
     * Menampilkan daftar tugas untuk karyawan yang login.
     */
    public function index()
    {
        $user = auth()->user();

        // Jika user adalah karyawan, hanya tampilkan tugas miliknya
        if ($user->role === 'karyawan') {
            $tasks = Daily_Task::where('karyawan_username', $user->username)->get();
        } else {
            // Jika user adalah manager, tampilkan semua tugas yang dibuat oleh manager tersebut
            $tasks = Daily_Task::where('manager_id', $user->id)->get();
        }

        return response()->json($tasks);
    }

    /**
     * Menyimpan tugas baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_task' => 'required|string',
            'deskripsi' => 'nullable|string',
            'status' => 'in:not started,in progress,completed',
            'karyawan_username' => 'required|exists:users,username',
            'due_date' => 'required|date',
        ]);

        // Mengambil user yang login sebagai manager
        $manager = auth()->user();

        if ($manager->role !== 'manager') {
            return response()->json(['error' => 'Hanya manager yang dapat menambahkan task.'], 403);
        }

        // Validasi karyawan
        $karyawan = User::where('username', $request->karyawan_username)->first();

        if (!$karyawan || $karyawan->role !== 'karyawan') {
            return response()->json(['error' => 'Karyawan tidak ditemukan atau bukan karyawan.'], 404);
        }

        // Membuat task baru
        $task = Daily_Task::create([
            'nama_task' => $request->nama_task,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'not started',
            'karyawan_username' => $karyawan->username,
            'manager_id' => $manager->id,
            'due_date' => $request->due_date,
            'completed' => $request->completed ?? false,
        ]);

        return response()->json($task, 201);
    }

    /**
     * Menampilkan detail tugas berdasarkan ID.
     */
    public function show(string $id)
    {
        $task = Daily_Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Memperbarui data tugas.
     */
    public function update(Request $request, string $id)
    {
        $task = Daily_Task::findOrFail($id);

        $request->validate([
            'nama_task' => 'string',
            'deskripsi' => 'string',
            'status' => 'in:not started,in progress,completed',
            'due_date' => 'date',
        ]);

        $task->update($request->only(['nama_task', 'deskripsi', 'status', 'due_date', 'completed']));

        return response()->json($task);
    }

    /**
     * Menghapus tugas berdasarkan ID.
     */
    public function destroy(string $id)
    {
        $task = Daily_Task::findOrFail($id);
        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}

