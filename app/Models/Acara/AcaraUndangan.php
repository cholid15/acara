<?php

namespace App\Models\Acara;

use Illuminate\Database\Eloquent\Model;

class AcaraUndangan extends Model
{
    protected $table = 'acara_undangan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'acara_id',
        'id_pegawai',
        'user_id',
    ];

    public function acara()
    {
        return $this->belongsTo(
            Acara::class,
            'acara_id', // FK BENAR
            'id'
        );
    }


    public function pegawai()
    {
        return $this->belongsTo(\App\Models\Ref\Pegawai::class, 'id_pegawai', 'id');
    }
}
