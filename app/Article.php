<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Presenters\ArticlePresenter;
    use Traits\LikeableTrait;
    use Traits\CommentableTrait;

    protected $fillable = ['title', 'slug', 'description', 'path', 'user_id', 'category_id', 'created_at'];
    public $timestamps = false;
    protected $with = ['category', 'comments', 'tags', 'user', 'users'];
    protected $appends = ['storage_path'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // one to many
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    // polimorphic one to many
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
