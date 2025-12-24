<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acara\Acara;
use App\Models\Acara\AcaraUndangan;
use App\Models\Ref\Pegawai;

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

    public function adminDashboard()
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Anda belum login.');
        }

        // Ambil data acara berurutan dari terbaru + pagination
        // $acara = Acara::orderBy('created_at', 'desc')->simplePaginate(2);
        $acara = Acara::orderBy('created_at', 'desc')->paginate(2);

        // Hitung total semua acara (tanpa pagination)
        $totalAcara = Acara::count();

        // ✅ total semua undangan
        $totalUndangan = AcaraUndangan::count();

        // ✅ total acara dengan status DRAFT
        $totalDraft = Acara::where('status', 'DRAFT')->count();

        // Return view - data bisa diakses langsung di blade via auth()->user()
        return view('admin.dashboard', [
            'user' => $user,
            'acara' => $acara,
            'totalAcara' => $totalAcara,
            'totalUndangan' => $totalUndangan,
            'totalDraft' => $totalDraft,
        ]);
    }


    public function userDashboard()
    {
        $user = auth()->user();
        if (!$user) {
            abort(401, 'Anda belum login.');
        }

        $idPegawai = $user->id_pegawai;
        $pegawai = Pegawai::findOrFail($idPegawai);
        $idUnitUser = $pegawai->id_unit;

        // Hitung undangan khusus
        $jumlahUndangan = AcaraUndangan::where('id_pegawai', $idPegawai)->count();

        $acaraTerkait = Acara::where(function ($query) use ($idUnitUser, $idPegawai) {
            // 🔹 SEMUA_INTERNAL
            $query->where('tipe_audiens', 'SEMUA_INTERNAL')

                // 🔹 PUBLIK
                ->orWhere('tipe_audiens', 'PUBLIK')

                // 🔹 PER_UNIT (sesuai unit user)
                ->orWhere(function ($q) use ($idUnitUser) {
                    $q->where('tipe_audiens', 'PER_UNIT')
                        ->where('filter_unit_id', $idUnitUser);
                })

                // 🔹 KHUSUS (ada di tabel undangan)
                ->orWhere(function ($q) use ($idPegawai) {
                    $q->where('tipe_audiens', 'KHUSUS')
                        ->whereHas('undangan', function ($u) use ($idPegawai) {
                            $u->where('id_pegawai', $idPegawai);
                        });
                });
        })
            ->orderBy('tanggal_waktu', 'asc')
            ->get();

        return view('user.dashboard', [
            'user'           => $user,
            'jumlahUndangan' => $jumlahUndangan,
            'acaraTerkait'   => $acaraTerkait,
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
        $acara = $query->paginate(2);
        // dd($acara);
        // die;

        // Statistics
        $stats = [
            'total' => Acara::count(),
            'aktif' => Acara::where('status', 'AKTIF')->count(),
            'selesai' => Acara::where('status', 'SELESAI')->count(),
            'draft' => Acara::where('status', 'DRAFT')->count(),
        ];

        return view('admin.acara.list', compact('acara', 'stats'));
    }


    public function detail($id)
    {
        $acara = Acara::with([
            'undangan',
            'undangan.pegawai',
            'undangan.pegawai.orang',
            'undangan.pegawai.unit'
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $acara
        ]);
    }
}
