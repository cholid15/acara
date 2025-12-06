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
        $path = "qrcodes/{$filename}";

        // Jika file ada → ambil URL publik melalui Storage::url()
        if (Storage::disk('public')->exists($path)) {
            $acara->qr_image_url = Storage::url($path);  // otomatis --> /storage/qrcodes/xxx.png
        } else {
            $acara->qr_image_url = null;
        }

        return response()->json([
            'success' => true,
            'data'    => $acara
        ]);
    }
}
