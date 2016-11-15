<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/11
 * Time: 22:22
 */

namespace Admin\Controller;


use Common\Controller\AdminController;

class AdminScenicController extends AdminController
{

    public $ScenicModel;
    public $AdminInfo;
    public $Order;

    public function _initialize() {
        $this->ScenicModel= D('ScenicSpots');
        $this->AdminInfo = D('AdminInfo');
        $this->Order = D('Order');
    }

    public function index() {

        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $data = $this->ScenicModel->getListWithCount([], $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $this->assign('goods_list', $goodsList );
        $this->display();
    }

    public function add() {
        
        $data = I('post.');
        $data['update_time'] = time();

        if($this->ScenicModel->add($data)) {
            $this->ajaxReturn(['code' => 1, 'message' => '商品添加成功']);
        } else {
            $this->ajaxReturn(['code' => 0, 'message' => '商品添加失败']);
        }
    }

    public function edit() {
        if (IS_POST) {

            $id = I('id', 0, 'intval');

            if (!$id) {
                $this->error('非法访问');
            }

            $data = I('post.');
            unset($data['id']);

            if($this->ScenicModel->edit($id, $data)) {
                $this->ajaxReturn(['code' => 1, 'message' => '商品编辑成功']);
            } else {
                $this->ajaxReturn(['code' => 0, 'message' => '商品失败']);
            }
        
        } else {
            $id = I('id', 0, 'intval');
        
            if (!$id) {
                $this->error("非法访问");
            }

            $data = $this->ScenicModel->find($id);

            $this->assign('data', $data );
            $this->display();
        }
    }

    public function agentList() {

        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $result = $this->ScenicModel->scenicsSale($page, $pageSize);
        $count = $result['count'];
        $data = $result['data'];

        $this->_pageShow($count, $pageSize);

        $this->assign('data', $data);
        $this->display();
    }

    public function agentScenicSaleList() {
        $scenicId = I('id');

        $data = $this->Order->getInfoBySpots($scenicId);

        $spots = $this->ScenicModel->find($scenicId);
        $this->assign('data', $data);
        $this->assign('scenic_name', $spots['scenic_name']);
        $this->display();
    }

    public function agentAdd() {

        extract(I('post.'));
        try{
            if(!$this->AdminInfo->addUser($username, $password, $status, $scenic_spots_id)) {
                throw new \LogicException("代理添加失败");
            }
            $this->ajaxReturn(['code' => 1, 'message' => '代理添加成功']);

        } catch (\LogicException$e) {
            $this->ajaxReturn(['code' => 0, 'message' =>$e->getMessage()]);
        }
    }



}
