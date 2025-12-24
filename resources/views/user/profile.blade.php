<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil Pengguna
        </h2>
    </x-slot>

    <div class="py-6 md:py-12 pb-24 md:pb-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Header Card -->
            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-600 overflow-hidden shadow-lg rounded-xl p-8 text-white">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-4xl font-bold text-indigo-600">
                                {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="text-center md:text-left flex-1">
                        <h3 class="text-3xl font-bold mb-2">
                            {{ $pegawai->nama }}
                        </h3>
                        <p class="text-indigo-100 text-lg">
                            Selamat datang di Sistem Manajemen Acara
                        </p>
                    </div>
                </div>
            </div>

            <!-- Account Information -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Akun
                </h3>

                <div class="space-y-4">
                    <!-- Nama Lengkap -->
                    <div class="border-b border-gray-200 pb-4">
                        <label class="text-sm font-medium text-gray-500 block mb-1">Nama Lengkap</label>
                        <p class="text-lg text-gray-800 font-semibold">{{ auth()->user()->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Aksi Cepat
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kembali ke Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-4 bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Dashboard</h4>
                            <p class="text-sm text-gray-600">Kembali ke beranda</p>
                        </div>
                    </a>

                    <!-- Edit Profil -->
                    {{-- <a href="{{ route('profile.edit') }}"
                        class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-200 group"> --}}
                    <a
                        class="flex items-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl transition-all duration-200 group">
                        <div
                            class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-800">Edit Profil</h4>
                            <p class="text-sm text-gray-600">Ubah informasi akun</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Logout Section -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl p-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="text-center md:text-left">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Keluar dari Akun</h3>
                        <p class="text-gray-600">Akhiri sesi Anda dengan aman</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-200 shadow-md hover:shadow-lg flex items-center space-x-2"
                            onclick="return confirm('Apakah Anda yakin ingin logout?')">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Navigation - MOBILE ONLY -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg z-50">
        <div class="flex items-center justify-around relative px-4 h-20">
            <!-- Home -->
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                <span class="text-xs mt-1 text-gray-400">Home</span>
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
                <a href="#" class="relative -top-6 btn-scan-qr">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full shadow-2xl flex items-center justify-center transform transition-all duration-200 active:scale-95">
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
            {{-- <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 py-2"> --}}
            <a class="flex flex-col items-center justify-center flex-1 py-2">
                <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs mt-1 text-indigo-600 font-medium">Profil</span>
            </a>
        </div>
    </div>
</x-app-layout>
