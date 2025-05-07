<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoachingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengawas_id',
        'observasi_id',
        'kepsek_id',
        'tanggal',
        'topik_diskusi',
        'hasil_refleksi',
    ];

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rtls()
    {
        return $this->hasMany(Rtl::class, 'session_id');
    }

    public function observasi(): BelongsTo
    {
        return $this->belongsTo(Observasi::class, 'observasi_id');
    }
}
