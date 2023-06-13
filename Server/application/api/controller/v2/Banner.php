<?php

namespace app\api\controller\v2;


use app\api\model\BaseModel;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\IDMustBePositive;
use app\api\model\Banner as BannerModel;
use app\api\validate\TestValidate;
use app\lib\exception\BannerMissException;
use think\Exception;
use think\Validate;

class Banner
{

    public function getBanner($id)
    {
        return "this is v2 version";
    }
}
