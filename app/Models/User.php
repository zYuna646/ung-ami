<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('/storage/avatars/' . $this->avatar) : asset('/images/avatar-placeholder.jpg');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function isAdmin(): bool
    {
        return isset($this->admin);
    }

    public function auditor()
    {
        return $this->hasOne(Auditor::class);
    }

    public function isAuditor(): bool
    {
        return isset($this->auditor);
    }
}
