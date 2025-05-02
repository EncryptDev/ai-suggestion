<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengawas_id',
        'kepsek_id',
        'tanggal',
        'topik_diskusi',
        'hasil_refleksi',
    ];

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function kepsek()
    {
        return $this->belongsTo(User::class, 'kepsek_id');
    }

    public function rtls()
    {
        return $this->hasMany(Rtl::class, 'session_id');
    }
}
