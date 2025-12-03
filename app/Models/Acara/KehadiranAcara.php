<?php

namespace App\Models\Acara;

use Illuminate\Database\Eloquent\Model;

class KehadiranAcara extends Model
{
    protected $table = 'kehadiran_acara';
    protected $primaryKey = 'id';

    protected $fillable = [
        'acara_id',
        'user_id',
        'nama_tamu',
        'instansi_tamu',
        'waktu_scan',
        'device_info',
        'gps_lokasi',
    ];

    public $timestamps = false; // karena tabel kehadiran biasanya log tanpa created_at / updated_at
}
