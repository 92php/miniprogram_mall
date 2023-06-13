<?php

namespace app\api\model;


class User extends BaseModel
{
    //user表中没有和user_address关联外键 就用 hasOne
    public function address()
    {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openid)
    {
        $user = self::where('openid', '=', $openid)->find();
        return $user;
    }
}
