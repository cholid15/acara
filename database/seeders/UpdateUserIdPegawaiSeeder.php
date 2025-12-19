<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ref\Pegawai;

class UpdateUserIdPegawaiSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua pegawai + relasi orang
        Pegawai::with(['orang:id,no_ktp'])
            ->chunk(200, function ($pegawais) {

                foreach ($pegawais as $pegawai) {
                    if (!$pegawai->orang) continue;

                    $noKtp = $pegawai->orang->no_ktp;

                    if (!$noKtp) continue;

                    // cari user berdasarkan username = no_ktp
                    $user = User::where('username', $noKtp)->first();

                    if ($user) {
                        $user->id_pegawai = $pegawai->id;
                        $user->save();
                    }
                }
            });
    }
}
