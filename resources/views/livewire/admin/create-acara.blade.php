@push('styles')
    <!-- Selectize CSS - Local -->
    <link rel="stylesheet" href="{{ asset('assets/css/selectize/selectize.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui/jquery-ui.css') }}">
@endpush

@push('styles')
    <!-- Selectize CSS - Local -->
    <link rel="stylesheet" href="{{ asset('assets/css/selectize/selectize.bootstrap5.css') }}">

    <style>
        /* Custom Selectize Styling */
        .selectize-control.multi .selectize-input {
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 0.5rem;
            min-height: 45px;
        }

        .selectize-control.multi .selectize-input.focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .selectize-control.multi .selectize-input>div {
            background: #f59e0b;
            color: white;
            border: none;
            padding: 4px 8px;
            margin: 2px;
            border-radius: 4px;
        }

        .selectize-control.multi .selectize-input>div .remove {
            color: white;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            padding-left: 6px;
            margin-left: 6px;
        }

        .selectize-dropdown {
            border: 1px solid #fcd34d;
            border-radius: 0.5rem;
            margin-top: 4px;
            z-index: 9999;
        }

        .selectize-dropdown .option {
            padding: 0.75rem;
            border-bottom: 1px solid #fef3c7;
            cursor: pointer;
        }

        .selectize-dropdown .option:hover {
            background-color: #fef3c7;
        }

        .selectize-dropdown .active {
            background-color: #fde68a !important;
            color: #78350f;
        }

        .selectize-dropdown .option .nama-pegawai {
            font-weight: 600;
            color: #1f2937;
        }

        .selectize-dropdown .option .unit-pegawai {
            font-size: 0.875rem;
            color: #6b7280;
            margin-top: 2px;
        }
    </style>
@endpush

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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
                        <input type="date" id="tanggal_waktu" wire:model="tanggal_waktu"
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
                        <select wire:model.live="tipe_audiens" id="tipe_audiens"
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

                        <div class="mb-2">
                            <input type="text" wire:model.live.debounce.300ms="searchUnit"
                                placeholder="🔍 Cari unit (level 1)..."
                                class="w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" />
                        </div>

                        <div class="relative">
                            <select wire:model="filter_unit_id" id="filter_unit_id"
                                class="block w-full rounded-lg border-blue-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">-- Pilih Unit --</option>
                                @forelse ($unit as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @empty
                                    <option disabled>-- Tidak ada unit ditemukan --</option>
                                @endforelse
                            </select>

                            <div class="absolute right-3 top-2" wire:loading
                                wire:target="searchUnit,loadUnits,updatedTipeAudiens">
                                <svg class="animate-spin h-5 w-5 text-blue-600" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                            </div>
                        </div>

                        @error('filter_unit_id')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                {{-- Pilih Pegawai dengan Selectize (jika KHUSUS) --}}
                @if ($tipe_audiens == 'KHUSUS')
                    <div
                        class="space-y-3 bg-yellow-50 p-4 rounded-lg border border-yellow-200 transition-all duration-300">
                        <label for="pegawaiSelect" class="block text-sm font-medium text-yellow-900">
                            Pilih Pegawai <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-yellow-700 mb-2">
                            💡 Ketik untuk mencari pegawai, klik untuk memilih (bisa lebih dari satu)
                        </p>

                        {{-- Live Search Input --}}
                        <div class="mb-3">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" wire:model.live.debounce.300ms="searchPegawai"
                                    placeholder="🔍 Ketik nama pegawai untuk mencari..."
                                    class="pl-10 pr-10 w-full rounded-lg border-yellow-300 shadow-sm focus:border-yellow-500 focus:ring-yellow-500 text-sm" />
                                <div class="absolute right-3 top-2.5" wire:loading
                                    wire:target="searchPegawai,loadPegawai">
                                    <svg class="animate-spin h-5 w-5 text-yellow-600" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Selectize Element --}}
                        <div wire:ignore>
                            <select id="pegawaiSelect" multiple>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">
                                        {{ optional($p->orang)->nama ?? '—' }} — {{ optional($p->unit)->nama ?? '—' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Counter Pegawai Dipilih --}}
                        <div class="mt-3 p-3 bg-white rounded-lg border border-yellow-300">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-yellow-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Pegawai dipilih:
                                </span>
                                <span class="font-bold text-lg text-yellow-900">{{ count($selectedPegawai) }}</span>
                            </div>
                        </div>

                        @error('selectedPegawai')
                            <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
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
                    <svg class="w-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
</div>

