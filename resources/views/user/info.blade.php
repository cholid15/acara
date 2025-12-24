@extends('layouts.app')

@section('title', 'Info Acara')

@section('content')
    <div class="max-w-3xl mx-auto mt-8 px-4">

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">
                {{ $acara->nama_acara }}
            </h1>

            <div class="space-y-2 text-gray-700 dark:text-gray-300">
                <p>
                    <strong>Tanggal & Waktu:</strong><br>
                    {{ \Carbon\Carbon::parse($acara->tanggal_waktu)->translatedFormat('d F Y H:i') }}
                </p>

                <p>
                    <strong>Lokasi:</strong><br>
                    {{ $acara->lokasi }}
                </p>

                <p>
                    <strong>Status:</strong><br>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm
                    {{ $acara->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                        {{ ucfirst($acara->status) }}
                    </span>
                </p>
            </div>

            <hr class="my-6">

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ url()->previous() }}"
                    class="inline-flex justify-center items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded">
                    Kembali
                </a>

                <a href="{{ route('acara.scan', $acara->qr_token) }}"
                    class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                    Scan Ulang QR
                </a>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    {{-- SWEETALERT --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: "{{ session('warning') }}"
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}"
            });
        </script>
    @endif
@endpush
