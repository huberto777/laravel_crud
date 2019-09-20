<?php

namespace App\Presenters;

trait UserPresenter
{
    public function getStoragePathAttribute($value)
    {
        return asset("storage/{$value}");
    }

    public function getRoleAttribute()
    {
        return $this->roles()->get();
    }
}


