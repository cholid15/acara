<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-800">
                    Hai, {{ auth()->user()->name }} 👋
                </h3>
                <p class="mt-2 text-gray-600">
                    Selamat datang di Sistem Manajemen Acara!
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-800">Acara yang Diikuti</h4>
                        <span
                            class="bg-indigo-100 text-indigo-800 text-2xl font-bold px-5 py-2 rounded-full min-w-[60px] text-center">
                            {{-- {{ $jumlahAcaraDiikuti }} --}}
                            12
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Lihat daftar acara yang kamu ikuti</p>
                    <div class="mt-4">
                        <a href="#" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                            Lihat Acara
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-semibold text-gray-800">Undangan Kamu</h4>
                        <span
                            class="bg-green-100 text-green-800 text-2xl font-bold px-5 py-2 rounded-full min-w-[60px] text-center">
                            {{ $jumlahUndangan }}
                            {{-- 5 --}}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm">Cek undangan acara untukmu</p>
                    <div class="mt-4">
                        <a href="#" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                            Lihat Undangan
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
