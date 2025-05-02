<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rtl extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'isi_rtl',
        'status',
        'tenggat',
    ];

    public function session()
    {
        return $this->belongsTo(CoachingSession::class, 'session_id');
    }
}