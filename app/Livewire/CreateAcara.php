<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\acara\Acara;
use App\Models\ref\Pegawai;
use App\Models\ref\Unit;
use App\Models\ref\Orang;
use Illuminate\Support\Str;

class CreateAcara extends Component
{
    public $nama_acara;
    public $tanggal_waktu;
    public $lokasi;
    public $tipe_audiens = 'SEMUA_INTERNAL';
    public $filter_unit_id;
    public $selectedPegawai = [];

    public function save()
    {
        // Validate input
        $this->validate([
            'nama_acara' => 'required|string|max:255',
            'tanggal_waktu' => 'required|date',
            'lokasi' => 'required|string|max:255',
            'tipe_audiens' => 'required|in:SEMUA_INTERNAL,PER_UNIT,KHUSUS,PUBLIK',
        ]);

        // Generate unique QR token
        $qrToken = $this->generateUniqueQrToken();

        // Create acara dengan qr_token
        $acara = Acara::create([
            'nama_acara' => $this->nama_acara,
            'tanggal_waktu' => $this->tanggal_waktu,
            'lokasi' => $this->lokasi,
            'tipe_audiens' => $this->tipe_audiens,
            'filter_unit_id' => $this->filter_unit_id,
            'qr_token' => $qrToken,
            'status' => 'AKTIF' // Set status default
        ]);

        // Jika acara khusus → insert ke acara_undangan
        if ($this->tipe_audiens === 'KHUSUS' && !empty($this->selectedPegawai)) {
            foreach ($this->selectedPegawai as $pegawaiId) {
                $acara->undangan()->create([
                    'user_id' => $pegawaiId
                ]);
            }
        }

        session()->flash('success', 'Acara berhasil dibuat dengan QR Code: ' . $qrToken);
        return redirect()->route('admin.acara.list');
    }

    /**
     * Generate unique QR token untuk acara
     * Format: ACARA-{TIMESTAMP}-{RANDOM}
     */
    private function generateUniqueQrToken()
    {
        do {
            // Generate token dengan format yang mudah dibaca dan unik
            $token = 'ACARA-' . date('YmdHis') . '-' . strtoupper(Str::random(6));

            // Cek apakah token sudah ada di database
            $exists = Acara::where('qr_token', $token)->exists();
        } while ($exists);

        return $token;
    }

    public function render()
    {
        return view('livewire.admin.create-acara', [
            'pegawai' => Pegawai::with('orang', 'unit')->get(),
            'unit' => Unit::all(),
        ]);
    }
}
