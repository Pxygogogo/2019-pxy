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

class Contact extends Model
{
    //
    public function addContact($input)
    {
        //0.判断用户是否存在非法输入

        $validate = new Validate([
            'name' => 'require',
            'title' => 'require',
            'phone' => 'require|length:11',
            'telephone' => 'require',
            'fax' => 'require',
            'email' => 'require|email',
        ], [
            'name.require' => '请输入联系人名字！',
            'title.require' => '请输入联系人称谓!',
            'phone.require' => '请输入联系人手机!',
            'phone.length' => '联系人手机为11位!',
            'telephone.require' => '请输入联系人电话!',
            'fax.require' => '请输入联系人传真!',
            'email.require' => '请输入邮箱地址!',
            'email.email' => '邮箱格式错误',
        ]);
        $dt = [
            'name' => $input['name'],
            'title' => $input['title'],
            'phone' => $input['phone'],
            'telephone' => $input['telephone'],
            'fax' => $input['fax'],
            'email' => $input['email'],
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.先判断联系人是否存在
        //2.不存在则插入
        //3.存在则提示其修改
        $flag = null;
        try {
            $flag = Db::table('contact')->where('name', $input['name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '联系人已存在，请勿重复添加！'];
        } else {
            if (Db::table('contact')->insert($input)) {
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
            $data = Db::table('contact')->order('contact_id asc')->select();
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

    public function updateData($input)
    {
        $res = null;
        try {
            $res = Db::table('contact')->where('contact_id', $input['contact_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($res) {
            return ['valid' => 1, 'msg' => '更新成功！'];
        } else {
            return ['valid' => 0, 'msg' => '更新失败！'];
        }
    }

    public function del($contact_id)
    {
        $res = null;
        try {
            $res = Db::table('contact')->where('contact_id', $contact_id)->delete();
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


    //按关键词搜索
    public function searchBy($input)
    {
        $keywords = $input['keywords'];
        $nameRes = null;
        $roleRes = null;
        try {
            $nameRes = Db::table('contact')->where('name', 'like', '%' . $keywords . '%')->select();
            $salutationRes = Db::table('contact')->where('title', 'like', '%' . $keywords . '%')->select();
            $mobile_phoneRes = Db::table('contact')->where('phone', 'like', '%' . $keywords . '%')->select();
            $telephoneRes = Db::table('contact')->where('telephone', 'like', '%' . $keywords . '%')->select();
            $faxRes = Db::table('contact')->where('fax', 'like', '%' . $keywords . '%')->select();
            $emailRes = Db::table('contact')->where('email', 'like', '%' . $keywords . '%')->select();
            $client_idRes = Db::table('contact')->where('custom_id', 'like', '%' . $keywords . '%')->select();
            $client_nameRes = Db::table('contact')->where('custom_name', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($nameRes,
            $salutationRes,
            $mobile_phoneRes,
            $telephoneRes,
            $faxRes,
            $emailRes,
            $client_idRes,
            $client_nameRes);
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['contact_id']])) {
                unset($value['contact_id']);  //有：销毁
            } else {
                $res[$value['contact_id']] = $value;
            }
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }
    }

}
