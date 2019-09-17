<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function articles()
    {
    	return $this->hasMany('App\Article');
    }
}
