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
            'name' => 'require',
            'type' => 'require',
            'package_way' => 'require',
            'measure_unit' => 'require',
            'unit_length' => 'require|number',
            'unit_width' => 'require|number',
            'unit_height' => 'require|number',
            'unit_weight' => 'require|number',
            'temperature' => 'require',
            'expiration_date' => 'require|number',
        ], [
            'name.require' => '请输入货物名称！',
            'type.require' => '请输入货物类型！',
            'package_way.require' => '请输入包装方式！',
            'measure_unit.require' => '请输入计量单位！',
            'unit_length.require' => '请输入计量长度！',
            'unit_length.number' => '计量长度为数字！',
            'unit_width.require' => '请输入计量宽度！',
            'unit_width.number' => '计量宽度为数字！',
            'unit_height.require' => '亲输入计量高度！',
            'unit_height.number' => '计量高度为数字！',
            'unit_weight.require' => '亲输入计量重量!',
            'unit_weight.number' => '计量重量为数字!',
            'temperature.require' => '请输入保鲜温度！',
            'expiration_date.require' => '请输入保质期！',
            'expiration_date.number' => '保质期为数字！',
        ]);
        $dt = [
            'name' => $input['name'],
            'type' => $input['type'],
            'package_way' => $input['package_way'],
            'measure_unit' => $input['measure_unit'],
            'unit_length' => $input['unit_length'],
            'unit_width' => $input['unit_width'],
            'unit_height' => $input['unit_height'],
            'unit_weight' => $input['unit_weight'],
            'temperature' => $input['temperature'],
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
            $flag = Db::table('cargo')->where('name', $input['name'])->find();
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
            $data = Db::table('cargo')->order('cargo_id asc')->select();
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
            return ['valid' => 0, 'msg' => '数据库更新错误！'];
        }
        if ($res) {
            return ['valid' => 1, 'msg' => '更新成功！'];
        } else {
            return ['valid' => 0, 'msg' => '更新失败！'];
        }
    }

    //按关键词搜索
    public function searchBy($input)
    {
        $keywords = $input['keywords'];
        try {
            $idRes = Db::table('cargo')->where('cargo_id', 'like', '%' . $keywords . '%')->select();
            $nameRes = Db::table('cargo')->where('name', 'like', '%' . $keywords . '%')->select();
            $typeRes = Db::table('cargo')->where('type', 'like', '%' . $keywords . '%')->select();
            $package_wayRes = Db::table('cargo')->where('package_way', 'like', '%' . $keywords . '%')->select();
            $measure_unitRes = Db::table('cargo')->where('measure_unit', 'like', '%' . $keywords . '%')->select();
            $lengthRes = Db::table('cargo')->where('unit_length', 'like', '%' . $keywords . '%')->select();
            $widthRes = Db::table('cargo')->where('unit_width', 'like', '%' . $keywords . '%')->select();
            $heightRes = Db::table('cargo')->where('unit_height', 'like', '%' . $keywords . '%')->select();
            $weightRes = Db::table('cargo')->where('unit_weight', 'like', '%' . $keywords . '%')->select();
            $temperatureRes = Db::table('cargo')->where('temperature', 'like', '%' . $keywords . '%')->select();
            $expiration_dateRes = Db::table('cargo')->where('expiration_date', 'like', '%' . $keywords . '%')->select();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库查询错误！'];
        }
        $data = array_merge($idRes, $nameRes, $typeRes, $package_wayRes, $lengthRes, $measure_unitRes, $widthRes, $heightRes, $weightRes, $temperatureRes, $expiration_dateRes);
//        $data = array_unique($data);

        //建立一个目标数组
        $res = array();
        foreach ($data as $value) {
            //查看有没有重复项
            if (isset($res[$value['cargo_id']])) {
                unset($value['cargo_id']);  //有：销毁
            } else {
                $res[$value['cargo_id']] = $value;
            }
        }
        if ($res) {
            return $res;
        } else {
            return null;
        }

    }
}
