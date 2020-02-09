<?php

namespace app\index\controller;

use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\PDOException;
use think\Request;

class Order extends Common
{
    //

    public function index()
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '客服' && $auth !== '审核员') {
            $this->error('无权限访问！', 'index/entry/index', null, 0);
        }
        //获取已经存在的订单数据
        $data = (new \app\index\model\Order())->findData();
        $this->assign('order', $data);
        return $this->fetch();
    }

    //搜索客户
    public function searchClient()
    {
        $res = null;
        if (request()->isPost()) {
            $data = input('post.');
            if (!$data) {
                return null;
            }
            $res = (new \app\index\model\Order())->searchClient($data['client_name']);
            if ($res) {
                $this->success('', '', $res);
            } else {
                $this->error('查询失败！');
            }
        }
    }

    //搜索货物
    public function searchCargo()
    {
        $res = null;
        if (request()->isPost()) {
            $data = input('post.');
            if (!$data) {
                return null;
            }
            $res = (new \app\index\model\Order())->searchCargo($data['cargo_name']);
            if ($res) {
                $this->success('', '', $res);
            } else {
                $this->error('查询失败！');
            }
        }
    }

    //新增订单 包含权限判断
    public function addOrder()
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '客服') {
            $this->error('无权限添加！', 'index/order/index', null, 0);
        }
        //检验用户输入
        if (request()->isPost()) {
            $res = (new \app\index\model\Order())->addOrder(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index/order/index', null, 0);
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }
    }

    //提交审核 包含权限判断
    public function commit($order_id)
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '客服') {
            $this->error('无权限提交！', 'index/order/index', null, 0);
        }
        //把对应的订单审核状态改为审核中
        $res = (new \app\index\model\Order())->commitOrder($order_id);
        if ($res['valid']) {
            $this->success('提交成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //审核 包含权限判断
    public function audit()
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '审核员') {
            $this->error('无权限审核！', 'index/order/index', null, 0);
        }
        if (\request()->isPost()) {
            $res = (new \app\index\model\Order())->audit(input('post.'));
            if ($res['valid']) {
                $this->success('审核成功', 'index', null, 1);
                exit;
            } else {
                $this->error($res['msg'], 'index', null, 1);
                exit;
            }
        }


    }

    //详情页面
    public function detail($order_id)
    {
        //根据是否提交返回不同页面
        $flag = null;
        $flag = Db::table('order')->where('order_id', $order_id)->value('check_status');
        if ($flag === "未审核" || $flag === "审核失败") {
            //未审核或者审核失败还可以修改
            //判断用户权限
            $auth = Request::instance()->session('role');
            if ($auth !== '系统管理员' && $auth !== '客服' && $auth !== '审核员') {
                $this->error('无权限更新！', 'index/order/index', null, 0);
            }
            $data = null;
            $cargoArr = null;
            try {
                $data = Db::table('order')->where('order_id', $order_id)->find();
                $cargoArr = Db::table('order_cargo')->where('order_id', $order_id)->select();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
                return ['valid' => 0, 'msg' => '数据库错误！'];
            }
            $this->assign('order', $data);
            $this->assign('cargoArr', $cargoArr);
            return $this->fetch('change');
        } else {
            //不可修改
            $data = null;
            $cargoArr = null;
            try {
                $data = Db::table('order')->where('order_id', $order_id)->find();
                $cargoArr = Db::table('order_cargo')->where('order_id', $order_id)->select();
            } catch (DataNotFoundException $e) {
            } catch (ModelNotFoundException $e) {
            } catch (DbException $e) {
                return ['valid' => 0, 'msg' => '数据库错误！'];
            }
            $this->assign('order', $data);
            $this->assign('cargoArr', $cargoArr);
            return $this->fetch();
        }

    }

    //更新订单数据 包含权限判断
    public function updateData()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Order())->updateData(input('post.'));
        }
        if ($res['valid']) {
            $this->success($res['msg'], 'index/order/index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index/order/index', null, 1);
            exit;
        }

    }

    //删除未审核的订单
    public function del($order_id)
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '客服') {
            $this->error('无权限删除！', 'index/order/index', null, 0);
        }
        $res = (new \app\index\model\Order())->del($order_id);
        if ($res['valid']) {
            $this->success('删除成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //关键词搜索
    //搜索
    public function searchResult()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Order())->searchBy(input('post.'));
        }
        if ($res) {
            $this->assign('order', $res);
        } else {
            $this->error('不存在', 'index/order/index', null, 1);
            exit;
        }
        return $this->fetch();
    }
}
