<?php

namespace App\Models\Acara;

use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    protected $table = 'acara';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nama_acara',
        'tanggal_waktu',
        'lokasi',
        'tipe_audiens',
        'filter_unit_id',
        'berulang',
        'aturan_berulang',
        'qr_token',
        'status',
    ];
}
