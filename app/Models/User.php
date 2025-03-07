<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'username',
        'last_activity',
        'avatar',
        'super_admin',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles() :HasMany
    {
        return $this->hasMany(RoleUser::class,'user_id','id');
    }


    // Accessor
    public function getAvatarUrlAttribute() // $user->avatar-url
    {
        if($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('imgs/user.jpg');
    }

    public function medicine()
    {
        return $this->hasMany(Medicine::class);
    }

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }
}
