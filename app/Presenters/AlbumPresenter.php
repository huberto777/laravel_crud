<?php

namespace App\Presenters;

trait AlbumPresenter
{
    public function getStoragePathAttribute($value)
    {
        return asset("storage/{$value}");
    }
}

