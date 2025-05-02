<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiInsight extends Model
{
    use HasFactory;

    protected $fillable = [
        'observasi_id',
        'insight',
        'rekomendasi',
    ];

    public function observasi()
    {
        return $this->belongsTo(Observasi::class, 'observasi_id');
    }
}
