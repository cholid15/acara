<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard User
        </h2>
    </x-slot>

    <div class="py-6 md:py-12 pb-24 md:pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Card -->
            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-600 overflow-hidden shadow-lg rounded-xl p-6 text-white">
                <h3 class="text-2xl md:text-3xl font-bold">
                    Hai, {{ auth()->user()->name }} 👋
                </h3>
                <p class="mt-2 text-indigo-100">
                    Selamat datang di Sistem Manajemen Acara!
                </p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <!-- Acara yang Diikuti -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-l-4 border-indigo-600">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-gray-800 text-lg">Acara yang Diikuti</h4>
                        <span
                            class="bg-indigo-600 text-white text-2xl font-bold px-5 py-2 rounded-full min-w-[60px] text-center shadow-lg">
                            {{ $jumlahAcaraDiikuti ?? 0 }}
                        </span>
                    </div>
                    {{-- <p class="text-gray-500 text-sm mb-4">Lihat daftar acara yang kamu ikuti</p>
                    <a href="#"
                        class="inline-block px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-md hover:shadow-lg">
                        Lihat Acara
                    </a> --}}
                </div>

                <!-- Undangan -->
                <div
                    class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 border-l-4 border-green-600">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="font-semibold text-gray-800 text-lg">Undangan Kamu</h4>
                        <span
                            class="bg-green-600 text-white text-2xl font-bold px-5 py-2 rounded-full min-w-[60px] text-center shadow-lg">
                            {{ $jumlahUndangan ?? 5 }}
                        </span>
                    </div>
                    {{-- <p class="text-gray-500 text-sm mb-4">Cek undangan acara untukmu</p>
                    <a href="#"
                        class="inline-block px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-md hover:shadow-lg">
                        Lihat Undangan
                    </a> --}}
                </div>
            </div>

            <!-- Quick Actions - DESKTOP ONLY -->
            <div class="hidden md:block bg-white overflow-hidden shadow-md rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <!-- Scan QR -->
                    <a href="#"
                        class="btn-scan-qr  flex flex-col items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 text-center">Scan QR</span>
                    </a>

                    <!-- Acara Tersedia -->
                    <a href="#"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 text-center">Acara Tersedia</span>
                    </a>

                    <!-- Riwayat -->
                    <a href="#"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-orange-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 text-center">Riwayat</span>
                    </a>

                    <!-- Profil -->
                    <a href="{{ route('profile.edit') }}"
                        class="flex flex-col items-center p-4 bg-gradient-to-br from-pink-50 to-pink-100 hover:from-pink-100 hover:to-pink-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-700 text-center">Profil</span>
                    </a>
                </div>
            </div>

            <!-- Acara Mendatang -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">Acara Mendatang</h3>
                    {{-- <a href="#" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                        Lihat Semua →
                    </a> --}}
                </div>

                <!-- Dummy Acara Cards -->
                <div class="space-y-4">

                    @forelse ($acaraTerkait as $acara)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    @php
                                        $tanggal = \Carbon\Carbon::parse($acara->tanggal_waktu);
                                    @endphp

                                    <div
                                        class="w-16 h-16 bg-indigo-100 rounded-lg flex flex-col items-center justify-center">
                                        <span
                                            class="text-2xl font-bold text-indigo-600">{{ $tanggal->format('d') }}</span>
                                        <span
                                            class="text-xs text-indigo-600">{{ strtoupper($tanggal->format('M')) }}</span>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-semibold text-gray-800 mb-1">
                                        {{ $acara->nama_acara }}
                                    </h4>

                                    <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $tanggal->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($acara->tanggal_waktu_akhir)->format('H:i') }}
                                        </span>

                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $acara->lokasi }}
                                        </span>
                                    </div>

                                    <div class="mt-2">
                                        @php
                                            switch ($acara->tipe_audiens) {
                                                case 'KHUSUS':
                                                    $label = 'Khusus';
                                                    break;
                                                case 'SEMUA_INTERNAL':
                                                    $label = 'Semua Internal';
                                                    break;
                                                case 'PER_UNIT':
                                                    $label = 'Per Unit';
                                                    break;
                                                case 'PUBLIK':
                                                    $label = 'Publik';
                                                    break;
                                                default:
                                                    $label = $acara->tipe_audiens;
                                            }
                                        @endphp

                                        <span
                                            class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                            {{ $label }}
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>

                    @empty
                        <p class="text-gray-500 text-sm">Tidak ada acara dalam 2 minggu ke depan.</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Navigation - MOBILE ONLY -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="flex items-center justify-around relative px-4 h-20">
            <!-- Home -->
            <a href="#" class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                    </path>
                </svg>
                <span class="text-xs mt-1 text-indigo-600 font-medium">Home</span>
            </a>

            <!-- Acara -->
            <a href="#" class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                <span class="text-xs mt-1 text-gray-400">Acara</span>
            </a>

            <!-- Scan QR - CENTER BUTTON -->
            <div class="flex-1 flex justify-center">
                <a href="#" class="relative -top-6">
                    <div
                        class="btn-scan-qr  w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full shadow-2xl flex items-center justify-center transform transition-all duration-200 active:scale-95">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="absolute -bottom-5 left-1/2 transform -translate-x-1/2 text-xs text-gray-600 font-medium whitespace-nowrap">Scan
                        QR</span>
                </a>
            </div>

            <!-- Riwayat -->
            <a href="#" class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-xs mt-1 text-gray-400">Riwayat</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs mt-1 text-gray-400">Profil</span>
            </a>
        </div>
    </div>


    <!-- Modal Scan QR -->
    <div id="modal-scan" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-4 w-full max-w-md relative">
            <h3 class="text-lg font-semibold mb-3 text-center">Scan QR Absensi</h3>

            <div id="qr-reader" class="w-full"></div>

            <button id="close-scan" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800">
                ✕
            </button>
        </div>
    </div>


    <!-- Modal Info Acara -->
    <div id="modal-info" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-full max-w-lg relative">
            <button id="close-info" class="absolute top-3 right-3 text-gray-500">✕</button>

            <h3 class="text-xl font-bold mb-4" id="info-nama"></h3>

            <div class="space-y-2 text-gray-700">
                <p><strong>Tanggal:</strong> <span id="info-tanggal"></span></p>
                <p><strong>Lokasi:</strong> <span id="info-lokasi"></span></p>
                <p><strong>Status:</strong> <span id="info-status"></span></p>
            </div>

            <div class="mt-4 text-green-600 font-semibold">
                ✔ Kehadiran kamu sudah tercatat
            </div>
        </div>
    </div>




    @push('scripts')
        <script src="{{ asset('assets/js/acara/html5-qrcode.min.js') }}"></script>
        <script src="{{ asset('assets/js/acara/qr_code.js') }}"></script>
    @endpush
</x-app-layout>
