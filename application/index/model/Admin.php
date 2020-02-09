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

    //修改密码
    public function pass($input)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'password' => 'require',
            'new_pass' => 'require',
            'confirm_pass' => 'require|confirm:new_pass'
        ], [
            'password.require' => '请输原密码！',
            'new_pass.require' => '请输入新密码！',
            'confirm_pass.require' => '请输入确认密码!',
            'confirm_pass.confirm' => '确认密码与新密码不一致!'
        ]);
        $dt = [
            'password' => $input['password'],
            'new_pass' => $input['new_pass'],
            'confirm_pass' => $input['confirm_pass']
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.原始密码是否正确
        $userinfo = null;
        try {
            $userinfo = Db::table('admin')->where('admin_id', session('admin_id'))->where('password', md5($input['password']))->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if (!$userinfo) {
            return ['valid' => 0, 'msg' => '原始密码不正确'];
        }
        //2.修改密码
        $res = null;
        try {
            $res = Db::table('admin')->where("admin_id", $userinfo['admin_id'])->update(['password' => md5($input['new_pass'])]);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库错误更新失败！'];
        }
        if ($res) {
            return ['valid' => 1, 'msg' => '密码修改成功'];
        } else {
            return ['valid' => 0, 'msg' => '修改密码失败'];
        }


    }

}
