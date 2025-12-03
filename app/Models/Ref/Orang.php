<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class Orang extends Model
{
    protected $table = 'ms_orang';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $connection = 'ref';

    protected $fillable = [
        'id_sync',
        'no_ktp',
        'no_kk',
        'nama',
        'foto',
        'gelar_depan',
        'gelar_belakang',
        'tmpt_lahir',
        'tgl_lahir',
        'tinggi',
        'berat',
        'gol_darah',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'email',
        'status_nikah',
        'tipe'
    ];
}
