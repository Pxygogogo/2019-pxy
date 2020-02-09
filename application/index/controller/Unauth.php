<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class UnAuth extends Controller
{
    //
    public function index()
    {
        //获取用户信息左上角图标
        $user = null;
        $admin_id = Request::instance()->session('admin_id');
        try {
            $user = Db::table('admin')->where('admin_id', $admin_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($user) {
            $this->assign('user', $user);
        }
        return $this->fetch();
    }
}
