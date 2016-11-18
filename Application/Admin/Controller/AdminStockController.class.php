<?php
/**
 * Created by PhpStorm.
 * User: cp
 * Date: 16/11/11
 * Time: 22:22
 */

namespace Admin\Controller;

use Common\Controller\AdminController;
use Common\Lib\Base64Image;

class AdminStockController extends AdminController
{

    public $model;

    public function _initialize() {
        $this->model= D('Stock');
    }

    public function index() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;


        $scenic_name = I('scenic_name');
        $id = I('id');

        $where = array(
            'scenic_spots_id' => $id,
        );

        $data = $this->model->getListWithCount($where, $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];

        $goods = D('Goods')->where(['status' => 1])->select();
        $goods = array_column($goods, 'title', 'id');


        array_walk($goodsList, function(&$row) use(&$goods) {
            $row['update_time'] = date("Y-m-d H:i:s", $row['update_time']);
            $goodsInfo = D('Goods')->find($row['goods_id']);
            $row['goods_name'] = $goodsInfo['title'];

            if (isset($goods[$row['goods_id']])){
                unset($goods[$row['goods_id']]);
            }
        });

        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $this->assign('data', $goodsList );
        $this->assign('goods', $goods );
        $this->assign('id', $id );
        $this->assign('scenic_name', $scenic_name );
        $this->display();
    }

    public function add() {

        $data = I('post.');
        $data['update_time'] = time();

        if (!I('goods_id')) {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '请选择库存商品'
            ]);
        }

        if (!I('stock_num')) {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '请填写库存数'
            ]);
        }



        $status = $this->model->add($data);

        if ($status) {
            $this->ajaxReturn([
                'code' => 1,
                'msg' => '操作成功'
            ]);
        } else {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '操作失败'
            ]);
        }

    }

    public function edit() {
        $id = I('post.id', 0, 'intval');

        if ($id) {

            $num = I('stock_num',0 , 'intval');

            if (!$num) {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '请填写库存数'
                ]);
            }

            $status = $this->model->where(['id'=> $id])->save(['stock_num'=> $num, 'update_time' => time()]);
            if ($status >= 0) {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '修改成功'
                ]);
            } else {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '操作失败'
                ]);
            }
        } else {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '非法访问'
            ]);
        }
    }

}
