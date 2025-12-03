<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Buat Acara Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Isi form di bawah untuk membuat acara baru</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
            <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round     " stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <form wire:submit.prevent="save">
            <div class="p-6 space-y-6">

                {{-- Nama Acara --}}
                <div class="space-y-2">
                    <label for="nama_acara" class="block text-sm font-medium text-gray-700">
                        Nama Acara <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <input type="text" id="nama_acara" wire:model="nama_acara"
                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200"
                            placeholder="Contoh: Seminar Teknologi 2025">
                    </div>
                    @error('nama_acara')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal & Waktu --}}
                <div class="space-y-2">
                    <label for="tanggal_waktu" class="block text-sm font-medium text-gray-700">
                        Tanggal & Waktu <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="datetime-local" id="tanggal_waktu" wire:model="tanggal_waktu"
                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200">
                    </div>
                    @error('tanggal_waktu')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Lokasi --}}
                <div class="space-y-2">
                    <label for="lokasi" class="block text-sm font-medium text-gray-700">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <input type="text" id="lokasi" wire:model="lokasi"
                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200"
                            placeholder="Contoh: Auditorium Lt. 3">
                    </div>
                    @error('lokasi')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipe Audiens --}}
                <div class="space-y-2">
                    <label for="tipe_audiens" class="block text-sm font-medium text-gray-700">
                        Tipe Audiens <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <select wire:model="tipe_audiens" id="tipe_audiens"
                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors duration-200">
                            <option value="SEMUA_INTERNAL">🏢 Semua Internal</option>
                            <option value="PER_UNIT">🏛️ Per Unit</option>
                            <option value="KHUSUS">👥 Khusus (Undangan Manual)</option>
                            <option value="PUBLIK">🌍 Publik</option>
                        </select>
                    </div>
                    @error('tipe_audiens')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Filter Unit (jika PER_UNIT) --}}
                @if ($tipe_audiens == 'PER_UNIT')
                    <div
                        class="space-y-2 bg-blue-50 p-4 rounded-lg border border-blue-200 transition-all duration-300">
                        <label for="filter_unit_id" class="block text-sm font-medium text-blue-900">
                            Pilih Unit <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="filter_unit_id" id="filter_unit_id"
                            class="block w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->nama_unit }}</option>
                            @endforeach
                        </select>
                        @error('filter_unit_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Pilih Pegawai (jika KHUSUS) --}}
                @if ($tipe_audiens == 'KHUSUS')
                    <div
                        class="space-y-2 bg-yellow-50 p-4 rounded-lg border border-yellow-200 transition-all duration-300">
                        <label class="block text-sm font-medium text-yellow-900">
                            Pilih Pegawai <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-yellow-700 mb-2">
                            💡 Tahan tombol Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu
                        </p>

                        {{-- Search Box --}}
                        <div class="mb-3">
                            <input type="text" placeholder="🔍 Cari pegawai..."
                                class="w-full rounded-lg border-yellow-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm"
                                id="searchPegawai">
                        </div>

                        <div
                            class="border border-yellow-300 rounded-lg overflow-hidden bg-white max-h-64 overflow-y-auto">
                            <select multiple wire:model="selectedPegawai" id="pegawaiSelect"
                                class="block w-full border-0 focus:ring-0 min-h-[200px]" size="8">
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}"
                                        class="py-2 px-3 hover:bg-yellow-100 cursor-pointer">
                                        {{ $p->orang->nama }} — {{ $p->unit->nama_unit }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-2 text-sm text-yellow-700">
                            <span class="font-semibold">{{ count($selectedPegawai) }}</span> pegawai dipilih
                        </div>

                        @error('selectedPegawai')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Info Box --}}
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-indigo-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-indigo-700">
                            <p class="font-medium">Informasi:</p>
                            <ul class="mt-1 list-disc list-inside space-y-1">
                                <li>QR Code akan dibuat otomatis setelah acara disimpan</li>
                                <li>Pastikan semua field yang wajib (*) sudah diisi</li>
                                <li>Anda dapat mengubah data acara setelah disimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <a href="{{ route('admin.acara.list') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span wire:loading.remove wire:target="save">Simpan Acara</span>
                    <span wire:loading wire:target="save" class="flex items-center">
                        <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- Simple Search Filter Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchPegawai');
            const selectElement = document.getElementById('pegawaiSelect');

            if (searchInput && selectElement) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const options = selectElement.options;

                    for (let i = 0; i < options.length; i++) {
                        const optionText = options[i].text.toLowerCase();
                        if (optionText.includes(searchTerm)) {
                            options[i].style.display = '';
                        } else {
                            options[i].style.display = 'none';
                        }
                    }
                });
            }
        });
    </script>
</div>
