@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Buat Acara Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Isi form di bawah untuk membuat acara baru</p>
            </div>
            <a href="{{ route('admin.acara.list') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm bg-white hover:bg-gray-50">
                Kembali
            </a>
        </div>

        {{-- Success --}}
        @if (session()->has('success'))
            <div class="mb-6 bg-green-50 p-4 border border-green-200 rounded-lg">
                <div class="font-medium text-green-800">{{ session('success') }}</div>
            </div>
        @endif

        {{-- Errors --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 p-4 border border-red-200 rounded-lg">
                <ul class="text-red-700 text-sm list-disc list-inside">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <form action="{{ route('admin.acara.store') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">

                    {{-- Nama Acara --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Acara *</label>
                        <input type="text" name="nama_acara" required class="mt-1 w-full border-gray-300 rounded-lg">
                    </div>

                    {{-- Tanggal Waktu --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal & Waktu *</label>
                        <input type="date" name="tanggal_waktu" required class="mt-1 w-full border-gray-300 rounded-lg">
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Lokasi *</label>
                        <input type="text" name="lokasi" required class="mt-1 w-full border-gray-300 rounded-lg">
                    </div>

                    {{-- Tipe Audiens --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tipe Audiens *</label>
                        <select name="tipe_audiens" id="tipe_audiens" class="mt-1 w-full border-gray-300 rounded-lg">
                            <option value="SEMUA_INTERNAL">🏢 Semua Internal</option>
                            <option value="PER_UNIT">🏢 Per Unit</option>
                            <option value="KHUSUS">👥 Khusus (Undangan Manual)</option>
                            <option value="PUBLIK">🌍 Publik</option>
                        </select>
                    </div>

                    {{-- PER UNIT → Pilih Unit --}}
                    <div id="section_unit" class="hidden">
                        <label class="text-sm font-medium text-gray-700">Pilih Unit *</label>
                        <select id="unitSelect" class="mt-1 w-full border-gray-300 rounded-lg">
                            <option value="">-- Pilih Unit --</option>
                            @foreach ($unit as $u)
                                <option value="{{ $u->id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- KHUSUS → Pilih Pegawai --}}
                    <div id="section_pegawai" class="hidden">
                        <label class="text-sm font-medium text-gray-700">Pilih Pegawai *</label>

                        <select id="pegawaiSelect" name="pegawai[]" multiple>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p['value'] }}">{{ $p['text'] }}</option>
                            @endforeach
                        </select>

                        <p class="text-xs text-gray-600 mt-2">Ketik untuk mencari pegawai</p>
                    </div>

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

                {{-- Submit --}}
                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                    <button class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Simpan Acara
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/selectize/selectize.bootstrap5.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/selectize/selectize.js') }}"></script>

    <script src="{{ asset('assets/js/acara/acara.js') }}"></script>
@endpush
