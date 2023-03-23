<?php

namespace App\Models;

use App\Enum\UserSexEnum;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Traits\HasRolesAndPermissions;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'avatar',
        'phone',
        'status',
        'sex',
        'birthday',
        'description',
        'categories'
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
    ];

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');;
    }

    public function hasVerified()
    {
        return null !== $this->attributes['verified_user'];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            'name' => 'required|string|max:255|',
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->id,
            'phone' => 'required|numeric|min:10|unique:users,phone,'.$this->id,
            'status' => 'string|max:255|',
            'description' => 'string',
            'sex' => ['required', new Enum(UserSexEnum::class)],
            'birthday'=> 'required|date|before:tomorrow',
        ];
    }


    /**
     * @return array
     */
    public function getMessages(): array
    {
        return [
            'email.required' => 'Email должен быть заполнен',
        ];
    }





}
