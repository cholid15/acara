<?php

namespace App\Models\Acara;

use Illuminate\Database\Eloquent\Model;

class AcaraUndangan extends Model
{
    protected $table = 'acara_undangan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'acara_id',
        'user_id',
    ];
}
