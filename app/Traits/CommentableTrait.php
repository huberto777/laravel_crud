<?php

namespace App\Traits;

trait CommentableTrait
{
	public function isCommented()
	{
		return $this->comments()->where('user_id', \Auth::user()->id ?? null)->exists();
	}
}
