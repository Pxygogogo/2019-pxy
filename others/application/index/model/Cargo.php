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

class Cargo extends Model
{
    //
    public function addCargo($input)
    {
        //0.判断用户是否存在非法输入
        $validate = new Validate([
            'cargo_name' => 'require',
            'type' => 'require',
            'packing' => 'require',
            'measure_unit' => 'require',
            'unit_length' => 'require|number',
            'unit_width' => 'require|number',
            'unit_height' => 'require|number',
            'unit_weight' => 'require|number',
            'preservation_temperature' => 'require',
            'expiration_date' => 'require|number',
        ], [
            'cargo_name.require' => '请输入货物名称！',
            'type.require' => '请输入货物类型！',
            'packing.require' => '请输入包装方式！',
            'measure_unit.require' => '请输入计量单位！',
            'unit_length.require' => '请输入计量长度！',
            'unit_length.number' => '计量长度为数字！',
            'unit_width.require' => '请输入计量宽度！',
            'unit_width.number' => '计量宽度为数字！',
            'unit_height.require' => '亲输入计量高度！',
            'unit_height.number' => '计量高度为数字！',
            'unit_weight.require' => '请输入计量重量!',
            'unit_weight.number' => '计量重量为数字!',
            'preservation_temperature.require' => '请输入保鲜温度！',
            'expiration_date.require' => '请输入保质期！',
            'expiration_date.number' => '保质期为数字！',
        ]);
        $dt = [
            'cargo_name' => $input['cargo_name'],
            'type' => $input['type'],
            'packing' => $input['packing'],
            'measure_unit' => $input['measure_unit'],
            'unit_length' => $input['unit_length'],
            'unit_width' => $input['unit_width'],
            'unit_height' => $input['unit_height'],
            'unit_weight' => $input['unit_weight'],
            'preservation_temperature' => $input['preservation_temperature'],
            'expiration_date' => $input['expiration_date'],
        ];
        if (!$validate->check($dt)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        //1.先判断货物是否存在
        //2.不存在则插入
        //3.存在则提示其修改
        $flag = null;
        try {
            $flag = Db::table('cargo')->where('cargo_name', $input['cargo_name'])->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据查询失败'];
        }
        if ($flag) {
            return ['valid' => 0, 'msg' => '货物已存在，请勿重复添加！'];
        } else {
            if (Db::table('cargo')->insert($input)) {
                return ['valid' => 1, 'msg' => '添加成功！'];
            } else {
                return ['valid' => 0, 'msg' => '添加失败！'];
            }
        }
    }

    //查找已经录入的货物
    public function findData()
    {
        //页面加载时渲染数据库已有数据
        $data = null;
        try {
            $data = Db::table('cargo')->order('cargo_id desc')->select();
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

    //删除货物
    public function del($cargo_id)
    {
        $res = null;
        try {
            $res = Db::table('cargo')->where('cargo_id', $cargo_id)->delete();
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

    //更新货物数据
    public function updateData($input)
    {
        try {
            $res = Db::table('cargo')->where('cargo_id', $input['cargo_id'])->update($input);
        } catch (PDOException $e) {
        } catch (Exception $e) {
            return ['valid' => 0, 'msg' => '数据库修改错误！'];
        }
        if ($res) {
            return ['valid' => 1, 'msg' => '修改成功！'];
        } else {
            return ['valid' => 0, 'msg' => '修改失败！'];
        }
    }

    //按关键词搜索
    public function searchBy($input)
    {
        $res = null;
        $keywords = $input['keywords'];
        try {
            $res = Db::table('cargo')->where('cargo_id|cargo_name|type|packing|measure_unit|expiration_date', 'like', '%' . $keywords . '%')->select();
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
