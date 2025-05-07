<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'npsn',
        'jenjang',
        'wilayah',
        'creator_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'sekolah_id');
    }

    public function observasis()
    {
        return $this->hasMany(Observasi::class, 'sekolah_id');
    }
}
