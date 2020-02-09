<?php

namespace app\index\controller;


use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;

class Custom extends Common
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
        $data = (new \app\index\model\Custom())->findData();
        $this->assign('custom', $data);
        return $this->fetch();
    }

    public function addClient()
    {
        //检验用户输入
        if (request()->isPost()) {
            $res = (new \app\index\model\Custom())->addUser(input('post.'));
            if ($res['valid']) {
                $this->success($res['msg'], 'index/custom/index', null, 0);
                exit;
            } else {
                $this->error($res['msg']);
                exit;
            }
        }
    }

    //删除客户
    public function del($custom_id)
    {
        $res = (new \app\index\model\Custom())->del($custom_id);
        if ($res['valid']) {
            $this->success('删除成功', 'index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index', null, 1);
            exit;
        }
    }

    //更新客户
    public function change($custom_id)
    {
        //渲染数据
        $data = null;
        $contact = [];
        try {
            $data = Db::table('custom')->where('custom_id', $custom_id)->find();
            $contact = Db::table('contact')->where('custom_id', $custom_id)->select();
            for ($i = 0; $i < count($contact); $i++) {
                $contact_num = 'contact' . (string)($i + 1);
                $data[$contact_num] = $contact[$i]['name'];
            }
        } catch (DataNotFoundException $e) {
        } catch (ModelNotFoundException $e) {
        } catch (DbException $e) {
            return ['valid' => 0, 'msg' => '数据库错误！'];
        }
        $this->assign('custom', $data);
        return $this->fetch();
    }

    //更新数据
    public function updateData()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Custom())->updateData(input('post.'));
        }
        if ($res['valid']) {
            $this->success('更新成功', 'index/custom/index', null, 1);
            exit;
        } else {
            $this->error($res['msg'], 'index/custom/index', null, 1);
            exit;
        }

    }

    //搜索联系人
    public function searchContact()
    {
        $res = null;
        if (request()->isPost()) {
            $data = input('post.');
            if (!$data) {
                return null;
            }
            $res = (new \app\index\model\Custom())->searchContact($data['contact_name']);
            if ($res) {
                $this->success('', '', $res);
            } else {
                $this->error('查询失败！');
            }
        }
    }

    //关键词搜索
    //搜索
    public function searchResult()
    {
        $res = null;
        if (request()->isPost()) {
            $res = (new \app\index\model\Custom())->searchBy(input('post.'));
        }
        if ($res) {
            $this->assign('custom', $res);
        } else {
            $this->error('不存在', 'index/custom/index', null, 1);
            exit;
        }
        return $this->fetch();
    }

}
