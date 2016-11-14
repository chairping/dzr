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

    public $goodsModel;

    public function _initialize() {
        $this->goodsModel= D('Goods');
    }

    public function index() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $data = $this->goodsModel->getListWithCount([], $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $this->assign('goods_list', $goodsList );
        $this->display();
    }

    public function add() {
        if (IS_POST) {

            $data = I('post.');
            $data['update_time'] = time();

            $coverAddr = $data['cover_img_addr'];

            $webPath = dirname(realpath(APP_PATH));
            $imagePath = '/Public/upload/sale/' . date("Y-m-d") . DIRECTORY_SEPARATOR;

            $saleImagePath =  $webPath . $imagePath;

            if (!file_exists($saleImagePath)) {
                if(!mkdir($saleImagePath)) {
                    throw new \LogicException("图片保存失败，{$saleImagePath}目录不可写");
                }
            }


            $fileName =  time() . '.jpg';

            $finalFilePath = $saleImagePath. $fileName;

            $new_file = $finalFilePath;
            $base64_body = substr(strstr($coverAddr,','),1);
            if (file_put_contents($new_file, base64_decode($base64_body))){
            } else{
            }

            $data['cover_img_addr'] = $imagePath . $fileName;

            if($this->goodsModel->add($data)) {
                $this->redirect('AdminGoods/index');
//                $this->ajaxReturn(['code' => 1, 'message' => '商品添加成功']);
            } else {
                $this->error("商品添加失败");
//                $this->ajaxReturn(['code' => 0, 'message' => '商品添加失败']);
            }

        } else {

            $this->display();

        }

    }

    public function edit() {
        if (IS_POST) {

            $id = I('id', 0, 'intval');

            if (!$id) {
                $this->error('非法访问');
            }
//            var_dump(I('post.'));exit;

            $data = I('post.');
            unset($data['id']);

            $coverAddr = $data['cover_img_addr'];

            $webPath = dirname(realpath(APP_PATH));
            $imagePath = '/Public/upload/sale/' . date("Y-m-d") . DIRECTORY_SEPARATOR;

            $saleImagePath =  $webPath . $imagePath;

            if (!file_exists($saleImagePath)) {
                if(!mkdir($saleImagePath)) {
                    throw new \LogicException("图片保存失败，{$saleImagePath}目录不可写");
                }
            }

            $fileName =  time() . '.jpg';

            $finalFilePath = $saleImagePath. $fileName;

            $new_file = $finalFilePath;
            $base64_body = substr(strstr($coverAddr,','),1);
            if (file_put_contents($new_file, base64_decode($base64_body))){
            } else{
            }

            $data['cover_img_addr'] = $imagePath . $fileName;

//            $coverAddr = base64_decode($coverAddr);
//            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $coverAddr, $result)){
//                $type = $result[2];
//
////                var_dump($type);exit;
//                $new_file = "./test.jpg";
//                if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $coverAddr)))){
//                    echo '新文件保存成功：';
//                } else{
//                    echo '新文件保存成功：';
//                }
//
//            }

//            $new_file = "./test.jpg";
//            $base64_body = substr(strstr($coverAddr,','),1);
//            if (file_put_contents($new_file, base64_decode($base64_body))){
////                echo '新文件保存成功：';
//            } else{
////                echo '新文件保存成功：';
//            }

//            var_dump($coverAddr);
//            exit;
//var_dump($data);exit;
            if($this->goodsModel->edit($id, $data) >= 0) {
//                $this->ajaxReturn(['code' => 1, 'message' => '商品编辑成功']);
                $this->redirect('AdminGoods/index');
            } else {
                $this->error("商品添加失败");
//                $this->ajaxReturn(['code' => 0, 'message' => '商品失败']);
            }
        
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

    public function cropAvatar() {
        $this->display();
    }

}
