<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara\Acara;
use App\Models\User;

class adminController extends Controller
{
    public function index()
    {
        return '<h1> Cek2 </h1>';
    }

    public function addRole()
    {
        $user = User::find(1);

        if ($user) {
            $user->assignRole('admin');
            return 'Role admin berhasil diberikan ke user ID 1';
        }

        return 'User tidak ditemukan';
    }

    public function admin()
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Anda belum login.');
        }


        // Return view - data bisa diakses langsung di blade via auth()->user()
        return view('admin.dashboard', [
            'user' => $user,
        ]);
    }


    /**
     * Display a listing of acara
     */
    public function list(Request $request)
    {
        $query = Acara::query()->latest();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_acara', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhere('tipe_audiens', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by tipe_audiens
        if ($request->has('tipe_audiens') && $request->tipe_audiens != '') {
            $query->where('tipe_audiens', $request->tipe_audiens);
        }

        // Pagination
        $acara = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => Acara::count(),
            'aktif' => Acara::where('status', 'AKTIF')->count(),
            'selesai' => Acara::where('status', 'SELESAI')->count(),
            'draft' => Acara::where('status', 'DRAFT')->count(),
        ];

        return view('admin.acara.list', compact('acara', 'stats'));
    }
}
