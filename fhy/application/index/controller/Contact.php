<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Contact extends Common
{
    //
    public function index()
    {
        //判断用户权限
        $auth = Request::instance()->session('role');
        if ($auth !== '系统管理员' && $auth !== '基础数据管理员') {
            $this->error('无权限访问！', 'index/entry/index', null, 0);
        }
        //获取已经存在的客户数据
        $data = (new \app\index\model\Contact())->findData();
        $this->assign('contact', $data);
        return $this->fetch();
    }

    public function addContact()
    {
        //检验用户输入
        if (request()->isPost()) {
            $res = (new \app\index\model\Contact())->addContact(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index/contact/index', null, 0);
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }
    }

    //联系人详情
    public function change($contact_id)
    {
        //渲染数据
        $data = null;
        try {
            $data = Db::table('contact')->where('contact_id', $contact_id)->find();
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        $this->assign('contact', $data);
        return $this->fetch();
    }

    //更新数据
    public function updateData()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Contact())->updateData(input('post.'));
        }
        if ($res['valid']) {
            $this->success('更新成功', 'index/contact/index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index/contact/index', null, 1);
            exit;
        }

    }

    //删除联系人
    public function del($contact_id)
    {
        $res = (new \app\index\model\Contact())->del($contact_id);
        if ($res['valid']) {
            $this->success('删除成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //搜索
    public function searchResult()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Contact())->searchBy(input('post.'));
        }
        if ($res) {
            $this->assign('contact', $res);
        } else {
            $this->error('不存在', 'index/contact/index', null, 1);
            exit;
        }
        return $this->fetch();
    }

}
