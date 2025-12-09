<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Acara\Acara;

class AutoSelesaikanAcara extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acara:autoselesai';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Mengubah status acara menjadi SELESAI jika tanggal sudah lewat.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jumlah = Acara::where('status', 'AKTIF')
            ->where('tanggal_waktu', '<', now())
            ->update(['status' => 'SELESAI']);

        $this->info("$jumlah acara berhasil diubah menjadi SELESAI.");

        return Command::SUCCESS;
    }
}
