<?php

namespace App\Models\Ref;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'ms_unit';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $connection = 'ref';

    protected $fillable = [
        'id_sync',
        'id_parent',
        'nama',
        'alias',
        'level'
    ];

    // Relasi self-parent
    // public function induk()
    // {
    //     return $this->belongsTo(Unit::class, 'induk_id');
    // }

    // public function children()
    // {
    //     return $this->hasMany(Unit::class, 'induk_id');
    // }
}
