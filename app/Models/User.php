<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'role_id',
    'fullname',
    'email',
    'password',
    'phone',
    'address',
    'date_of_birth',
    'gender',
    'province_city',
    'status',
])]

#[Hidden(['password', 'remember_token'])]

class User extends Authenticatable implements FilamentUser, HasName
{
    protected $primaryKey = 'user_id';

    public $timestamps = false;

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;


     /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array((int) $this->role_id, [1, 2], true)
            && $this->status === 'active';
    }


    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }


    public function getFilamentName(): string
    {
        return (string) ($this->fullname ?? $this->email ?? 'Admin');
    }


    // User thuộc 1 Role
    public function role()
    {
        return $this->belongsTo(
            Role::class,
            'role_id',
            'role_id'
        );
    }


    // User có nhiều Notification
    public function notifications()
    {
        return $this->hasMany(
            Notification::class,
            'user_id',
            'user_id'
        );
    }
}
