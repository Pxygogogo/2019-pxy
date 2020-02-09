<?php


namespace app\index\controller;

use app\index\model\Admin;
use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Entry extends Common
{
    public function index()
    {
        //获取用户信息
        $user = null;
        $user_id = Request::instance()->session('user_id');
        try {
            $user = Db::table('user')->where('user_id', $user_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($user) {
            $this->assign('user', $user);
        }
        return $this->fetch();
    }

    // 退出登录
    public function logout()
    {
        //销毁session
        session("user_id", NULL);
        session("username", NULL);
        session("role_name", NULL);
        //跳转页面
        $this->redirect('index/login/index');
    }

    //修改密码
    public function pass()
    {
        //获取用户信息
        $user = null;
        $user_id = Request::instance()->session('user_id');
        try {
            $user = Db::table('user')->where('user_id', $user_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($user) {
            $this->assign('user', $user);
        }
        //修改密码
        if (request()->isPost()) {
            $res = (new Admin())->pass(input('post.'));
            if ($res['valid']) {
                //清除session中的登录信息
                session(null);
                //执行成功
                $this->success($res['msg'], 'index/entry/index');
                exit;
            } else {
                //执行失败
                $this->error($res['msg']);
                exit;
            }
        }

        return $this->fetch();
    }

}