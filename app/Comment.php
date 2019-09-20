<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Presenters\CommentPresenter;

    // protected $primaryKey = 'id'; // or null
    // public $incrementing = false;
    protected $fillable = ['content', 'commentable_id', 'commentable_type', 'rating', 'user_id'];
    protected $appends = ['Incr'];
    protected $with = ['user'];

    // one to many polimorphic
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
