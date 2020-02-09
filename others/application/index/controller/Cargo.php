<?php

namespace app\index\controller;

use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Cargo extends Common
{
    public function index()
    {
        //判断用户权限
        $auth = Request::instance()->session('role_name');
        if ($auth !== '系统管理员' && $auth !== '基础数据管理员') {
            $this->error('无权限访问！', 'index/entry/index', null, 0);
        }

        //获取已经存在的货物数据
        $data = (new \app\index\model\Cargo())->findData();
        $this->assign('cargo', $data);
        return $this->fetch();
    }

    //新增货物
    public function addCargo()
    {
        //检验用户输入
        if (request()->isPost()) {
            $res = (new \app\index\model\Cargo())->addCargo(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index/cargo/index', null, 0);
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }
    }

    //删除货物
    public function del($cargo_id)
    {
        $res = (new \app\index\model\Cargo())->del($cargo_id);
        if ($res['valid']) {
            $this->success('删除成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //更新货物页面
    public function change($cargo_id)
    {
        //渲染数据
        $data = null;
        try {
            $data = Db::table('cargo')->where('cargo_id', $cargo_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        $this->assign('cargo', $data);
        return $this->fetch();
    }

    //更新货物数据
    public function updateData()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Cargo())->updateData(input('post.'));
        }
        if ($res['valid']) {
            $this->success('修改成功', 'index/cargo/index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index/cargo/index', null, 1);
            exit;
        }

    }

    //关键词搜索
    //搜索
    public function searchResult()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Cargo())->searchBy(input('post.'));
        }
        if ($res) {
            $this->assign('cargo', $res);
        } else {
            $this->error('您所查找的数据不存在', 'index/cargo/index', null, 1);
            exit;
        }
        return $this->fetch();
    }

}
