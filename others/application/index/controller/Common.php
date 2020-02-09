<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Common extends Controller
{
    //登录验证
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (!session('user_id')) {
            $this->redirect('index/login/index');
        }
        //获取用户信息左上角图标
        $user = null;
        $user_id = Request::instance()->session('user_id');
        try {
            $user = Db::table('admin')->where('user_id', $user_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($user) {
            $this->assign('user', $user);
        }
    }

    //$arr->传入数组   $key->判断的key值
    public function array_unset_tt($arr, $key)
    {
        //建立一个目标数组
        $res = array();
        foreach ($arr as $value) {
            //查看有没有重复项
            if (isset($res[$value[$key]])) {
                unset($value[$key]);  //有：销毁
            } else {
                $res[$value[$key]] = $value;
            }
        }
        return $res;
    }
}
