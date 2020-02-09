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

class Custom extends Model
{
    //
    public function addUser($input)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'cname' => 'require',
            'ename' => 'require',
            'sname' => 'require',
            'principle' => 'require',
            'prin_phone' => 'require|length:11',
            'location' => 'require',
            'email' => 'require|email',
            'postcode' => 'require|length:6',
            'bank' => 'require',
            'bank_account' => 'require',
        ],
            [
                'cname.require' => '请输入客户中文名！',
                'ename.require' => '请输入客户英文名!',
                'sname.require' => '请输入客户简称!',
                'principle.require' => '请输入负责人!',
                'prin_phone.require' => '请输入电话号码!',
                'prin_phone.length' => '请输入11位电话号码!',
                'location.require' => '请输入地址!',
                'email.require' => '请输入邮箱地址!',
                'email.email' => '邮箱格式错误',
                'postcode.require' => '请输入邮政编码！',
                'postcode.length' => '请输入6位邮政编码！',
                'bank.require' => '请输入开户银行！',
                'bank_account.require' => '请输入银行账户！',
            ]);
        $dt = [
            'cname' => $input['cname'],
            'ename' => $input['ename'],
            'sname' => $input['sname'],
            'principle' => $input['principle'],
            'prin_phone' => $input['prin_phone'],
            'location' => $input['location'],
            'email' => $input['email'],
            'postcode' => $input['postcode'],
            'bank' => $input['bank'],
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
//        $contact_arr['custom_id'] = $input['custom_id'];
        $contact_arr['custom_name'] = $input['cname'];
        $contact_arr['contact1'] = $input['contact1'];
        $contact_arr['contact2'] = $input['contact2'];
        $contact_arr['contact3'] = $input['contact3'];
        unset($input['contact1']);
        unset($input['contact2']);
        unset($input['contact3']);

        $flag = null;
        $contactFlag1 = 0;
        $contactFlag2 = 0;
        $contactFlag3 = 0;
        try {
            $flag = Db::table('custom')->where('cname', $input['cname'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '用户已存在，请勿重复添加！'];
        } else {
            //先增客户再更新联系人
            if (Db::table('custom')->insert($input)) {
                //查找客户id关联到联系人
                $contact_arr['custom_id'] = Db::table('custom')->where('cname', $input['cname'])->value('custom_id');
                //如果存在则去更新，不存在也允许
                if ($contact_arr['contact1'] !== '') {
                    $contactFlag1 = Db::table('contact')->where('name', $contact_arr['contact1'])->update([
                        'custom_id' => $contact_arr['custom_id'],
                        'custom_name' => $contact_arr['custom_name']
                    ]);
                } else {
                    $contactFlag1 = 1;
                }
                if ($contact_arr['contact2'] !== '') {
                    $contactFlag2 = Db::table('contact')->where('name', $contact_arr['contact2'])->update([
                        'custom_id' => $contact_arr['custom_id'],
                        'custom_name' => $contact_arr['custom_name']
                    ]);
                } else {
                    $contactFlag2 = 1;
                }
                if ($contact_arr['contact3'] !== '') {
                    $contactFlag3 = Db::table('contact')->where('name', $contact_arr['contact3'])->update([
                        'custom_id' => $contact_arr['custom_id'],
                        'custom_name' => $contact_arr['custom_name']
                    ]);
                } else {
                    $contactFlag3 = 1;
                }
                if ($contactFlag1 && $contactFlag2 && $contactFlag3) {
                    return ['valid' => 1, 'msg' => '添加成功！'];
                } else {
                    return ['valid' => 0, 'msg' => '客户添加成功但是客户指定的联系人添加失败！'];
                }

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
            $data = Db::table('custom')->order('custom_id asc')->select();
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

    public function del($custom_id)
    {
        $res = null;
        try {
            $res = Db::table('custom')->where('custom_id', $custom_id)->delete();
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
        $contact_arr['custom_id'] = $input['custom_id'];
        $contact_arr['custom_name'] = $input['cname'];
        $contact_arr['contact1'] = $input['contact1'];
        $contact_arr['contact2'] = $input['contact2'];
        $contact_arr['contact3'] = $input['contact3'];
        unset($input['contact1']);
        unset($input['contact2']);
        unset($input['contact3']);
        try {
            Db::table('custom')->where('custom_id', $input['custom_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        //查找客户id关联到联系人
        //如果存在则去更新，不存在也允许
        if ($contact_arr['contact1'] !== '') {
            $contactFlag1 = Db::table('contact')->where('name', $contact_arr['contact1'])->update([
                'custom_id' => $contact_arr['custom_id'],
                'custom_name' => $contact_arr['custom_name']
            ]);
        } else {
            $contactFlag1 = 1;
        }
        if ($contact_arr['contact2'] !== '') {
            $contactFlag2 = Db::table('contact')->where('name', $contact_arr['contact2'])->update([
                'custom_id' => $contact_arr['custom_id'],
                'custom_name' => $contact_arr['custom_name']
            ]);
        } else {
            $contactFlag2 = 1;
        }
        if ($contact_arr['contact3'] !== '') {
            $contactFlag3 = Db::table('contact')->where('name', $contact_arr['contact3'])->update([
                'custom_id' => $contact_arr['custom_id'],
                'custom_name' => $contact_arr['custom_name']
            ]);
        } else {
            $contactFlag3 = 1;
        }
        if ($contactFlag1 && $contactFlag2 && $contactFlag3) {
            return ['valid' => 1, 'msg' => '更新成功！'];
        } else {
//            return ['valid' => 0, 'msg' => '客户信息更新成功但是联系人信息更新失败！'];
            return ['valid' => 1, 'msg' => '更新成功！'];
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
        $keywords = $input['keywords'];
        try {
            $cn_nameRes = Db::table('custom')->where('cname', 'like', '%' . $keywords . '%')->select();
            $en_nameRes = Db::table('custom')->where('ename', 'like', '%' . $keywords . '%')->select();
            $short_nameRes = Db::table('custom')->where('sname', 'like', '%' . $keywords . '%')->select();
            $provinceRes = Db::table('custom')->where('area', 'like', '%' . $keywords . '%')->select();
            $charge_manRes = Db::table('custom')->where('principle', 'like', '%' . $keywords . '%')->select();
            $charge_phoneRes = Db::table('custom')->where('prin_phone', 'like', '%' . $keywords . '%')->select();
            $addressRes = Db::table('custom')->where('location', 'like', '%' . $keywords . '%')->select();
            $emailRes = Db::table('custom')->where('email', 'like', '%' . $keywords . '%')->select();
            $zipcodeRes = Db::table('custom')->where('postcode', 'like', '%' . $keywords . '%')->select();
            $deposit_bankRes = Db::table('custom')->where('bank', 'like', '%' . $keywords . '%')->select();
            $bank_accountRes = Db::table('custom')->where('bank_account', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($cn_nameRes, $en_nameRes, $short_nameRes, $provinceRes, $charge_manRes, $charge_phoneRes, $addressRes, $emailRes, $zipcodeRes, $deposit_bankRes, $bank_accountRes);
//        $data = array_unique($data);

        //建立一个目标数组
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['custom_id']])) {
                unset($value['custom_id']);  //有：销毁
            } else {
                $res[$value['custom_id']] = $value;
            }
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }

    }

}
