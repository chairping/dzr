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

class AdminWithDrawController extends AdminController
{

    public $Model;

    public function _initialize() {
        $this->Model= D('Withdraw');
    }

    public function index() {

        $type = I('type', 1, 'intval');
        $page = I('p', 0, 'intval');
        $pageSize = 10;


        $where = [];

        if ($type == 1) {
            $where['withdraw_status'] = 1;
        } else {
            $where['withdraw_status'] = 2;
        }

        $result = $this->Model->getInfoList($where, $page, $pageSize, 'update_time desc');

        $data = $result['data'];
        $count = $result['count'];
//var_dump($data);

        array_walk($data, function(&$row) {
            $spotsId = $row['scenic_spots_id'];
            $spotsInfo = D('ScenicSpots')->find($spotsId);
            $row['spots_name'] = $spotsInfo['scenic_name'];

        });
        $this->_pageShow($count, $pageSize);

        $this->assign('data', $data );

        $this->assign('complete_url', cp_U("AdminWithDraw/index", array('type'=> 1)));
        $this->assign('un_complete_url', cp_U("AdminWithDraw/index", array('type' => 2)));

        if ($type == 1) {
            $this->display('index');
        } else {
            $this->display('index2');
        }

    }

    public function check() {
        $id = I('id', 0, 'intval');

        if(!$id) {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '非法访问'
            ]);
        }

        if($this->Model->check($id)) {
            $this->ajaxReturn([
                'code' => 1,
                'msg' => '审核成功'
            ]);
        } else {
            $this->ajaxReturn([
                'code' => 0,
                'msg' => '审核失败'
            ]);
        }


    }



}
