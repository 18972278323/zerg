<?php


namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden = ["topic_img_id","delete_time","update_time"];

    public function topicImg()
    {
        return $this->belongsTo('Image','topic_img_id','id');
    }
}