<?php

namespace app\index\model;

use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;
use think\Request;
use think\Validate;

class Admin extends Model
{
    protected $table = 'admin';
    protected $pk = 'admin_id';

    //登录
    public function login($data)
    {
//        halt($data);
        //1.执行验证
        $validate = new Validate([
            'username' => 'require',
            'password' => 'require'
        ], [
            'username.require' => '请输入用户名！',
            'password.require' => '请输入密码!'
        ]);
        $dt = [
            'username' => $data['username'],
            'password' => $data['password']
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //2.比对用户名密码是否正确
        //3.将用户信息存入session中
        try {
            $userinfo = $this->where('username', $data['username'])->where('password', md5($data['password']))->find();
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => $e];
        }
        if (!$userinfo) {
            return ['valid' => 0, 'msg' => '用户名或密码不正确'];
        } else {
            session('admin_id', $userinfo['admin_id']);
            session('username', $userinfo['username']);
            session('role', $userinfo['role']);
            return ['valid' => 1, 'msg' => '登录成功'];
        }


    }

}
