<?php

namespace app\index\model;

use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;
use think\Validate;

class User extends Model
{
    //

    public function addUser($data)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'username' => 'require',
            'password' => 'require'
        ], [
            'username.require' => '请输入用户名称！',
            'password.require' => '请输入初始密码!'
        ]);
        $dt = [
            'username' => $data['username'],
            'password' => $data['password']
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.先判断用户是否存在
        //2.不存在则插入
        //3.存在则提示其修改
        $flag = null;
        try {
            $flag = Db::table('user')->where('username', $data['username'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '用户已存在，请勿重复添加！'];
        } else {
            //加工数据符合数据库字段要求
            switch ($data['role']) {
                case 'service_person':
                    $data['role_name'] = '客服';
                    break;
                case 'assessor':
                    $data['role_name'] = '审核员';
                    break;
                case 'basic_person':
                    $data['role_name'] = '基础数据管理员';
                    break;
                case 'dba':
                    $data['role_name'] = '系统管理员';
                    break;
            }
            $data['password'] = md5($data['password']);
            unset($data['role']);
            if (Db::table('user')->insert($data)) {
                return ['valid' => 1, 'msg' => '添加成功！'];
            } else {
                return ['valid' => 0, 'msg' => '添加失败！'];
            }

        }


    }

    public function findData()
    {
        //页面加载时渲染数据库已有数据
        $data = null;
        try {
            $data = Db::table('user')->order('user_id desc')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        if ($data !== null) {
            return $data;
        } else {
            return null;
        }


    }

    public function del($user_id)
    {
        try {
            $res = Db::table('user')->where('user_id', $user_id)->delete();
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        if ($res === 1) {
            return ['valid' => 1, 'msg' => '删除成功！'];
        } else {
            return ['valid' => 0, 'msg' => '删除失败！'];
        }
    }


    public function updateData($dt)
    {
        //数据符合数据库字段
        if ($dt['role_name'] === 'service_person') {
            $dt['role_name'] = '客服';
        } elseif ($dt['role_name'] === 'assessor') {
            $dt['role_name'] = '审核员';
        } elseif ($dt['role_name'] === 'basic_person') {
            $dt['role_name'] = '基础数据管理员';
        } elseif ($dt['role_name'] === 'dba') {
            $dt['role_name'] = '系统管理员';
        }
        try {
            $res = Db::table('user')->where('user_id', $dt['user_id'])->update($dt);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($res === 0) {
            return ['valid' => 1, 'msg' => '您未做任何修改！'];
        } else if ($res) {
            return ['valid' => 1, 'msg' => '修改成功！'];
        } else {
            return ['valid' => 0, 'msg' => '修改失败！'];

        }
    }

    //按关键词搜索
    public function searchBy($input)
    {
        $keywords = $input['keywords'];
        $nameRes = null;
        $roleRes = null;
        try {
            $nameRes = Db::table('user')->where('username', 'like', '%' . $keywords . '%')->select();
            $roleRes = Db::table('user')->where('role_name', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($nameRes, $roleRes);
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['user_id']])) {
                unset($value['user_id']);  //有：销毁
            } else {
                $res[$value['user_id']] = $value;
            }
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }

    }


}
