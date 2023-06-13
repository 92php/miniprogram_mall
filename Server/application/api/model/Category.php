<?php

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'create_time'];

    public function img()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public static function getCategory($id)
    {
        $category = self::where('id', '=', $id)->find();
        return $category;
    }

}
