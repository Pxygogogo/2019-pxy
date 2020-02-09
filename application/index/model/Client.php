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
            'cn_name' => 'require',
            'en_name' => 'require',
            'short_name' => 'require',
            'charge_man' => 'require',
            'charge_phone' => 'require|number|length:11',
            'address' => 'require',
            'email' => 'require|email',
            'zipcode' => 'require|length:6',
            'deposit_bank' => 'require',
            'bank_account' => 'require',
        ],
            [
                'cn_name.require' => '请输入客户中文名！',
                'en_name.require' => '请输入客户英文名!',
                'short_name.require' => '请输入客户简称!',
                'charge_man.require' => '请输入负责人!',
                'charge_phone.require' => '请输入电话号码!',
                'charge_phone.number' => '电话号码需为数字!',
                'charge_phone.length' => '请输入11位电话号码!',
                'address.require' => '请输入地址!',
                'email.require' => '请输入邮箱地址!',
                'email.email' => '邮箱格式错误',
                'zipcode.require' => '请输入邮政编码！',
                'zipcode.length' => '请输入6位邮政编码！',
                'deposit_bank.require' => '请输入开户银行！',
                'bank_account.require' => '请输入银行账户！',
            ]);
        $dt = [
            'cn_name' => $input['cn_name'],
            'en_name' => $input['en_name'],
            'short_name' => $input['short_name'],
            'charge_man' => $input['charge_man'],
            'charge_phone' => $input['charge_phone'],
            'address' => $input['address'],
            'email' => $input['email'],
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
        $contact_arr = [];
        if ($input['contactArr'] !== '') {
            $contact_arr = json_decode($input['contactArr'], true);
        }
        unset($input['contactArr']);
        try {
            $flag = Db::table('client')->where('cn_name', $input['cn_name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '用户已存在，请勿重复添加！'];
        } else {
            //先增客户再更新联系人
            Db::table('client')->insert($input);
            $client_id = Db::table('client')->where('cn_name', $input['cn_name'])->value('client_id');
            if ($contact_arr) {
                for ($i = 0; $i < sizeof($contact_arr); $i++) {
                    $nowId = Db::table('contact')->where('contact_id', $contact_arr[$i]['contact_id'])->value('client_id');
                    if ($nowId === 0) {
                        $contact_arr[$i]['client_id'] = $client_id;
                        $contact_arr[$i]['client_name'] = $input['cn_name'];
                        Db::table('contact')->where('contact_id', $contact_arr[$i]['contact_id'])->update($contact_arr[$i]);
                    } else {
                        return ['valid' => 0, 'msg' => '您所选择的联系人中，已经有其他客户指定，请重新选择！'];
                    }

                }
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
            unset($data[0]);
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
        $contact_arr = [];
        if ($input['contactArr'] !== '') {
            $contact_arr = json_decode($input['contactArr'], true);
        }
        unset($input['contactArr']);
        if ($contact_arr) {
            for ($i = 0; $i < sizeof($contact_arr); $i++) {
                $contact_arr[$i]['client_id'] = $input['client_id'];
                $contact_arr[$i]['client_name'] = $input['cn_name'];
            }
        }
        $res = null;
        $flag = null;
        try {
            if (!$contact_arr) {
                Db::table('client')->where('client_id')->update($input);
            } else {
                $res = Db::table('contact')->where('client_id', $input['client_id'])->select();
                for ($i = 0; $i < sizeof($res); $i++) {
                    Db::table('contact')->where('contact_id', $res[$i]['contact_id'])->update(['client_id' => 0, 'client_name' => '']);
                }
                for ($i = 0; $i < sizeof($contact_arr); $i++) {
                    $flag = Db::table('contact')->where('contact_id', $contact_arr[$i]['contact_id'])->update($contact_arr[$i]);
                }
            }
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($flag) {
            return ['valid' => 1, 'msg' => '更新成功！'];
        } else {
//            return ['valid' => 0, 'msg' => '客户信息更新成功但是联系人信息更新失败！'];
            return ['valid' => 0, 'msg' => '更新失败！'];
        }

        //查找客户id关联到联系人
        //如果存在则去更新，不存在也允许
        //要同时更新已有订单里的数据


    }

//搜说联系人名称
    public
    function searchContact($keywords)
    {
        //根据货物名称模糊查找
        //存在则返回结果
        //不存在则返回空
        $data = null;
        try {
            $data = Db::table('contact')->where('name|salutation|mobile_phone|fax|email', 'like', '%' . $keywords . '%')->select();
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
    public
    function searchBy($input)
    {
        $keywords = $input['keywords'];
        try {
            $cn_nameRes = Db::table('client')->where('cn_name', 'like', '%' . $keywords . '%')->select();
            $en_nameRes = Db::table('client')->where('en_name', 'like', '%' . $keywords . '%')->select();
            $short_nameRes = Db::table('client')->where('short_name', 'like', '%' . $keywords . '%')->select();
            $provinceRes = Db::table('client')->where('province', 'like', '%' . $keywords . '%')->select();
            $cityRes = Db::table('client')->where('city', 'like', '%' . $keywords . '%')->select();
            $charge_manRes = Db::table('client')->where('charge_man', 'like', '%' . $keywords . '%')->select();
            $charge_phoneRes = Db::table('client')->where('charge_phone', 'like', '%' . $keywords . '%')->select();
            $addressRes = Db::table('client')->where('address', 'like', '%' . $keywords . '%')->select();
            $emailRes = Db::table('client')->where('email', 'like', '%' . $keywords . '%')->select();
            $zipcodeRes = Db::table('client')->where('zipcode', 'like', '%' . $keywords . '%')->select();
            $deposit_bankRes = Db::table('client')->where('deposit_bank', 'like', '%' . $keywords . '%')->select();
            $bank_accountRes = Db::table('client')->where('bank_account', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($cn_nameRes, $en_nameRes, $short_nameRes, $provinceRes, $cityRes, $charge_manRes, $charge_phoneRes, $addressRes, $emailRes, $zipcodeRes, $deposit_bankRes, $bank_accountRes);
//        $data = array_unique($data);

        //建立一个目标数组
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['client_id']])) {
                unset($value['client_id']);  //有：销毁
            } else {
                $res[$value['client_id']] = $value;
            }
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }

    }


}
