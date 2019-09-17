<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content','commentable_id','commentable_type','rating','user_id'];

    use Presenters\CommentPresenter;

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
