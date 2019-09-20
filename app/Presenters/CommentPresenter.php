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
			$str .= '<i className="fas fa-star '.$rating.'"></i>';
		}

		return $str;
    }

    public function getIncrAttribute()
    {
        return 'SELECT `AUTO_INCREMENT` FROM `TABLES` WHERE `TABLE_SCHEMA` = "crud_01" AND `TABLE_NAME` = "comments"';
    }

}

?>
<!-- incr="{{"SELECT LAST_INSERT_ID('comments')"}}"
incr="{{'SELECT MAX(id) FROM comments'}}"
incr="{{DB::table('comments')->getPDO()->lastInsertId()}}"
incr="{{"SELECT auto_increment FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'Comments'"}}"
incr="{{\App\Comment::find('id')->last_insert_id() ?? false}}" -->
