<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sekolah_id',
        'tanggal',
        'narasi_temuan',
        'file_pendukung',
        'prompt',
        'pengawas_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function aiInsights()
    {
        return $this->hasMany(AiInsight::class, 'observasi_id');
    }
}
