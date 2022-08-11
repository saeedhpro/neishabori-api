<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jcc\LaravelVote\Traits\Voter;
use Laravel\Passport\HasApiTokens;
use Overtrue\LaravelFavorite\Traits\Favoriter;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Voter, Favoriter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'password',
        'sheba',
        'national_code',
        'job',
        'avatar',
        'is_legal',
        'birth_date',
        'role_id',
        'phone_number_verified_at',
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
        'phone_number_verified_at' => 'datetime',
        'is_legal' => 'bool',
    ];

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function organization()
    {
        return $this->hasOne(Organization::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role->id == Role::ADMIN;
    }

    public function isCustomer()
    {
        return $this->role->id == Role::CUSTOMER;
    }
}
