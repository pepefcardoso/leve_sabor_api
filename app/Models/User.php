<?php

namespace App\Models;

use App\Services\UserImages\TemporaryUrlUserImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'birthday',
        'phone',
        'cpf',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static public function rules()
    {
        return [
            'name' => 'nullable|string|min:3|max:99|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'birthday' => 'nullable|date|before:today',
            'phone' => 'nullable|string|regex:/^\(\d{2}\)\s?\d{4,5}-\d{4}$/|unique:users,phone',
            'cpf' => 'nullable|string|size:14|regex:/^\d{3}\.?\d{3}\.?\d{3}-?\d{2}$/|unique:users,cpf',
            'password' => 'required|string|min:8|max:99',
            'role_id' => 'nullable|integer|exists:roles,id',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,svg',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function temporaryUrlProfilePic(): Attribute
    {
        return Attribute::make(
            get: function () {
                $userImage = $this->userImage;

                if ($userImage) {
                    $temporaryUrlUserImage = app(TemporaryUrlUserImage::class);

                    return $temporaryUrlUserImage->temporaryUrl($userImage);
                }

                return null;
            }
        );
    }

    public function userImage()
    {
        return $this->hasOne(UserImage::class);
    }

    public function business()
    {
        return $this->hasMany(Business::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function favoriteBusinesses()
    {
        return $this->belongsToMany(Business::class, 'rl_user_favorite_businesses', 'user_id', 'business_id');
    }

    public function isAdmin(): bool
    {
        return $this->role->name === 'ADMIN';
    }
}
