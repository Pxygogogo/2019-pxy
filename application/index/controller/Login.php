<?php

namespace app\index\controller;

use app\index\model\Admin;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if (request()->isPost()) {
            $res = (new Admin())->login(input('post.'));
            if ($res['valid']) {
                //登录成功
                $this->success($res['msg'], 'index/entry/index');
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }

        return $this->fetch();
    }
}
