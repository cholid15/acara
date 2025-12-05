<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\acara\Acara;
use App\Models\ref\Pegawai;
use App\Models\ref\Unit;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CreateAcara extends Component
{
    public $nama_acara;
    public $tanggal_waktu;
    public $lokasi;

    public $tipe_audiens;
    public $filter_unit_id;

    public $selectedPegawai = [];

    // Lazy-loaded lists
    public $units = [];
    public $pegawaiList = [];

    // Search
    public $searchPegawai = '';
    public $searchUnit = '';

    /**
     * ==========================
     *       SAVE EVENT
     * ==========================
     */
    public function save()
    {
        $rules = [
            'nama_acara'      => 'required|string|max:255',
            'tanggal_waktu'   => 'required|date',
            'lokasi'          => 'required|string|max:255',
            'tipe_audiens'    => 'required|in:SEMUA_INTERNAL,PER_UNIT,KHUSUS,PUBLIK',
        ];

        if ($this->tipe_audiens === 'PER_UNIT') {
            $rules['filter_unit_id'] = 'required|exists:ref.ms_unit,id';
        }

        if ($this->tipe_audiens === 'KHUSUS') {
            if (is_string($this->selectedPegawai)) {
                $this->selectedPegawai = array_filter(explode(',', $this->selectedPegawai));
            }

            $rules['selectedPegawai'] = 'required|array|min:1';
        }

        $this->validate($rules);

        $qrToken = $this->generateUniqueQrToken();

        $acara = Acara::create([
            'nama_acara'     => $this->nama_acara,
            'tanggal_waktu'  => $this->tanggal_waktu,
            'lokasi'         => $this->lokasi,
            'tipe_audiens'   => $this->tipe_audiens,
            'filter_unit_id' => $this->tipe_audiens === 'PER_UNIT' ? $this->filter_unit_id : null,
            'qr_token'       => $qrToken,
            'status'         => 'AKTIF',
        ]);

        if ($this->tipe_audiens === 'KHUSUS') {
            $selected = is_array($this->selectedPegawai)
                ? $this->selectedPegawai
                : array_filter(explode(',', $this->selectedPegawai));

            foreach ($selected as $pegawaiId) {
                $acara->undangan()->create([
                    'user_id' => $pegawaiId
                ]);
            }
        }

        session()->flash('success', 'Acara berhasil dibuat.');
        return redirect()->route('admin.acara.list');
    }


    /**
     * Generate QR unik
     */
    private function generateUniqueQrToken()
    {
        do {
            $token = 'ACARA-' . date('YmdHis') . '-' . strtoupper(Str::random(6));
            $exists = Acara::where('qr_token', $token)->exists();
        } while ($exists);

        return $token;
    }


    /**
     * Mount lifecycle hook
     */
    public function mount()
    {
        // Load pegawai awal jika dibutuhkan
        if ($this->tipe_audiens === 'KHUSUS') {
            $this->loadPegawai();
        }
    }

    /**
     * Event perubahan dropdown tipe audiens
     */
    public function updatedTipeAudiens($value)
    {
        // Reset selected pegawai ketika berubah tipe audiens
        $this->selectedPegawai = [];
        $this->searchPegawai = '';

        if ($value === 'PER_UNIT') {
            $this->loadUnits();
        }

        if ($value === 'KHUSUS') {
            $this->loadPegawai();
        }
    }


    /**
     * Event yang dikirim dari JS Selectize
     */
    #[On('pegawai-selected')]
    public function updatePegawai($values)
    {
        Log::info('updatePegawai called', ['raw_values' => $values, 'type' => gettype($values)]);

        if (is_string($values)) {
            $this->selectedPegawai = array_filter(explode(',', $values), function ($v) {
                return !empty($v) && $v !== '';
            });
        } elseif (is_array($values)) {
            $this->selectedPegawai = array_filter($values, function ($v) {
                return !empty($v) && $v !== '';
            });
        } else {
            $this->selectedPegawai = [];
        }

        // Konversi ke array of integers
        $this->selectedPegawai = array_map(function ($id) {
            return (int)$id;
        }, $this->selectedPegawai);

        Log::info('Pegawai updated:', ['selected' => $this->selectedPegawai]);
    }


    /**
     * Pencarian Unit
     */
    public function updatedSearchUnit()
    {
        $this->loadUnits();
    }

    /**
     * Pencarian Pegawai
     */
    public function updatedSearchPegawai()
    {
        $this->loadPegawai();
        $this->dispatch('pegawai-list-updated');
    }


    /**
     * Load daftar Unit
     */
    public function loadUnits()
    {
        $term = trim($this->searchUnit);

        $q = Unit::select('id', 'nama')
            ->where('level', 1)
            ->orderBy('nama');

        if ($term !== '') {
            $q->where('nama', 'like', "%{$term}%");
        }

        $this->units = $q->get();
    }


    /**
     * Load daftar pegawai
     */
    public function loadPegawai()
    {
        $term = trim($this->searchPegawai);

        $query = Pegawai::with([
            'orang:id,nama',
            'unit:id,nama'
        ]);

        if ($term !== '') {
            $query->whereHas('orang', function ($q) use ($term) {
                $q->where('nama', 'like', "%{$term}%");
            });
        }

        $this->pegawaiList = $query->limit(200)->get();
    }


    /**
     * Render view
     */
    public function render()
    {
        return view('livewire.admin.create-acara', [
            'unit'    => $this->units,
            'pegawai' => $this->pegawaiList,
            'selectedPegawai' => $this->selectedPegawai,
        ]);
    }
}