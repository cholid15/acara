<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\acara\Acara;
use App\Models\acara\AcaraUndangan;
use App\Models\ref\Pegawai;
use App\Models\ref\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class AcaraController extends Controller
{
    public function create()
    {
        $unit = Unit::where('level', 1)->orderBy('nama')->get();

        $pegawai = Pegawai::with(['orang', 'unit'])
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($p) {
                return [
                    'value' => $p->id,
                    'text'  => ($p->orang->nama ?? 'Tanpa Nama') . ' — ' . ($p->unit->nama ?? 'Tanpa Unit')
                ];
            });

        return view('admin.acara.create', compact('pegawai', 'unit'));
    }


    public function getPegawaiByUnit($unitId)
    {
        $pegawai = Pegawai::where('id_unit', $unitId)
            ->with(['orang', 'unit'])
            ->get()
            ->map(function ($p) {
                return [
                    'value' => $p->id,
                    'text'  => ($p->orang->nama ?? 'Tanpa Nama') . ' — ' . ($p->unit->nama ?? 'Tanpa Unit')
                ];
            });

        return response()->json($pegawai);
    }



    public function storebackup(Request $request)
    {
        $request->validate([
            'nama_acara'     => 'required|string',
            'tanggal_waktu'  => 'required|date',
            'lokasi'         => 'required|string',
            'tipe_audiens'   => 'required',
            'pegawai'        => 'array'
        ]);

        $acara = Acara::create([
            'nama_acara'    => $request->nama_acara,
            'tanggal_waktu' => $request->tanggal_waktu,
            'lokasi'        => $request->lokasi,
            'tipe_audiens'  => $request->tipe_audiens,
            'qr_token'      => Str::uuid(),
        ]);

        /* ===============================================================
           GENERATE QR CODE dengan chillerlan/php-qrcode (TANPA imagick/gd)
        ================================================================*/
        try {
            // Log untuk debugging
            // Log::info("Mulai generate QR Code untuk acara ID: {$acara->id}");

            // Pastikan folder qrcodes ada
            $qrcodesPath = storage_path('app/public/qrcodes');
            if (!file_exists($qrcodesPath)) {
                mkdir($qrcodesPath, 0755, true);
                // Log::info("Folder qrcodes dibuat: {$qrcodesPath}");
            }

            // Pastikan folder qrcodes ada di Storage facade
            if (!Storage::disk('public')->exists('qrcodes')) {
                Storage::disk('public')->makeDirectory('qrcodes');
                // Log::info("Folder qrcodes dibuat via Storage facade");
            }

            // URL yang di-encode dalam QR
            $qrUrl = url("/acara/qr/{$acara->qr_token}");
            // Log::info("QR URL: {$qrUrl}");

            // ✅ SOLUSI: chillerlan/php-qrcode - Generate PNG langsung tanpa imagick!
            $options = new QROptions([
                'version'             => QRCode::VERSION_AUTO,  // Auto-detect ukuran yang pas
                'outputType'          => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'            => QRCode::ECC_H,  // Error correction HIGH
                'scale'               => 10,             // Pixel per module
                'imageBase64'         => false,          // Output raw binary, bukan base64
                'imageTransparent'    => false,          // Background tidak transparan
            ]);

            $qrcode = new QRCode($options);
            $png = $qrcode->render($qrUrl);

            // Validasi apakah PNG berhasil di-generate
            if (empty($png)) {
                throw new \Exception("QR Code generation returned empty data");
            }

            // Log::info("QR Code PNG berhasil di-generate, size: " . strlen($png) . " bytes");

            // Nama file
            $filename = $acara->qr_token . '.png';
            $path = "qrcodes/{$filename}";

            // Simpan file PNG ke storage/app/public/qrcodes
            $saved = Storage::disk('public')->put($path, $png);

            if (!$saved) {
                throw new \Exception("Failed to save QR Code to storage");
            }

            // Log::info("QR Code berhasil disimpan ke: {$path}");

            // Verifikasi file benar-benar ada
            if (Storage::disk('public')->exists($path)) {
                // set public visibility
                Storage::disk('public')->setVisibility($path, 'public');
                // Log::info("QR Code visibility set to public");

                // Dapatkan full path untuk konfirmasi.
                $fullPath = storage_path('app/public/' . $path);

                // Log::info("Full path QR Code: {$fullPath}");
                // Log::info("File exists check: " . (file_exists($fullPath) ? 'YES' : 'NO'));
                // Log::info("File size: " . (file_exists($fullPath) ? filesize($fullPath) : 0) . " bytes");
            } else {
                throw new \Exception("File verification failed - QR Code not found after save");
            }

            // Pastikan symlink public/storage ada
            $symlinkPath = public_path('storage');
            if (!file_exists($symlinkPath)) {
                Artisan::call('storage:link');
                // Log::info("Storage link created");
            }

            // Verifikasi symlink
            // if (is_link($symlinkPath)) {
            //     Log::info("Symlink verified: " . readlink($symlinkPath));
            // } else {
            //     Log::warning("Symlink might not be properly created");
            // }
        } catch (\Exception $e) {
            // Log error lengkap
            // Log::error("QR Code generation FAILED for acara ID {$acara->id}", [
            //     'message' => $e->getMessage(),
            //     'file' => $e->getFile(),
            //     'line' => $e->getLine(),
            //     'trace' => $e->getTraceAsString()
            // ]);

            // Tampilkan error ke user (untuk development)
            // Untuk production, uncomment baris return di bawah
            // return redirect()->back()->withErrors(['qr_error' => 'Gagal membuat QR Code: ' . $e->getMessage()]);
        }

        /* ===============================================================
           SIMPAN UNDANGAN
        ================================================================*/
        if ($request->pegawai) {
            foreach ($request->pegawai as $pegawaiID) {
                AcaraUndangan::create([
                    'acara_id'   => $acara->id,
                    'id_pegawai' => $pegawaiID
                ]);
            }
        }

        return redirect()->route('admin.acara.create')
            ->with('success', 'Acara berhasil dibuat!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_acara'     => 'required|string',
            'tanggal_waktu'  => 'required|date',
            'lokasi'         => 'required|string',
            'tipe_audiens'   => 'required',
            'pegawai'        => 'array'
        ]);

        $acara = Acara::create([
            'nama_acara'    => $request->nama_acara,
            'tanggal_waktu' => $request->tanggal_waktu,
            'lokasi'        => $request->lokasi,
            'tipe_audiens'  => $request->tipe_audiens,
            'qr_token'      => Str::uuid(),
        ]);

        /* ===============================================================
       GENERATE QR CODE LANGSUNG KE /public/qrcodes/ (tanpa storage)
        ================================================================*/
        try {

            // Pastikan folder public/qrcodes ada
            $publicQRPath = public_path('qrcodes');
            if (!file_exists($publicQRPath)) {
                mkdir($publicQRPath, 0755, true);
            }

            // URL yang di-encode
            $qrUrl = url("/acara/qr/{$acara->qr_token}");

            // Options QR
            $options = new QROptions([
                'version'          => QRCode::VERSION_AUTO,
                'outputType'       => QRCode::OUTPUT_IMAGE_PNG,
                'eccLevel'         => QRCode::ECC_H,
                'scale'            => 10,
                'imageBase64'      => false,
            ]);

            $qrcode = new QRCode($options);
            $png = $qrcode->render($qrUrl);

            if (empty($png)) {
                throw new \Exception("QR Code creation failed");
            }

            // Simpan ke public/qrcodes
            $filename = $acara->qr_token . '.png';
            $savePath = $publicQRPath . DIRECTORY_SEPARATOR . $filename;

            file_put_contents($savePath, $png);

            if (!file_exists($savePath)) {
                throw new \Exception("QR Code not saved to public path");
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['qr_error' => 'QR gagal dibuat: ' . $e->getMessage()]);
        }

        /* ===============================================================
       SIMPAN UNDANGAN
     ================================================================*/
        if ($request->pegawai) {
            foreach ($request->pegawai as $pegawaiID) {
                AcaraUndangan::create([
                    'acara_id'   => $acara->id,
                    'id_pegawai' => $pegawaiID
                ]);
            }
        }

        return redirect()->route('admin.acara.create')
            ->with('success', 'Acara berhasil dibuat!');
    }


    /**
     * Halaman Edit (dipanggil via AJAX)
     */
    public function edit($id)
    {
        $acara = Acara::with([
            'undangan.pegawai.orang',
            'undangan.pegawai.unit'
        ])->findOrFail($id);

        $pegawai = Pegawai::with(['orang', 'unit'])->get();

        return response()->json([
            'success' => true,
            'acara' => $acara,
            'pegawai' => $pegawai,
        ]);
    }



    /** UPDATE ACARA */
    public function update(Request $request, $id)
    {
        $acara = Acara::findOrFail($id);


        $request->validate([
            'nama_acara' => 'required|string',
            'lokasi' => 'required|string',
            'pegawai' => 'array',
        ]);


        $acara->update([
            'nama_acara' => $request->nama_acara,
            'lokasi' => $request->lokasi,
        ]);


        /* ============================
        Update Undangan (Jika KHUSUS)
        ============================= */
        if ($acara->tipe_audiens === 'KHUSUS') {
            AcaraUndangan::where('acara_id', $acara->id)->delete();


            if ($request->pegawai) {
                foreach ($request->pegawai as $p) {
                    AcaraUndangan::create([
                        'acara_id' => $acara->id,
                        'id_pegawai' => $p,
                    ]);
                }
            }
        }


        return response()->json(['success' => true]);
    }


    /**
     * DETAIL ACARA (AJAX JSON)
     */
    public function detail($id)
    {
        $acara = Acara::with([
            'undangan',
            'undangan.pegawai',
            'undangan.pegawai.orang',
            'undangan.pegawai.unit'
        ])->findOrFail($id);

        // Nama file QR
        $filename = $acara->qr_token . '.png';
        $relativePath = "qrcodes/{$filename}";  // disimpan di public/qrcodes/xxx.png
        $fullPath = public_path($relativePath);

        // cek file di public/qrcodes
        if (file_exists($fullPath)) {

            // URL publik (tanpa storage)
            $acara->qr_image_url = url($relativePath);
        } else {
            $acara->qr_image_url = null;
        }

        return response()->json([
            'success' => true,
            'data'    => $acara
        ]);
    }


    public function destroy($id)
    {
        // Cari acara
        $acara = Acara::find($id);
        if (!$acara) {
            return response()->json(['success' => false, 'message' => 'Data acara tidak ditemukan.'], 404);
        }

        try {
            // Hapus file QR dari public/qrcodes jika ada
            $filename = $acara->qr_token . '.png';
            $publicPath = public_path("qrcodes/{$filename}");
            if (file_exists($publicPath)) {
                @unlink($publicPath);
            }

            // Hapus undangan terkait
            AcaraUndangan::where('acara_id', $acara->id)->delete();

            // Hapus record acara
            $acara->delete();

            return response()->json(['success' => true, 'message' => 'Acara dan QR berhasil dihapus.']);
        } catch (\Exception $e) {
            Log::error('Failed to delete acara ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus acara: ' . $e->getMessage()], 500);
        }
    }
}
