<?php

namespace app\index\model;

use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Model;
use think\response\Json;
use think\Validate;

class Order extends Model
{

    //增加订单
    public function addOrder($input)
    {

        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'client_name' => 'require',
            'consigner_name' => 'require',
            'consigner_telnumber' => 'require|length:11',
            'consigner_region' => 'require',
            'consigner_address' => 'require',
            'consigner_email' => 'require|email',
            'consignee_name' => 'require',
            'consignee_telnumber' => 'require|length:11',
            'consignee_region' => 'require',
            'consignee_address' => 'require',
            'consignee_email' => 'require|email',
            'order_date' => 'require|date'
        ], [
            'client_name.require' => '请输入客户名称！',
            'consigner_name.require' => '请输入发货人！',
            'consigner_telnumber.require' => '请输入发货人联系电话！',
            'consigner_telnumber.length' => '发货人联系电话为11位！',
            'consigner_region.require' => '请输入发货人省市区！',
            'consigner_address.require' => '请输入发货人地址！',
            'consigner_email.require' => '请输入发货人邮箱！',
            'consigner_email.email' => '请输入正确的邮箱格式！',
            'consignee_name.require' => '请输入收货人！',
            'consignee_telnumber.require' => '请输入收货人联系电话！',
            'consignee_telnumber.length' => '收货人联系电话为11位！',
            'consignee_region.require' => '请输入收货人省市区！',
            'consignee_address.require' => '请输入收货人地址！',
            'consignee_email.require' => '请输入收货人邮箱！',
            'consignee_email.email' => '请输入正确的邮箱格式！',
            'order_date.require' => '请输入下订单日期！',
            'order_date.date' => '日期格式不正确，正确格式为Y-M-D，如2019-01-01！',
        ]);
        $dt = [
            'client_name' => $input['client_name'],
            'consigner_name' => $input['consigner_name'],
            'consigner_telnumber' => $input['consigner_telnumber'],
            'consigner_region' => $input['consigner_region'],
            'consigner_address' => $input['consigner_address'],
            'consigner_email' => $input['consigner_email'],
            'consignee_name' => $input['consignee_name'],
            'consignee_telnumber' => $input['consignee_telnumber'],
            'consignee_address' => $input['consignee_address'],
            'consignee_region' => $input['consignee_region'],
            'consignee_email' => $input['consignee_email'],
            'order_date' => $input['order_date']
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        if (!$input['client_id']) {
            $client_res = null;
            try {
                $client_res = Db::table('client')->where('chinese_name', $input['client_name'])->find();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
            }
            if ($client_res) {
                $input['client_id'] = $client_res['client_id'];
            } else {
                return ['valid' => 0, 'msg' => '您输入的客户不存在,请重新输入！'];
            }
        }
        if (Db::table('order')->insert($input)) {
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
            $data = Db::table('order')->order('order_id desc')->select();
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
        $status = Db::table('order')->where('order_id', $order_id)->value('status');
        if ($status === '未审核' || $status === '审核失败') {
            $flag = null;
            try {
                $flag = Db::table('order')->where('order_id', $order_id)->update(['status' => '审核中']);
            } catch (PDOException $e) {
            } catch (Exception $e) {
                return ['valid' => 0, 'msg' => '数据库错误！'];
            }
            if ($flag) {
                return ['valid' => 1, 'msg' => '提交成功！'];
            } else {
                return ['valid' => 0, 'msg' => '提交失败！'];
            }
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
        $status = Db::table('order')->where('order_id', $input['order_id'])->value('status');
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
                        'status' => '审核成功',
                        'comment' => $input['check_result']
                    ]);
                } catch (PDOException $e) {
                } catch (Exception $e) {
                    return ['valid' => 0, 'msg' => '数据库错误！'];
                }
                return ['valid' => 1, 'msg' => '审核成功！'];
            } else {
                try {
                    Db::table('order')->where('order_id', $input['order_id'])->update([
                        'status' => '审核失败',
                        'comment' => $input['check_result']
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
        try {
            $res = Db::table('order')->where('order_id', $input['order_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        if ($res === 1) {
            return ['valid' => 1, 'msg' => '修改成功！'];
        } else if ($res === 0) {
            return ['valid' => 1, 'msg' => '您未做任何修改！'];
        } else {
            return ['valid' => 0, 'msg' => '修改失败！'];

        }

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
        $flag = Db::table('order')->where('order_id', $order_id)->value('status');
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


    public function findClient($order_id)
    {
        $data = null;
        try {
            $data = Db::table('order')->where('order_id', $order_id)->find();
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

    public function allCargo()
    {
        $data = null;
        try {
            $data = Db::table('cargo')->select();
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

    public function addOrderCargo($input)
    {
        try {
            Db::table('order_cargo')->where('order_id', $input['order_id'])->delete();
        } catch (PDOException $e) {
        } catch (Exception $e) {
        }
        $cargoArr = [];
        $receivedArr = $input['cargoArr'];
        for ($i = 0; $i < sizeof($receivedArr); $i++) {
            $cargoArr[$i]['order_id'] = $input['order_id'];
            $cargoArr[$i]['cargo_id'] = $receivedArr[$i]['cargo_id'];
            $cargoArr[$i]['cargo_name'] = $receivedArr[$i]['cargo_name'];
            $cargoArr[$i]['cargo_count'] = $receivedArr[$i]['cargo_count'];
        }
        $res = null;
        for ($i = 0; $i < sizeof($cargoArr); $i++) {
            $res = Db::table('order_cargo')->insert($cargoArr[$i]);
        }
        if ($res === 1) {
            return ['valid' => 1, 'msg' => '添加成功！'];
        } else {
            return ['valid' => 0, 'msg' => '添加失败！'];
        }

    }

    public function allChooseCargo($order_id)
    {
        $data = null;
        try {
            $data = Db::table('order_cargo')->where('order_id', $order_id)->select();
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

    //模糊搜索
    public function searchBy($input)
    {

        $res = null;
        $keywords = $input['keywords'];
        try {
            $res = Db::table('order')->where('order_id|client_id|client_name|consigner_name|consigner_telnumber|consigner_address|consigner_region|consigner_email|consignee_name|consignee_telnumber|consignee_region|consignee_address|consignee_email|status|comment', 'like', '%' . $keywords . '%')->select();
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
}
