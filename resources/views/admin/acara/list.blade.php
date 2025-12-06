<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Acara') }}
            </h2>
            <a href="{{ route('admin.acara.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Acara
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                        <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Aktif</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['aktif'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-500 rounded-md p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Selesai</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['selesai'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Draft</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $stats['draft'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filter & Search Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.acara.list') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            {{-- Search --}}
                            <div class="md:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari
                                    Acara</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="search" id="search"
                                        value="{{ request('search') }}"
                                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Nama acara, lokasi...">
                                </div>
                            </div>

                            {{-- Filter Status --}}
                            <div>
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" id="status"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Status</option>
                                    <option value="AKTIF" {{ request('status') == 'AKTIF' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="DRAFT" {{ request('status') == 'DRAFT' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="DIBATALKAN"
                                        {{ request('status') == 'DIBATALKAN' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>

                            {{-- Filter Tipe Audiens --}}
                            <div>
                                <label for="tipe_audiens" class="block text-sm font-medium text-gray-700 mb-2">Tipe
                                    Audiens</label>
                                <select name="tipe_audiens" id="tipe_audiens"
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Semua Tipe</option>
                                    <option value="SEMUA_INTERNAL"
                                        {{ request('tipe_audiens') == 'SEMUA_INTERNAL' ? 'selected' : '' }}>Semua
                                        Internal</option>
                                    <option value="PER_UNIT"
                                        {{ request('tipe_audiens') == 'PER_UNIT' ? 'selected' : '' }}>Per Unit</option>
                                    <option value="KHUSUS"
                                        {{ request('tipe_audiens') == 'KHUSUS' ? 'selected' : '' }}>Khusus</option>
                                    <option value="PUBLIK"
                                        {{ request('tipe_audiens') == 'PUBLIK' ? 'selected' : '' }}>Publik</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Cari
                            </button>
                            <a href="{{ route('admin.acara.list') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Acara
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal & Waktu
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tipe
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($acara as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-6 w-6 text-indigo-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->nama_acara }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    QR: {{ $item->qr_token }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->tanggal_waktu)->format('H:i') }} WIB
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $item->lokasi }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $item->tipe_audiens }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColors = [
                                                'AKTIF' => 'bg-green-100 text-green-800',
                                                'SELESAI' => 'bg-gray-100 text-gray-800',
                                                'DRAFT' => 'bg-yellow-100 text-yellow-800',
                                                'DIBATALKAN' => 'bg-red-100 text-red-800',
                                            ];
                                            $colorClass =
                                                $statusColors[$item->status ?? 'AKTIF'] ?? 'bg-blue-100 text-blue-800';
                                        @endphp
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colorClass }}">
                                            {{ $item->status ?? 'AKTIF' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="javascript:void(0)" onclick="showDetail({{ $item->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 transition"
                                                title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="javascript:void(0)" onclick="openEdit({{ $item->id }})"
                                                class="text-yellow-600 hover:text-yellow-900 transition"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <!-- QR icon: panggil JS openQr(id) -->
                                            <a href="javascript:void(0)" onclick="openQr({{ $item->id }})"
                                                class="text-green-600 hover:text-green-900 transition"
                                                title="QR Code">
                                                <!-- svg sama seperti sebelumnya -->
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            </a>

                                            <!-- Hapus: gunakan button yang memanggil JS deleteWithConfirm(id) -->
                                            <form method="POST" class="inline" onsubmit="return false;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    onclick="deleteWithConfirm({{ $item->id }})"
                                                    class="text-red-600 hover:text-red-900 transition" title="Hapus">
                                                    <!-- svg trash -->
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada acara</h3>
                                        <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat acara baru.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.acara.create') }}"
                                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Acara
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($acara->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $acara->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="modalDetail" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 lg:w-3/4 xl:w-1/2 rounded-lg shadow-lg">
            <div class="p-5 border-b">
                <h3 class="text-xl font-semibold">Detail Acara</h3>
            </div>

            <div id="modalBody" class="p-5 max-h-[70vh] overflow-y-auto">
                Loading...
            </div>

            <div class="p-4 border-t text-right">
                <button onclick="closeDetail()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-800">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- BLADE VIEW (list.blade.php) - Tambahan Modal EDIT -->
    <!-- ===================================================================== -->
    <div id="modalEdit" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 lg:w-1/2 rounded-lg shadow-lg">
            <div class="p-5 border-b">
                <h3 class="text-xl font-semibold">Edit Acara</h3>
            </div>


            <form id="formEdit" class="p-5 space-y-4">
                <input type="hidden" id="edit_id">


                <div>
                    <label>Nama Acara</label>
                    <input id="edit_nama_acara" class="w-full border rounded p-2" />
                </div>


                <div>
                    <label>Lokasi</label>
                    <input id="edit_lokasi" class="w-full border rounded p-2" />
                </div>


                <div id="edit_pegawai_wrapper" class="hidden">
                    <label>Pegawai (Khusus)</label>
                    <select id="edit_pegawai" multiple class="w-full"></select>
                </div>


                <div class="text-right border-t pt-4">
                    <button type="button" onclick="closeEdit()"
                        class="px-4 py-2 bg-gray-600 text-white rounded">Tutup</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal QR -->
    <div id="modalQr" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white w-11/12 sm:w-3/4 md:w-1/2 rounded-lg shadow-lg overflow-hidden">
            <div class="p-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">QR Code</h3>
                <button onclick="closeQr()" class="text-gray-600 hover:text-gray-900">&times;</button>
            </div>

            <div id="modalQrBody" class="p-6 text-center">
                <div id="modalQrLoading" class="py-6">Loading...</div>
                <div id="modalQrContent" class="hidden">
                    <img id="modalQrImage" src="" alt="QR Code" class="mx-auto border rounded"
                        style="width:200px;height:200px" />
                    <div class="mt-4 flex items-center justify-center space-x-3">
                        <a id="modalQrDownload" href="#" download
                            class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Download</a>
                        <button onclick="closeQr()"
                            class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-800">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        function showDetail(id) {

            // tampilkan dulu modal + loading
            document.getElementById('modalDetail').classList.remove('hidden');
            document.getElementById('modalBody').innerHTML = "<div class='text-center py-6'>Loading...</div>";

            fetch(`/admin/acara/detail/${id}`)
                .then(res => res.json())
                .then(res => {

                    if (!res.success) return;

                    let acara = res.data;

                    let html = `
            <div class="space-y-4">

                <div>
                    <h4 class="font-bold text-lg">${acara.nama_acara}</h4>
                    <p class="text-sm text-gray-500">${acara.tanggal_waktu}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><b>Lokasi:</b> ${acara.lokasi}</div>
                    <div><b>Tipe Audiens:</b> ${acara.tipe_audiens}</div>
                    <div><b>Status:</b> ${acara.status}</div>
                    <div><b>QR Token:</b> ${acara.qr_token}</div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg text-center">
                    <h4 class="font-semibold mb-3">QR Code</h4>
            `;

                    // ==============================
                    // FIX PENENTUAN URL QR IMAGE
                    // ==============================
                    if (acara.qr_image_url) {

                        // convert ke URL absolut
                        let fullUrl = acara.qr_image_url.startsWith('http') ?
                            acara.qr_image_url :
                            window.location.origin + '/' + acara.qr_image_url.replace(/^\/+/, '');

                        html += `
                    <img src="${fullUrl}" alt="QR Code"
                         class="w-48 h-48 mx-auto border border-gray-300 rounded" />
                `;
                    } else {
                        html += `
                <div class="p-6 bg-yellow-50 border border-yellow-200 rounded text-yellow-700 text-sm">
                    <p>⚠️ Tidak ada QR Code</p>
                </div>`;
                    }

                    html += `
            </div>
            `;

                    // Jika tipe khusus → tampilkan undangan
                    if (acara.tipe_audiens === 'KHUSUS') {

                        html += `
                        <div class="mt-6">
                            <h4 class="font-semibold mb-2">Daftar Undangan</h4>
                            <table class="w-full text-sm border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="p-2 border">Nama Pegawai</th>
                                        <th class="p-2 border">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                            `;

                        acara.undangan.forEach(u => {
                            html += `
                            <tr>
                                <td class="p-2 border">${u.pegawai?.orang?.nama ?? '-'}</td>
                                <td class="p-2 border">${u.pegawai?.unit?.nama ?? '-'}</td>
                            </tr>
                            `;
                        });

                        html += `
                                </tbody>
                            </table>
                        </div>
                        `;
                    }

                    html += `</div>`;

                    document.getElementById('modalBody').innerHTML = html;
                });
        }


        function closeDetail() {
            document.getElementById('modalDetail').classList.add('hidden');
        }

        function openEdit(id) {

            // buka modal
            document.getElementById('modalEdit').classList.remove('hidden');

            // tampilkan loading dikit
            document.getElementById('edit_nama_acara').value = "Loading...";
            document.getElementById('edit_lokasi').value = "Loading...";

            fetch(`/admin/acara/edit/${id}`)
                .then(res => res.json())
                .then(res => {

                    let acara = res.acara;
                    let pegawai = res.pegawai;

                    // isi form
                    document.getElementById('edit_id').value = acara.id;
                    document.getElementById('edit_nama_acara').value = acara.nama_acara;
                    document.getElementById('edit_lokasi').value = acara.lokasi;

                    // select pegawai
                    let select = document.getElementById('edit_pegawai');
                    select.innerHTML = "";

                    pegawai.forEach(p => {
                        let option = document.createElement('option');
                        option.value = p.id;
                        option.text = `${p.orang?.nama ?? ''} - ${p.unit?.nama ?? ''}`;
                        select.appendChild(option);
                    });

                    // kalau audiens KHUSUS → tampilkan Selectize
                    if (acara.tipe_audiens === 'KHUSUS') {

                        document.getElementById('edit_pegawai_wrapper').classList.remove('hidden');

                        let selectedIDs = acara.undangan.map(u => u.id_pegawai);

                        // harus reset dulu
                        if ($('#edit_pegawai')[0].selectize) {
                            $('#edit_pegawai')[0].selectize.destroy();
                        }

                        $('#edit_pegawai').selectize({
                            plugins: ['remove_button'],
                            persist: false,
                            create: false
                        });

                        let sel = $('#edit_pegawai')[0].selectize;
                        sel.setValue(selectedIDs);
                    }
                });
        }


        // Submit update

        document.getElementById('formEdit').addEventListener('submit', function(e) {
            e.preventDefault();

            let id = document.getElementById('edit_id').value;
            let data = new FormData();

            data.append('nama_acara', document.getElementById('edit_nama_acara').value);
            data.append('lokasi', document.getElementById('edit_lokasi').value);

            let pegawaiSelectize = $('#edit_pegawai')[0]?.selectize;
            if (pegawaiSelectize) {
                let values = pegawaiSelectize.getValue();
                values.forEach(v => data.append('pegawai[]', v));
            }

            fetch(`/admin/acara/update/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: data
                })
                .then(res => res.json())
                .then(res => {

                    // ❌ gagal
                    if (!res.success) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: res.message ?? 'Terjadi kesalahan saat menyimpan data.',
                            confirmButtonColor: '#d33'
                        });
                        return;
                    }

                    // ✅ berhasil
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data acara berhasil diperbarui.',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        closeEdit(); // tutup modal
                        location.reload(); // reload halaman
                    });

                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Tidak dapat terhubung ke server.',
                        confirmButtonColor: '#d33'
                    });
                });
        });


        function closeEdit() {
            document.getElementById('modalEdit').classList.add('hidden');
        }

        // Pastikan SweetAlert2 sudah tersedia (kamu sudah load file sweetalert2.min.js)
        // Fungsi openQr(id) -> fetch detail and show QR modal
        function openQr(id) {
            // show modal + loading
            document.getElementById('modalQr').classList.remove('hidden');
            document.getElementById('modalQrLoading').classList.remove('hidden');
            document.getElementById('modalQrContent').classList.add('hidden');
            document.getElementById('modalQrImage').src = '';

            fetch(`/admin/acara/detail/${id}`)
                .then(r => r.json())
                .then(res => {
                    if (!res.success) {
                        document.getElementById('modalQrLoading').innerHTML =
                            "<div class='text-yellow-600'>Data tidak ditemukan</div>";
                        return;
                    }

                    const acara = res.data;
                    const qrUrl = acara.qr_image_url; // controller harus mengirim absolute URL (see earlier)
                    if (!qrUrl) {
                        document.getElementById('modalQrLoading').innerHTML =
                            "<div class='text-yellow-600'>⚠️ Tidak ada QR Code</div>";
                        return;
                    }

                    // set image src dan download link
                    const img = document.getElementById('modalQrImage');
                    img.src = qrUrl;
                    img.onload = function() {
                        document.getElementById('modalQrLoading').classList.add('hidden');
                        document.getElementById('modalQrContent').classList.remove('hidden');
                    };
                    img.onerror = function() {
                        document.getElementById('modalQrLoading').innerHTML =
                            "<div class='text-red-600'>Gagal memuat gambar</div>";
                    };

                    // set download link
                    const downloadLink = document.getElementById('modalQrDownload');
                    // buat nama file yang ramah
                    const filename = (acara.qr_token ? acara.qr_token : 'qr') + '.png';
                    downloadLink.href = qrUrl;
                    downloadLink.setAttribute('download', filename);
                })
                .catch(err => {
                    document.getElementById('modalQrLoading').innerHTML =
                        "<div class='text-red-600'>Terjadi kesalahan</div>";
                    console.error(err);
                });
        }

        function closeQr() {
            document.getElementById('modalQr').classList.add('hidden');
            document.getElementById('modalQrLoading').classList.remove('hidden');
            document.getElementById('modalQrContent').classList.add('hidden');
            document.getElementById('modalQrImage').src = '';
        }

        // ===== Delete with SweetAlert and AJAX =====
        function deleteWithConfirm(id) {
            // tampilkan konfirmasi
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data acara dan QR akan dihapus permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (!result.isConfirmed) return;

                // kirim request DELETE ke server
                fetch(`/admin/acara/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: data.message ?? 'Acara berhasil dihapus',
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                // opsi: reload halaman atau hapus baris tabel via DOM
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message ?? 'Gagal menghapus acara'
                            });
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan koneksi'
                        });
                    });
            });
        }
    </script>

</x-app-layout>
