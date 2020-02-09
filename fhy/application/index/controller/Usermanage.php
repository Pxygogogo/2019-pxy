<?php

namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class UserManage extends Common
{
    //
    public function index()
    {
        //判断用户权限
        if (Request::instance()->session('role') !== '系统管理员') {
            $this->error('无权限访问！', 'index/entry/index', null, 1);
        }
        //获取现有管理员数据渲染
        $data = (new User())->findData();
        $this->assign('field', $data);
        return $this->fetch();
    }

    //处理添加管理员的请求
    public function addUser()
    {
        if (request()->isPost()) {
            $res = (new User())->addUser(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index/usermanage/index', null, 0);
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }
    }

    //删除用户
    public function del($admin_id)
    {
        $res = (new User())->del($admin_id);
        if ($res['valid']) {
            $this->success('删除成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //更新用户权限
    public function change($admin_id)
    {
        //渲染数据
        $data = null;
        try {
            $data = Db::table('admin')->where('admin_id', $admin_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        $this->assign('detail', $data);
        return $this->fetch();
    }

    //更新数据
    public function updateData()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new User())->updateData(input('post.'));
        }
        if ($res['valid']) {
            $this->success('更新成功', 'index/usermanage/index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index/usermanage/index', null, 1);
            exit;
        }

    }

    //搜索
    public function searchResult()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new User())->searchBy(input('post.'));
        }
        if ($res) {
            $this->assign('field', $res);
        } else {
            $this->error('不存在', 'index/usermanage/index', null, 1);
            exit;
        }
        return $this->fetch();
    }

}
