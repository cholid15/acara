<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ref\Pegawai;
use Illuminate\Support\Facades\Hash;

class PegawaiUserSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua pegawai + relasi orang
        $pegawais = Pegawai::with('orang')->get();

        foreach ($pegawais as $pegawai) {
            if (!$pegawai->orang) continue;

            $noKtp = $pegawai->orang->no_ktp;
            $nama  = $pegawai->orang->nama;

            // Skip jika no_ktp kosong
            if (!$noKtp) continue;

            // Cek jika user sudah ada
            $existing = User::where('username', $noKtp)->first();
            if ($existing) continue;

            // Insert user baru
            $user = User::create([
                'name'     => $nama,
                'username' => $noKtp,
                // 'email'    => $noKtp . '@example.com',
                'email'    => null,
                'password' => Hash::make($noKtp),
            ]);

            // Tambahkan role jika pakai Spatie Permission
            if ($user && method_exists($user, 'assignRole')) {
                $user->assignRole('user');
            }
        }
    }
}
