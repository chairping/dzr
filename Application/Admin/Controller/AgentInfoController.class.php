<?php
namespace Admin\Controller;
use Common\Controller\AgentController;
use Common\Lib\Base64Image;

class AgentInfoController extends AgentController{
    public function __construct() {
        parent::__construct();
    }

    /*
     * @author 曹梦瑶
     * 信息管理
     */
    public function index(){
        //获取用户信息
         $id = getHomeUserID();
        $list = D('AdminInfo')->getInfo($id);

        //获取代理景点信息
        $spots_info = D('ScenicSpots')->getInfoById($list['scenic_spots_id']);

//        dd($list,$spots_info);

        $this->assign('user_info', $list);
        $this->assign('spots_info', $spots_info);
        $this->display('index');
    }

    /*
     * @author 曹梦瑶
     * 修改景点图片
     */
    public function uploadProduct() {


        $coverAddr = I('post.img_addr');
        $spots_id = I('post.spots_id');

        $data = [];

        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $coverAddr, $result)){
            $base64Img = new Base64Image('spots', $coverAddr);
            $data['img_addr'] = $base64Img->deal();
        }

        $spots_info = D('ScenicSpots')->where(['id' => $spots_id])->save($data);

        if ($spots_info>= 0) {
            $this->ajaxReturn( array( "code" => 1, "msg" => '操作成功' ) );

        } else {
            $this->ajaxReturn( array( "code" => 0, "meg" => '操作失败' ) );

        }


    }

    /*
     * @author 曹梦瑶
     * 修改信息
     */
    public function changeInfo() {
        $post = I('post.');
        $id = $post['id'];
        $data = $post;
        unset($data['id']);

        $is = D('AdminInfo')->saveInfoById($id, $data);
        if($is) {
            $this->ajaxReturn(
                array(
                    "statusCode" => C( 'SUC_CODE' ),
                    "message" => '操作成功') );
        }

        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'修改信息失败'));
    }

    
}
