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

class Client extends Model
{
    //
    public function addUser($input)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'chinese_name' => 'require',
            'english_name' => 'require',
            'short_name' => 'require',
            'leader' => 'require',
            'leader_telnumber' => 'require|number|length:11',
            'client_address' => 'require',
            'client_region' => 'require',
            'client_email' => 'require|email',
            'zipcode' => 'require|length:6',
            'deposit_bank' => 'require',
            'bank_account' => 'require',
        ],
            [
                'chinese_name.require' => '请输入客户中文名！',
                'english_name.require' => '请输入客户英文名!',
                'short_name.require' => '请输入客户简称!',
                'leader.require' => '请输入负责人!',
                'leader_telnumber.require' => '请输入电话号码!',
                'leader_telnumber.number' => '电话号码需为数字!',
                'leader_telnumber.length' => '请输入11位电话号码!',
                'client_address.require' => '请输入地址!',
                'client_region.require' => '请输入省市区!',
                'client_email.require' => '请输入邮箱地址!',
                'client_email.email' => '邮箱格式错误',
                'zipcode.require' => '请输入邮政编码！',
                'zipcode.length' => '请输入6位邮政编码！',
                'deposit_bank.require' => '请输入开户银行！',
                'bank_account.require' => '请输入银行账户！',
            ]);
        $dt = [
            'chinese_name' => $input['chinese_name'],
            'english_name' => $input['english_name'],
            'short_name' => $input['short_name'],
            'leader' => $input['leader'],
            'leader_telnumber' => $input['leader_telnumber'],
            'client_address' => $input['client_address'],
            'client_region' => $input['client_region'],
            'client_email' => $input['client_email'],
            'zipcode' => $input['zipcode'],
            'deposit_bank' => $input['deposit_bank'],
            'bank_account' => $input['bank_account'],
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.先判断客户是否存在
        //2.不存在则插入
        //插入时 同时更新对应联系人的客户id和客户名称
        //3.存在则提示其修改
        try {
            $flag = Db::table('client')->where('chinese_name', $input['chinese_name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '客户已存在，请勿重复添加！'];
        } else {
            if (Db::table('client')->insert($input)) {
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
            $data = Db::table('client')->order('client_id asc')->select();
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

    public function del($client_id)
    {
        $res = null;
        try {
            $res = Db::table('client')->where('client_id', $client_id)->delete();
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

    public function updateData($input)
    {
        try {
            $res = Db::table('client')->where('client_id', $input['client_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($res === 1) {
            return ['valid' => 1, 'msg' => '修改成功！'];
        } else {
            return ['valid' => 0, 'msg' => '修改失败！'];
        }
    }

    //搜说联系人名称
    public function searchContact($contact_name)
    {
        //根据货物名称模糊查找
        //存在则返回结果
        //不存在则返回空
        $data = null;
        try {
            $data = Db::table('contact')->where('name', 'like', '%' . $contact_name . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    //按关键词搜索
    public function searchBy($input)
    {
        $res = null;
        $keywords = $input['keywords'];
        try {
            $res = Db::table('client')->where('client_id|chinese_name|english_name|short_name|leader|leader_telnumber|client_region|client_address|client_email|zipcode|deposit_bank', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }

    }

    public function findClient($client_id)
    {
        $data = null;
        try {
            $data = Db::table('client')->where('client_id', $client_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function addLinkman($input)
    {
        //0.判断用户是否存在非法输入

        $validate = new Validate([
            'link_name' => 'require',
            'link_appellation' => 'require',
            'link_phonenumber' => 'require|length:11',
            'link_telnumber' => 'require',
            'fax' => 'require',
            'link_email' => 'require|email',
        ], [
            'link_name.require' => '请输入联系人名字！',
            'link_appellation.require' => '请输入联系人称谓!',
            'link_phonenumber.require' => '请输入联系人手机!',
            'link_phonenumber.length' => '联系人手机为11位!',
            'link_telnumber.require' => '请输入联系人电话!',
            'fax.require' => '请输入联系人传真!',
            'link_email.require' => '请输入邮箱地址!',
            'link_email.email' => '邮箱格式错误',
        ]);
        $dt = [
            'link_name' => $input['link_name'],
            'link_appellation' => $input['link_appellation'],
            'link_phonenumber' => $input['link_phonenumber'],
            'link_telnumber' => $input['link_telnumber'],
            'fax' => $input['fax'],
            'link_email' => $input['link_email'],
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.先判断联系人是否存在
        //2.不存在则插入
        //3.存在则提示其修改

        $flag = null;
        try {
            $flag = Db::table('linkman')->where('link_name', $input['link_name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '联系人已被某客户指定，请重新输入一个联系人！'];
        } else {
            if (Db::table('linkman')->insert($input)) {
                return ['valid' => 1, 'msg' => '添加成功！', 'data' => $input['client_id']];
            } else {
                return ['valid' => 0, 'msg' => '添加失败！'];
            }
        }
    }

    public function findLinkman($client_id)
    {
        $data = null;
        try {
            $data = Db::table('linkman')->where('client_id', $client_id)->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
        }
        if ($data) {
            return $data;
        } else {
            return null;
        }
    }

    public function delLinkman($link_id)
    {
        $res = null;
        try {
            $res = Db::table('linkman')->where('link_id', $link_id)->delete();
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

    public function updateLinkmanData($input)
    {
        $flag = null;
        try {
            $flag = Db::table('linkman')->where('link_name', $input['link_name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '联系人已被某客户指定，请重新修改信息！', 'data' => $input['client_id']];
        }
        try {
            $res = Db::table('linkman')->where('link_id', $input['link_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($res === 0) {
            return ['valid' => 1, 'msg' => '您未做任何修改！', 'data' => $input['client_id']];
        } else if ($res) {
            return ['valid' => 1, 'msg' => '修改成功！', 'data' => $input['client_id']];
        } else {
            return ['valid' => 0, 'msg' => '修改失败！', 'data' => $input['client_id']];
        }

    }


}
