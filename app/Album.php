<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use Presenters\AlbumPresenter;
    protected $fillable = ['name', 'user_id'];
    protected $with = ['user', 'photos'];
    protected $appends = ['storage_path'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
