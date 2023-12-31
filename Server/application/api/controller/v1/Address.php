<?php

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\model\UserAddress;
use app\api\service\Token as TokenService;
use app\api\validate\NewAddress;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{

    //前置操作 可作为拦截器
    protected $beforeActionList = [
        'checkPrimaryScope' => [
            'only' => 'createOrUpdateAddress'
        ]
    ];


    public function createOrUpdateAddress()
    {
        $validate = new NewAddress();
        $validate->goCheck();
        //根据Token来获取uid
        $uid = TokenService::getCurrentUID();
        $user = UserModel::get($uid);
        if (!$user) {
            throw new UserException();
        }
        $userAddress = $user->address;
        // 根据规则取字段是很有必要的，防止恶意更新非客户端字段
        //$data = $validate->getDataByRule(Request::param());
        $data = $validate->getDataByRule(input('post.'));
        if (!$userAddress) {
            //$data['user_id'] = $uid;
            //UserAddress::create($data);
            // 关联属性不存在，则新建
            $user->address()->save($data);
        } else {
            // 存在则更新
            //fromArrayToModel($user->address, $data);
            // 新增的save方法和更新的save方法并不一样
            // 新增的save来自于关联关系 \think\model\relation\OneToOne.php
            // 更新的save来自于模型 \Server\thinkphp\library\think\Model.php
            //$a = $user->address()->find()->toArray();
            //$b = $user->address->toArray();
            $user->address->save($data);
        }
        //return $user;
        return json(new SuccessMessage([
            'msg' => '操作成功！'
        ]), 201);
    }


    /**
     * 获取用户地址信息
     * @return array
     * @throws UserException
     * @throws \think\exception\DbException
     */
    public function getUserAddress()
    {
        $uid = TokenService::getCurrentUID();
        $userAddress = UserAddress::where('user_id', '=', $uid)->find();
        if (!$userAddress) {
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }
}
