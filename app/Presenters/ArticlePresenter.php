<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Auth;

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
