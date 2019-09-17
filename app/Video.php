<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //use Presenters\VideoPresenter;
    use Traits\LikeableTrait;
    use Traits\CommentableTrait;

    protected $fillable = ['title', 'url', 'description', 'user_id', 'created_at'];
    public $timestamps = false;
    protected $with = ['user', 'comments', 'tags', 'users'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // one to many polimorphic
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    // many to many polimorphic
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    public function users()
    {
        return $this->morphToMany('App\User', 'likeable');
    }
}
