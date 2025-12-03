<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'ms_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $connection = 'ref';

    protected $fillable = [
        'id_orang',
        'id_sync',
        'id_unit',
        'id_upk',
        'id_homebase',
        'id_tipe',
        'id_hub',
        'nip_unit',
        'foto',
        'tgl_masuk',
        'tgl_pensiun',
        'status',
        'created_at',
        'updated_at'
    ];

    public function orang()
    {
        return $this->belongsTo(Orang::class, 'id_orang', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id_unit', 'id');
    }

    // opsional: jika mau pakai id_upk
    public function upk()
    {
        return $this->belongsTo(Unit::class, 'id_upk', 'id');
    }
}
