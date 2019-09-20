<?php

namespace App\Presenters;
use Carbon\Carbon;

trait ArticlePresenter
{
	// ścieżka bezwzględna
    public function getStoragePathAttribute($value)
    {
    	return asset("storage/{$value}");
    }

 /*
    // ścieżka względna
    public function getPathAttribute()
    {
        return $this->original['path'];
    }
*/
}
