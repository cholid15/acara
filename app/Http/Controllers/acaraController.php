<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\acara\Acara;
use App\Models\acara\AcaraUndangan;
use App\Models\ref\Pegawai;
use App\Models\ref\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AcaraController extends Controller
{
    public function create()
    {
        // Unit Level 1 — nama variabel: $unit (sesuai view)
        $unit = Unit::where('level', 1)->orderBy('nama')->get();

        // Pegawai default (jika ingin menampilkan semua)
        $pegawai = Pegawai::with(['orang', 'unit'])
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($p) {
                return [
                    'value' => $p->id,
                    'text'  => ($p->orang->nama ?? 'Tanpa Nama') . ' — ' . ($p->unit->nama ?? 'Tanpa Unit')
                ];
            });

        // compact key names harus sesuai dengan yang view pake ($pegawai, $unit)
        return view('admin.acara.create', compact('pegawai', 'unit'));
    }


    // ============================
    // AJAX → Ambil Pegawai per Unit
    // ============================
    public function getPegawaiByUnit($unitId)
    {
        $pegawai = Pegawai::where('unit_id', $unitId)
            ->with(['orang', 'unit'])
            ->get()
            ->map(function ($p) {
                return [
                    'value' => $p->id,
                    'text'  => ($p->orang->nama ?? 'Tanpa Nama') . ' — ' . ($p->unit->nama ?? 'Tanpa Unit')
                ];
            });

        return response()->json($pegawai);
    }



    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'     => 'required|string',
            'tanggal_waktu'  => 'required|date',
            'lokasi'         => 'required|string',
            'tipe_audiens'   => 'required',
            'pegawai'        => 'array'
        ]);

        $acara = Acara::create([
            'nama_acara'    => $request->nama_acara,
            'tanggal_waktu' => $request->tanggal_waktu,
            'lokasi'        => $request->lokasi,
            'tipe_audiens'  => $request->tipe_audiens,

            // 👇 tambahkan ini
            'qr_token'      => Str::uuid(),
        ]);

        if ($request->pegawai) {
            foreach ($request->pegawai as $pegawaiID) {
                AcaraUndangan::create([
                    'acara_id' => $acara->id,
                    'id_pegawai' => $pegawaiID
                ]);
            }
        }

        return redirect()->route('admin.acara.create')
            ->with('success', 'Acara berhasil dibuat!');
    }
}
