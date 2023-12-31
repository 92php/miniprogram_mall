<?php

namespace app\api\validate;

use think\Validate;

class IDMustBePositive extends Validate
{
    protected $rule = [
        'id' => "require|isPositiveInteger"
    ];

    protected function isPositiveInteger($value, $rule = '', $data = '', $field = '')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }
}