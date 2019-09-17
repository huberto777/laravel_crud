<?php

namespace App\Presenters;

trait CommentPresenter
{
	public function getRatingAttribute($value)
	{
		$str = '';

		for ($i=1; $i <= $value ; $i++) 
		{ 
			$rating = 'positive-rating';
			$str .= '<i class="fas fa-star '.$rating.'"></i>';
		}

		return $str;
	}
}

?>