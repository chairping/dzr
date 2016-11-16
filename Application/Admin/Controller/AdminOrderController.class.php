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

class AdminOrderController extends AdminController
{

    public $OrderModel;

    public function _initialize() {
        $this->OrderModel= D('Order');
    }

    public function index() {
        $page = I('p', 0, 'intval');
        $pageSize = 10;

        $data = $this->OrderModel->getListWithCount(['status'=> 1], $page, $pageSize, 'update_time desc');

        $goodsList = $data['data'];
        array_walk($goodsList, function(&$row) {
            $row['price'] = formatMoney($row['price'], true);
        });
        $count = $data['count'];

        $this->_pageShow($count, $pageSize);

        $this->assign('goods_list', $goodsList );
        $this->display();
    }




}
