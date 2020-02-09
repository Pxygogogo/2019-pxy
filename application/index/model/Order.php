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
    //
    public function searchClient($client_name)
    {
        //根据客户名称模糊查找
        //存在则返回结果
        //不存在则返回空
        $data = null;
        try {
//            $data = Db::table('client')->whereLike('client_name', '%' . $client_name . '%');
            $data = Db::table('client')->where('cn_name', 'like', '%' . $client_name . '%')->select();
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
            'cargoArr' => 'require',
            'consigner' => 'require',
            'consigner_phone' => 'require|length:11',
            'consigner_address' => 'require',
            'consigner_email' => 'require|email',
            'consignee' => 'require',
            'consignee_phone' => 'require|length:11',
            'consignee_address' => 'require',
            'consignee_email' => 'require|email',
            'order_date' => 'require|date'
        ], [
            'client_name.require' => '请输入客户名称！',
            'cargoArr.require' => '请添加货物！',
            'consigner.require' => '请输入发货人！',
            'consigner_phone.require' => '请输入发货人联系电话！',
            'consigner_phone.length' => '发货人联系电话为11位！',
            'consigner_address.require' => '请输入发货人地址！',
            'consigner_email.require' => '请输入发货人邮箱！',
            'consigner_email.email' => '请输入正确的邮箱格式！',
            'consignee.require' => '请输入收货人！',
            'consignee_phone.require' => '请输入收货人联系电话！',
            'consignee_phone.length' => '收货人联系电话为11位！',
            'consignee_address.require' => '请输入收货人地址！',
            'consignee_email.require' => '请输入收货人邮箱！',
            'consignee_email.email' => '请输入正确的邮箱格式！',
            'order_date.require' => '请输入下订单日期！',
            'order_date.date' => '日期格式不正确，正确格式为Y-M-D，如2019-01-01！',
        ]);
        $dt = [
            'client_name' => $input['client_name'],
            'cargoArr' => $input['cargoArr'],
            'consigner' => $input['consigner'],
            'consigner_phone' => $input['consigner_phone'],
            'consigner_address' => $input['consigner_address'],
            'consigner_province' => $input['consigner_province'],
            'consigner_email' => $input['consigner_email'],
            'consignee' => $input['consignee'],
            'consignee_phone' => $input['consignee_phone'],
            'consignee_address' => $input['consignee_address'],
            'consignee_province' => $input['consignee_province'],
            'consignee_email' => $input['consignee_email'],
            'order_date' => $input['order_date']
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //先判断客户id和货物id是否存在
        //不存在先找到两个id
        //然后处理数组分别插入到order表和order_cargo表
        if (!$input['client_id']) {
            $client_res = null;
            try {
                $client_res = Db::table('client')->where('cn_name', $input['client_name'])->find();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
            }
            if ($client_res) {
                $input['client_id'] = $client_res['client_id'];
            } else {
                return ['valid' => 0, 'msg' => '您输入的客户不存在,请查询后输入！'];
            }
        }

        //存入cargo_order的数组
        $co_input = json_decode($input['cargoArr'], true);
        unset($input['cargoArr']);
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
        //先判断是否有修改货物数据
        //没有修改的话cargoArr传过来为空
        //为空的话就不要更新订单货物了直接更新其他的就好
        //不为空的话直接把原来的全删了把新来的插进去
        if ($input['cargoArr'] === '') {
            //只需更新订单除了货物之外的其他数据
            unset($input['cargoArr']);
            try {
                $res = Db::table('order')->where('order_id', $input['order_id'])->update($input);
                if ($res === 0) {
                    return ['valid' => 1, 'msg' => '您未做任何修改！'];
                } elseif ($res) {
                    return ['valid' => 1, 'msg' => '更新成功！'];
                } else {
                    return ['valid' => 0, 'msg' => '更新失败！'];
                }
            } catch (PDOException $e) {
            } catch (Exception $e) {
                return ['valid' => 0, 'msg' => '更新失败,数据库更新错误！'];
            }
        } else {
            //货物进行了修改，对于存入order_cargo表的数据进行规范
            $co_input = json_decode($input['cargoArr'], true);
            unset($input['cargoArr']);
            for ($i = 0; $i < sizeof($co_input); $i++) {
                $co_input[$i]['order_id'] = $input['order_id'];
            }
            //删除原来有的
            //存入新来的
            try {
                Db::table('order_cargo')->where('order_id', $input['order_id'])->delete();
                foreach ($co_input as $item) {
                    Db::table('order_cargo')->insert($item);
                }
            } catch (PDOException $e) {
            } catch (Exception $e) {
                return ['valid' => 0, 'msg' => '更新失败,数据库更新错误！'];
            }
            return ['valid' => 1, 'msg' => '更新成功！'];
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
            $client_idRes = Db::table('order')->where('client_id', 'like', '%' . $keywords . '%')->select();
            $client_nameRes = Db::table('order')->where('client_name', 'like', '%' . $keywords . '%')->select();
            $sendRes = Db::table('order')->where('consigner', 'like', '%' . $keywords . '%')->select();
            $send_phoneRes = Db::table('order')->where('consigner_phone', 'like', '%' . $keywords . '%')->select();
            $send_addressRes = Db::table('order')->where('consigner_address', 'like', '%' . $keywords . '%')->select();
            $send_provinceRes = Db::table('order')->where('consigner_province', 'like', '%' . $keywords . '%')->select();
            $send_cityRes = Db::table('order')->where('consigner_city', 'like', '%' . $keywords . '%')->select();
            $send_districtRes = Db::table('order')->where('consigner_district', 'like', '%' . $keywords . '%')->select();
            $send_emailRes = Db::table('order')->where('consigner_email', 'like', '%' . $keywords . '%')->select();
            $receiverRes = Db::table('order')->where('consignee', 'like', '%' . $keywords . '%')->select();
            $receive_phoneRes = Db::table('order')->where('consignee_phone', 'like', '%' . $keywords . '%')->select();
            $receive_addressRes = Db::table('order')->where('consignee_address', 'like', '%' . $keywords . '%')->select();
            $receive_provinceRes = Db::table('order')->where('consignee_province', 'like', '%' . $keywords . '%')->select();
            $receive_cityRes = Db::table('order')->where('consignee_city', 'like', '%' . $keywords . '%')->select();
            $receive_districtRes = Db::table('order')->where('consignee_district', 'like', '%' . $keywords . '%')->select();
            $receive_emailRes = Db::table('order')->where('consignee_email', 'like', '%' . $keywords . '%')->select();
            $statusRes = Db::table('order')->where('check_status', 'like', '%' . $keywords . '%')->select();
            $commentRes = Db::table('order')->where('check_result', 'like', '%' . $keywords . '%')->select();
//            $order_dateRes = Db::table('order')->where('order_date', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($order_idRes,
            $client_idRes,
            $client_nameRes,
            $sendRes,
            $send_phoneRes,
            $send_addressRes,
            $send_provinceRes,
            $send_cityRes,
            $send_districtRes,
            $send_emailRes,
            $receiverRes,
            $receive_phoneRes,
            $receive_addressRes,
            $receive_provinceRes,
            $receive_cityRes,
            $receive_districtRes,
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
