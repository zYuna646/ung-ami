<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function getRouteKeyName(): string
    {
        return 'email';
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->password = Hash::make($model->password ?? 'ami.ung');
        });
        self::updating(function ($model) {
            if ($model->isDirty('password') && $model->password) {
                $model->password = Hash::make($model->password);
            } else {
                $model->password = $model->getOriginal('password');
            }
        });
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('/storage/avatars/' . $this->avatar) : asset('/images/avatar.png');
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

    public function isAuditee(): bool
    {
        return isset($this->unit) || isset($this->faculty) || isset($this->program);
    }

    public function entityId()
    {
        if (isset($this->unit)) {
            return $this->unit->id;
        } else if (isset($this->faculty)) {
            return $this->faculty->id;
        } else if (isset($this->program)) {
            return $this->program->id;
        } else {
            return 'Unknown';
        }
    }

    public function entityType()
    {
        if (isset($this->unit)) {
            return 'Unit';
        } else if (isset($this->faculty)) {
            return 'Faculty';
        } else if (isset($this->program)) {
            return 'Program';
        } else {
            return 'Unknown';
        }
    }

    public function unit()
    {
        return $this->hasOne(Unit::class);
    }

    public function isUnit(): bool
    {
        return isset($this->unit);
    }

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    public function isFaculty(): bool
    {
        return isset($this->faculty);
    }

    public function department()
    {
        return $this->hasOne(Department::class);
    }

    public function isDepartment(): bool
    {
        return isset($this->department);
    }

    public function program()
    {
        return $this->hasOne(Program::class);
    }

    public function isProgram(): bool
    {
        return isset($this->program);
    }
}
