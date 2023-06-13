<?php

namespace app\api\controller\v1;


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
    /**
     * 获得指定id的banner信息
     * @url     /banner/:id
     * @http    get
     * @param int $id banner id
     * @return  object
     * @throws  Exception
     * @throws  BannerMissException
     */
    public function getBanner($id)
    {
        //AOP 面向切面编程 具体：全局异常处理以及参数验证
        //代码不要太直白，抽象化

        //独立验证
        //验证器验证
        /*$data = [
            "name" => "test",
            'email' => "test@qq.com"
        ];
        //$validate = new Validate([
        //    "name" => "require|max:10",
        //    "email" => "email"
        //]);
        //$result = $validate->check($data);
        //$result = $validate->batch()->check($data);

        $validate = new TestValidate();
        $result = $validate->batch()->check($data);
        dump($validate->getError());
        dump($result);*/

        /*$data = [
            'id' => $id
        ];
        $validate = new IDMustBePositive();
        $result = $validate->batch()->check($data);
        if($result){

        }else{
            var_dump($validate->getError());
        }*/


        (new IDMustBePositiveInt())->goCheck();
        $banner = BannerModel::getBannerByID($id);

        // get find all select
        //$banner = BannerModel::get($id);
        //$banner = new BannerModel();
        //$banner = $banner->get($id);
        /*
        try {
            $banner = BannerModel::getBannerByID($id);
        }catch (Exception $e){
            $err = [
                'err_code' => 1001,
                'msg' => $e->getMessage()
            ];
            return json($err,400);
        }
        */

        //$banner->hidden(['delete_time','items.update_time']);

        //模型查询的最佳实践原则是：在模型外部使用静态方法进行查询，内部使用动态方法查询，包括使用数据库的查询构造器。模型的查询始终返回对象实例，但可以和数组一样使用。

        //静态调用（推荐）
        //$banner = BannerModel::with(['items','items.img'])->find($id);
        //实例化对象调用
        //$banner = new BannerModel();
        //$banner = $banner->get();

        if (!$banner) {
            throw new BannerMissException();
        }
        //return $banner->items[0]['img'];
        return $banner; //框架自动调用toArray
    }
}
