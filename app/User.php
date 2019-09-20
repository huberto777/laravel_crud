<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use Presenters\UserPresenter;
    protected $appends = ['storage_path', 'role'];

    public static $roles = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'path', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // one to many
    public function albums()
    {
        return $this->hasMany('App\Album', 'user_id');
    }

    public function articles()
    {
        return $this->hasMany('App\Article', 'user_id');
    }

    public function videos()
    {
        return $this->hasMany('App\Video', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id');
    }

    // many to many polimorphic (inverse)
    public function larticles()
    {
        return $this->morphedByMany('App\Article', 'likeable');
    }

    public function lvideos()
    {
        return $this->morphedByMany('App\Video', 'likeable');
    }

    // many to many
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }

    // method
    public function hasRole(array $roles)
    {
        foreach ($roles as $role) {
            if (isset(self::$roles[$role])) {
                if (self::$roles[$role]) return true;
            } else {
                self::$roles[$role] = $this->roles()->where('name', $role)->exists();

                if (self::$roles[$role]) return true;
            }
        }
        return false;
    }

}
