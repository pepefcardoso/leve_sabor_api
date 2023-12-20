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

}
