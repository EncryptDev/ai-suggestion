<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'sekolah_id',
        'creator_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id');
    }

    public function observasis()
    {
        return $this->hasMany(Observasi::class, 'user_id');
    }

    public function coachingSessionsPengawas()
    {
        return $this->hasMany(CoachingSession::class, 'pengawas_id');
    }

    public function coachingSessionsKepsek()
    {
        return $this->hasMany(CoachingSession::class, 'kepsek_id');
    }

    public function refleksis()
    {
        return $this->hasMany(Refleksi::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'creator_id');
    }
}
