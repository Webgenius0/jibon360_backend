<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'otp',
        'is_otp_verified',
        'otp_verified_at',
        'otp_expires_at',
        'remember_token',
        'email_verified_at',
        'is_social',
        'deleted_at',
        'created_at',
        'updated_at',
        'role',
        'status',
        'warraning',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'otp',
        'otp_expires_at',
        'is_otp_verified',
        'otp_verified_at',
        'deleted_at',
        'created_at',
        'updated_at',
        'role',
        'status',
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
    public function linkedSocialAccounts()
    {
        return $this->hasOne(LinkedSocialAccount::class);
    }
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function sos(): HasMany
    {
        return $this->hasMany(Sos::class);
    }
    public function circles(): BelongsToMany
    {
        return $this->belongsToMany(Circle::class, 'circle_users');
    }
    public function reaches(): HasMany
    {
        return $this->hasMany(Reach::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_users');
    }

}
