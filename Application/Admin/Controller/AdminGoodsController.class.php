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
use Common\Lib\Wx\Wx;

class AdminGoodsController extends AdminController
{

    public $goodsModel;

    public function _initialize() {
        $this->goodsModel= D('Goods');
    }

    public function index() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $is_integral = I('is_integral', 0, 'intval');
        $is_better= I('is_better', 0, 'intval');
        $integral_sort_id = I('integral_sort_id', 0, 'intval');

        $where = array(
            'status' => 1
        );

        if ($is_integral) {
            $where['is_integral'] = $is_integral;
        }

        if ($is_better) {
            $where['is_better'] = $is_better;
        }

        if ($integral_sort_id) {
            $where['integral_sort_id'] = $integral_sort_id;
        }

        $data = $this->goodsModel->getListWithCount($where, $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];
        array_walk($goodsList, function(&$row) {

            if ($row['is_integral'] == 1) {
                $row['price'] = formatMoney($row['price'], true);
            }

        });
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $sortObj = D('IntegralSort');

        $sortList  = $sortObj->where(array('status' => 1))->select();
        $sortList = array_column($sortList, 'name', 'id');

        $this->assign('sortList', $sortList);

        $this->assign('goods_list', $goodsList );
        $this->display();
    }

    public function add() {
        if (IS_POST) {

            $data = I('post.');
            $data['update_time'] = time();

            if(I('is_integral' == 1)) {
                $data['price'] = formatMoney($data['price']);
            }

            $coverAddr = $data['cover_img_addr'];


            $base64Img = new Base64Image('sale', $coverAddr);
            $data['cover_img_addr'] = $base64Img->deal();

            if($this->goodsModel->add($data)) {
                echo "<script>location.href='".__ROOT__."/admin.php/AdminGoods/index';</script>";
                exit;
//                $this->redirect('AdminGoods/index');
//                $this->ajaxReturn(['code' => 1, 'message' => '商品添加成功']);
            } else {
                $this->error("商品添加失败");
//                $this->ajaxReturn(['code' => 0, 'message' => '商品添加失败']);
            }

        } else {


            $sortObj = D('IntegralSort');

            $sortList  = $sortObj->where(array('status' => 1))->select();
            $sortList = array_column($sortList, 'name', 'id');

            $this->assign('sortList', $sortList);

            $this->display();

        }

    }

    public function edit() {
        if (IS_POST) {

            $id = I('id', 0, 'intval');

            if (!$id) {
                $this->error('非法访问');
            }

            $data = I('post.');

            if(I('is_integral' == 1)) {
                $data['price'] = formatMoney($data['price']);
            }

            unset($data['id']);

            $coverAddr = $data['cover_img_addr'];
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $coverAddr, $result)){
                $base64Img = new Base64Image('sale', $coverAddr);
                $data['cover_img_addr'] = $base64Img->deal();
            }

            if($this->goodsModel->edit($id, $data) >= 0) {
                $this->redirect(cp_U('AdminGoods/index'));
            } else {
                $this->error("商品添加失败");
            }
        
        } else {
            $id = I('id', 0, 'intval');
        
            if (!$id) {
                $this->error("非法访问");
            }

            $sortObj = D('IntegralSort');

            $sortList  = $sortObj->where(array('status' => 1))->select();
            $sortList = array_column($sortList, 'name', 'id');

            $this->assign('sortList', $sortList);

            $data = D('Goods')->find($id);
            $data['price'] = formatMoney($data['price'], true);
            $this->assign('data', $data );
            $this->display();
        }
    }

    public function del() {
        $id = I('post.id', 0, 'intval');

        if ($id) {
            $status = $this->goodsModel->where(['id'=> $id])->save(['status'=> 2, 'update_time' => time()]);
            if ($status) {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '删除成功'
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

    public function sortDel() {
        $id = I('post.id', 0, 'intval');

        if ($id) {
            $sortObj = D('IntegralSort');
            $status = $sortObj->where(['id'=> $id])->save(['status'=> 2, 'update_time' => time()]);
            if ($status) {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '删除成功'
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

    public function saleSwitch() {
        $id = I('post.id', 0, 'intval');


        if ($id) {
            $data = $this->goodsModel->find(['id'=> $id]);

            if ($data['sale_status'] == 1) {
                $status = $this->goodsModel->where(['id'=> $id])->save(['sale_status'=> 2, 'update_time' => time()]);

            } else {
                $status = $this->goodsModel->where(['id'=> $id])->save(['sale_status'=> 1, 'update_time' => time()]);
            }

            if ($status) {
                $this->ajaxReturn([
                    'code' => 1,
                    'msg' => '操作成功'
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

    public function cropAvatar() {
        $this->display();
    }

    public function scoreGoodsIndex() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $sortObj = D('IntegralSort');

        $result = $sortObj->getListWithCount(array('status' => 1), $page, $pageSize, 'update_time desc');

        $count = $result['count'];

        $this->_pageShow($count, $pageSize);
        $this->assign('data', $result['data']);

        $this->display();
    }

    public function scoreGoodsTypeAdd() {

        $id = I('id', 0, 'intval');

        if($id) {
            $status = D('IntegralSort')->where(array('id' => $id))->save(array(
                'name' => I('name'),
                'update_time' => time(),
            ));

        } else {
            $sortObj = D('IntegralSort');

            if ($sortObj->where(array('name' => I('name')))->find()) {

                $this->ajaxReturn([
                    'code' => 0,
                    'msg' => '该分类已存在'
                ]);
            } else {
                $status = D('IntegralSort')->add(array(
                    'name' => I('name'),
                    'update_time' => time(),
                    'status' => 1
                ));
            }
        }

        if ($status) {
            $this->ajaxReturn([
                'code' => 1,
                'msg' => '操作成功'
            ]);
        } else {
            $this->ajaxReturn(array(
                'code' => 0,
                'msg' => '操作失败'
            ));
        }
    }



    public function test() {
        $wx = new Wx();

//        $result = $wx->qrcodeCreate(1);
//        dd($result);

        $ticket ='gQG28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL09reERTUTNrNTNtZXVXTlUyMkJVAAIEVZ0xWAMEAAAAAA==';

        $resutl = $wx->showQrcode($ticket);
        dd($resutl);

//        array(2) {
//            ["ticket"]=>
//  string(96) "gQG28DoAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL09reERTUTNrNTNtZXVXTlUyMkJVAAIEVZ0xWAMEAAAAAA=="
//            ["url"]=>
//  string(43) "http://weixin.qq.com/q/OkxDSQ3k53meuWNU22BU
//
//"
//}
    }

}
