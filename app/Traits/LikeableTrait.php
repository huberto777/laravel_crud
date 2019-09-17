<?php

namespace App\Traits;

trait LikeableTrait
{
    public function isLiked()
    {
        return $this->users()->where('user_id', \Auth::user()->id ?? null)->exists();
    }
}
