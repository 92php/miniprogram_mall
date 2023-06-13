<?php

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\CategoryException;
use app\lib\exception\MissException;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::all([], 'img');
        //$categories = CategoryModel::with('img')->select();
        //$categories = $categories->hidden(['img.update_time']);
        if (!$categories) {
            throw new CategoryException();
        }
        return $categories;
    }

    public function getCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $category = CategoryModel::getCategory($id);
        if (empty($category)) {
            throw new MissException([
                'msg' => 'category not found'
            ]);
        }
    }


}
