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

    /**
     * 景区列表
     */
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

    /**
     * 景区添加
     */
    public function add() {
        
        $data = I('post.');
        $data['update_time'] = time();

        if($this->ScenicModel->add($data)) {
            $this->ajaxReturn(['code' => 1, 'message' => '景区添加成功']);
        } else {
            $this->ajaxReturn(['code' => 0, 'message' => '景区添加失败']);
        }
    }

    /**
     * 景区编辑
     */
    public function edit() {
        if (IS_POST) {

            $id = I('id', 0, 'intval');

            if (!$id) {
                $this->error('非法访问');
            }

            $data = I('post.');
            unset($data['id']);

            if($this->ScenicModel->edit($id, $data)) {
                $this->ajaxReturn(['code' => 1, 'message' => '景区编辑成功成功']);
            } else {
                $this->ajaxReturn(['code' => 0, 'message' => '景区编辑失败']);
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

    /**
     * 景区代理销售列表
     */
    public function agentList() {

        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $result = $this->ScenicModel->scenicsSale($page, $pageSize);
        $count = $result['count'];
        $data = $result['data'];

        $this->_pageShow($count, $pageSize);

        array_walk($data, function(&$row){
            $row['total'] = formatMoney($row['total'],true);
            $row['today_total'] = formatMoney($row['today_total'],true);

            $info = $this->AdminInfo->where(['scenic_spots_id' => $row['id']])->find();

            if ($info) {
                $row['agent_name'] = $info['username'];
            } else {
                $row['agent_name'] = '暂无代理人';
            }
        });

        $this->assign('data', $data);

        $scenic = $this->ScenicModel->select();
        $this->assign('scenic', $scenic);
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 某个景区的销售详情列表
     */
    public function agentScenicSaleList() {
        $scenicId = I('id');

        $data = $this->Order->getInfoBySpots($scenicId);

        $spots = $this->ScenicModel->find($scenicId);

        array_walk($data, function(&$row) {
            $row['sales_price'] = formatMoney($row['sales_price'],true);

        });

        $this->assign('data', $data);
        $this->assign('scenic_name', $spots['scenic_name']);
        $this->display();
    }

    /**
     * 新增代理
     */
    public function agentAdd() {

        extract(I('post.'));
        try{


            if(!$this->AdminInfo->addUser($username, $password, $status, $scenic_spots_id, $type)) {
                throw new \LogicException("代理添加失败");
            }
            $this->ajaxReturn(['code' => 1, 'msg' => '代理添加成功']);

        } catch (\LogicException$e) {
            $this->ajaxReturn(['code' => 0, 'msg' =>$e->getMessage()]);
        }
    }



}
