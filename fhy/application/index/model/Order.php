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

class Order extends Model
{
    //
    public function searchClient($cname)
    {
        //根据客户名称模糊查找
        //存在则返回结果
        //不存在则返回空
        $data = null;
        try {
            $data = Db::table('custom')->where('cname', 'like', '%' . $cname . '%')->select();
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

    //搜说货物名称
    public function searchCargo($cargo_name)
    {
        //根据货物名称模糊查找
        //存在则返回结果
        //不存在则返回空
        $data = null;
        try {
            $data = Db::table('cargo')->where('name', 'like', '%' . $cargo_name . '%')->select();
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

    //增加订单
    public function addOrder($input)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'client_name' => 'require',
            'sender' => 'require',
            'sender_phone' => 'require|length:11',
            'sender_location' => 'require',
            'sender_email' => 'require|email',
            'receiver' => 'require',
            'receiver_phone' => 'require|length:11',
            'receiver_location' => 'require',
            'receiver_email' => 'require|email',
            'order_date' => 'require|date'
        ], [
            'client_name.require' => '请输入客户名称！',
            'sender.require' => '请输入发货人！',
            'sender_phone.require' => '请输入发货人联系电话！',
            'sender_phone.length' => '发货人联系电话为11位！',
            'sender_location.require' => '请输入发货人地址！',
            'sender_email.require' => '请输入发货人邮箱！',
            'sender_email.email' => '请输入正确的邮箱格式！',
            'receiver.require' => '请输入收货人！',
            'receiver_phone.require' => '请输入收货人联系电话！',
            'receiver_phone.length' => '收货人联系电话为11位！',
            'receiver_location.require' => '请输入收货人地址！',
            'receiver_email.require' => '请输入收货人邮箱！',
            'receiver_email.email' => '请输入正确的邮箱格式！',
            'order_date.require' => '请输入下订单日期！',
            'order_date.date' => '日期格式不正确，正确格式为Y-M-D！',
        ]);
        $dt = [
            'client_name' => $input['client_name'],
            'sender' => $input['sender'],
            'sender_phone' => $input['sender_phone'],
            'sender_location' => $input['sender_location'],
            'sender_email' => $input['sender_email'],
            'receiver' => $input['receiver'],
            'receiver_phone' => $input['receiver_phone'],
            'receiver_location' => $input['receiver_location'],
            'receiver_email' => $input['receiver_email'],
            'order_date' => $input['date'],
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //先判断客户id和货物id是否存在
        //不存在先找到两个id
        //然后处理数组分别插入到order表和order_cargo表
        if (!$input['custom_id']) {
            $client_res = null;
            try {
                $client_res = Db::table('custom')->where('cname', $input['client_name'])->find();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
            }
            if ($client_res) {
                $input['custom_id'] = $client_res['custom_id'];
            } else {
                return ['valid' => 0, 'msg' => '您输入的客户不存在,请查询后输入！'];
            }
        }

        //存入cargo_order的数组
        $co_input = json_decode($input['cargoArr'], true);
        unset($input['cargoArr']);
        $input['custom_name'] = $input['client_name'];
        unset($input['client_name']);
        //先插入订单表然后插入订单货物表

        if (Db::table('order')->insert($input)) {
            $orderId = Db::name('order')->getLastInsID();
            foreach ($co_input as $item) {
                $item['order_id'] = $orderId;
                Db::table('order_cargo')->insert($item);
            }
            return ['valid' => 1, 'msg' => '添加成功！'];
        } else {
            return ['valid' => 0, 'msg' => '添加失败！'];
        }

    }

    //查找已经录入的订单
    public function findData()
    {
        //页面加载时渲染数据库已有数据
        $data = null;
        try {
            $data = Db::table('order')->order('order_id asc')->select();
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

    //提交订单
    public function commitOrder($order_id)
    {
        $flag = null;
        try {
            $flag = Db::table('order')->where('order_id', $order_id)->update(['check_status' => '审核中']);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        if ($flag) {
            return ['valid' => 1, 'msg' => '提交成功！'];
        } else {
            return ['valid' => 0, 'msg' => '请勿重复提交！'];
        }
    }

    //审核
    public function audit($input)
    {
        //判断是否为空，是否超过20字
        //判断是否审核过了不要重复审核
        //判断是否提交了未提交的不能审核
        //更新数据
        $validate = new Validate([
            'check_result' => 'require|max:20'
        ], [
            'check_result.require' => '请输入审核意见！',
            'check_result.max' => '审核意见不能超过20字！',
        ], $dt = [
            'check_result' => $input['check_result']
        ]);
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        $status = null;
        $status = Db::table('order')->where('order_id', $input['order_id'])->value('check_status');
        if ($status === '审核成功') {
            return ['valid' => 0, 'msg' => '该单已审核成功，请勿重复审核！'];
        }
        if ($status === "未审核") {
            return ['valid' => 0, 'msg' => '该单还未提交，不允许审核！'];
        } else {
            //判断审核是否通过
            if ($input['isCheck'] === 'pass') {
                try {
                    Db::table('order')->where('order_id', $input['order_id'])->update([
                        'check_status' => '审核成功',
                        'check_result' => $input['check_result']
                    ]);
                } catch (PDOException $e) {
                } catch (Exception $e) {
                    return ['valid' => 0, 'msg' => '数据库错误！'];
                }
                return ['valid' => 1, 'msg' => '审核成功！'];
            } else {
                try {
                    Db::table('order')->where('order_id', $input['order_id'])->update([
                        'check_status' => '审核失败',
                        'check_result' => $input['check_result']
                    ]);
                } catch (PDOException $e) {
                } catch (Exception $e) {
                    return ['valid' => 0, 'msg' => '数据库错误！'];
                }
                return ['valid' => 1, 'msg' => '已驳回审核申请！'];
            }
        }

    }

    //更新订单数据
    public function updateData($input)
    {
        //存入cargo_order的数组
        $co_input = null;
        if ($input['cargoArr'] !== '') {
            $co_input = json_decode($input['cargoArr'], true);
            unset($input['cargoArr']);
            foreach ($co_input as $item) {
                $item['order_id'] = $input['order_id'];
            }
        }
        unset($input['cargoArr']);
        $res1 = null;
        try {
            //事务锁
            Db::startTrans();
            try {
                $res1 = Db::table('order')->where('order_id', $input['order_id'])->update($input);
                if ($co_input) {
                    foreach ($co_input as $item) {
                        $res1 = Db::table('order_cargo')->where('order_id', $input['order_id'])->where('cargo_id', $item['cargo_id'])->update($item);
                    }
                }
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return ['valid' => 0, 'msg' => '数据库更新错误！'];
            }
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
//        if ($res1) {
        return ['valid' => 1, 'msg' => '更新成功！'];
//        } else {
//            return ['valid' => 0, 'msg' => '更新失败！'];
//        }
    }

    //删除未审核的订单
    public function del($order_id)
    {
        //判断权限
        //判断订单是否审核
        //审核则不能删除
        //未审核可以删除
        $res = null;
        $flag = null;
        $flag = Db::table('order')->where('order_id', $order_id)->value('check_status');
        if ($flag === '未审核') {
            try {
                $res = Db::table('order')->where('order_id', $order_id)->delete();
            } catch (PDOException $e) {
            } catch (Exception $e) {
                return ['valid' => 0, 'msg' => '数据库错误！'];
            }
            if ($res === 1) {
                return ['valid' => 1, 'msg' => '删除成功！'];
            } else {
                return ['valid' => 0, 'msg' => '删除失败！'];
            }
        } else {
            return ['valid' => 0, 'msg' => '订单已经提交审核，不能删除！'];
        }

    }

    //按关键词搜索
    public function searchBy($input)
    {
        $keywords = $input['keywords'];
        try {
            $order_idRes = Db::table('order')->where('order_id', 'like', '%' . $keywords . '%')->select();
            $custom_idRes = Db::table('order')->where('custom_id', 'like', '%' . $keywords . '%')->select();
            $custom_nameRes = Db::table('order')->where('custom_name', 'like', '%' . $keywords . '%')->select();
            $sendRes = Db::table('order')->where('sender', 'like', '%' . $keywords . '%')->select();
            $send_phoneRes = Db::table('order')->where('sender_phone', 'like', '%' . $keywords . '%')->select();
            $send_addressRes = Db::table('order')->where('sender_location', 'like', '%' . $keywords . '%')->select();
            $send_provinceRes = Db::table('order')->where('sender_area', 'like', '%' . $keywords . '%')->select();
            $send_emailRes = Db::table('order')->where('sender_email', 'like', '%' . $keywords . '%')->select();
            $receiverRes = Db::table('order')->where('receiver', 'like', '%' . $keywords . '%')->select();
            $receive_phoneRes = Db::table('order')->where('receiver_phone', 'like', '%' . $keywords . '%')->select();
            $receive_addressRes = Db::table('order')->where('receiver_location', 'like', '%' . $keywords . '%')->select();
            $receive_provinceRes = Db::table('order')->where('receiver_area', 'like', '%' . $keywords . '%')->select();
            $receive_emailRes = Db::table('order')->where('receiver_email', 'like', '%' . $keywords . '%')->select();
            $statusRes = Db::table('order')->where('check_status', 'like', '%' . $keywords . '%')->select();
            $commentRes = Db::table('order')->where('check_result', 'like', '%' . $keywords . '%')->select();
//            $order_dateRes = Db::table('order')->where('order_date', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($order_idRes,
            $custom_idRes,
            $custom_nameRes,
            $sendRes,
            $send_phoneRes,
            $send_addressRes,
            $send_provinceRes,
            $send_emailRes,
            $receiverRes,
            $receive_phoneRes,
            $receive_addressRes,
            $receive_provinceRes,
            $receive_emailRes,
            $statusRes,
            $commentRes
//            $order_dateRes
        );
//        $data = array_unique($data);
        //建立一个目标数组
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['order_id']])) {
                unset($value['order_id']);  //有：销毁
            } else {
                $res[$value['order_id']] = $value;
            }
        }

        if ($res) {
            return $res;
        } else {
            return null;
        }

    }

}
