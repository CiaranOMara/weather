<?php

namespace App;

use App\Traits\HasPermissionAndRoleTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasPermissionAndRoleTrait, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'verification_token',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->verification_token = Str::random(60);;
        });
    }

    public static function register($attributes)
    {

        $attributes['password'] = bcrypt($attributes['password']);

        $user = static::create($attributes);

        event(new Registered($user));

        return $user;
    }

    /**
     * Role belongs to many users.
     *
     */
    public function triggers()
    {
        return $this->belongsToMany(Trigger::class)->withTimestamps();
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Str::lower($value);
    }

    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->verification_token = null;

        $this->save();
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return array
     */
    public function receivesBroadcastNotificationsOn()
    {
        return [
            new PrivateChannel('users.' . $this->id),
        ];
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}