@push('scripts')
    <!-- Load Selectize only (jQuery already loaded in layout).
                 Jika kamu tidak yakin selectize file ada, gunakan CDN versi fallback di bawah -->
    <script>
        // if local file exists, inject it; otherwise fallback to CDN
        (function() {
            function loadScript(src, cb) {
                var s = document.createElement('script');
                s.src = src;
                s.onload = cb;
                s.onerror = function() {
                    console.warn('Failed loading', src);
                    cb(new Error('load error'));
                };
                document.head.appendChild(s);
            }

            // try local first
            var local = "{{ asset('assets/js/selectize/selectize.min.js') }}";
            loadScript(local, function(err) {
                if (err) {
                    // fallback CDN
                    loadScript(
                        'https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js',
                        function() {
                            console.log('Selectize loaded from CDN fallback');
                        });
                } else {
                    console.log('Selectize loaded (local)');
                }
            });
        })();
    </script>

    <script>
        // safe initializer - wait for selectize plugin ready
        function safeInitSelectizeRetry(maxRetries = 10, interval = 150) {
            let tries = 0;

            function attempt() {
                tries++;
                if (window.jQuery && typeof jQuery.fn.selectize === 'function') {
                    initSelectize();
                } else if (tries < maxRetries) {
                    console.log('[Selectize] plugin not ready, retry', tries);
                    setTimeout(attempt, interval);
                } else {
                    console.error('[Selectize] plugin not available after retries');
                }
            }

            attempt();
        }

        let selectizeInstance = null;

        function initSelectize() {
            console.log('[Selectize] initSelectize called');

            const selectElement = document.getElementById('pegawaiSelect');
            if (!selectElement) {
                console.warn('[Selectize] #pegawaiSelect not found, skipping init');
                return;
            }

            // destroy existing instance safely
            try {
                if (selectElement.selectize) {
                    selectElement.selectize.destroy();
                }
                // jQuery-backed instance
                if (jQuery && jQuery.fn && jQuery.fn.selectize && jQuery('#pegawaiSelect')[0] && jQuery('#pegawaiSelect')[0]
                    .selectize) {
                    jQuery('#pegawaiSelect')[0].selectize.destroy();
                }
            } catch (e) {
                // ignore destroy errors
                console.warn('[Selectize] destroy error', e);
            }

            // Ensure plugin is present
            if (!window.jQuery || typeof jQuery.fn.selectize !== 'function') {
                console.error('[Selectize] selectize plugin not available');
                return;
            }

            // Initialize
            selectizeInstance = jQuery('#pegawaiSelect').selectize({
                plugins: ['remove_button'],
                maxItems: null,
                valueField: 'value',
                labelField: 'text',
                searchField: ['text'],
                create: false,
                hideSelected: true,
                closeAfterSelect: false,
                render: {
                    option: function(item, escape) {
                        // item.text expected "Name — Unit"
                        const parts = (item.text || '').split(' — ');
                        return `<div class="py-2 px-3">
                                    <div class="nama-pegawai">${escape(parts[0]||item.text||'')}</div>
                                    <div class="unit-pegawai text-xs">${escape(parts[1]||'')}</div>
                                </div>`;
                    },
                    item: function(item, escape) {
                        return `<div>${escape((item.text||'').split(' — ')[0]||item.text||'')}</div>`;
                    }
                },
                onChange: function(value) {
                    // normalize to array
                    let selected = [];
                    if (typeof value === 'string') {
                        selected = value ? value.split(',').filter(v => v !== '') : [];
                    } else if (Array.isArray(value)) {
                        selected = value;
                    }
                    // update Livewire property
                    if (window.Livewire) {
                        Livewire.emit('pegawai-selected', selected);
                    }
                }
            })[0].selectize;

            // add options from DOM (if any) so selectize shows them
            const options = [];
            Array.from(selectElement.options).forEach(opt => {
                if (opt.value && opt.value !== '') {
                    options.push({
                        value: opt.value,
                        text: opt.text
                    });
                }
            });
            if (options.length) {
                selectizeInstance.addOption(options);
                selectizeInstance.refreshOptions(false);
            }

            // set initial selection if server provided values
            try {
                const initial = @json($selectedPegawai ?? []);
                if (initial && initial.length) {
                    selectizeInstance.setValue(initial, true);
                }
            } catch (e) {
                console.warn('[Selectize] cannot set initial values', e);
            }

            console.log('[Selectize] initialized');
        }

        // Initialize safely on load and after Livewire renders
        document.addEventListener('DOMContentLoaded', function() {
            safeInitSelectizeRetry(20, 150); // try for a few times
        });

        document.addEventListener('livewire:load', function() {
            // when Livewire ready, also ensure plugin is initialized or retried
            safeInitSelectizeRetry(20, 150);
            // hook to Livewire message processed to re-init after DOM updates
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', (message, component) => {
                    // small delay to ensure DOM inserted
                    setTimeout(() => {
                        safeInitSelectizeRetry(10, 120);
                    }, 80);
                });
            }
        });
    </script>
@endpush
