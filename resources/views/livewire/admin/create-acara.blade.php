<div>
    <h3>Buat Acara Baru</h3>

    <form wire:submit.prevent="save">

        <div class="mb-3">
            <label>Nama Acara</label>
            <input type="text" wire:model="nama_acara" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tanggal & Waktu</label>
            <input type="date" wire:model="tanggal_waktu" class="form-control">
        </div>

        <div class="mb-3">
            <label>Lokasi</label>
            <input type="text" wire:model="lokasi" class="form-control">
        </div>

        <div class="mb-3">
            <label>Tipe Audiens</label>
            <select wire:model="tipe_audiens" class="form-select">
                <option value="SEMUA_INTERNAL">Semua Internal</option>
                <option value="PER_UNIT">Per Unit</option>
                <option value="KHUSUS">Khusus (Undangan Manual)</option>
                <option value="PUBLIK">Publik</option>
            </select>
        </div>

        @if ($tipe_audiens == 'KHUSUS')
            <div class="mb-3">
                <label>Pilih Pegawai</label>
                <select multiple class="form-select" wire:model="selectedPegawai">
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->orang->nama }} — {{ $p->unit->nama_unit }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <button class="btn btn-primary">Simpan</button>
    </form>
</div>
