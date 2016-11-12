<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/11
 * Time: 22:22
 */

namespace Admin\Controller;


use Common\Controller\AdminController;

class AdminGoodsController extends AdminController
{
    public function index() {

        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $data = D("Goods")->getListWithCount([], $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $this->assign('goods_list', $goodsList );
        $this->display();
    }

    public function add() {
        
        $data = I('post.');
        $data['update_time'] = time();
        if(D('Goods')->add($data)) {
            $this->ajaxReturn(['code' => 1, 'message' => '商品添加成功']);
        } else {
            $this->ajaxReturn(['code' => 0, 'message' => '商品添加失败']);
        }
    }

    public function edit() {
        if (IS_POST) {
        
        
        
        } else {
            $id = I('id', 0, 'intval');
        
            if (!$id) {
                $this->error("非法访问");
            }

            $data = D('Goods')->find($id);

            $this->assign('data', $data );
            $this->display();
        }
    }

}
