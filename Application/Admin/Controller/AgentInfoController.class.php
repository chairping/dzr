<?php
namespace Admin\Controller;
use Common\Controller\AgentController;

class AgentInfoController extends AgentController{
    public function _initialize() {

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
        $img_data = $_FILES;
        $temp_data = $img_data['photo'];
        dd($_FILES);
//        if($temp_data['name'] == '' || $temp_data['name'] == null) {
//            $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => L('Look_img_first') ) );
//        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =      dirname(realpath(APP_PATH)).'/Uploads/images/'; // 设置附件上传根目录
        $upload->savePath  =      ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功 获取上传文件信息
            foreach($info as $file){
//                echo $file['savepath'].$file['savename'];exit;
            }
        }
//        dd($info);
        //地址要切回绝对路径
        $img = __ROOT__.'/Uploads/images/'.$info['photo']['savepath'].$info['photo']['savename'];
dd($img);
        $id = I('post.id');
        $num = I('post.banner');


        $is = D('ProductInfo')->changeProductImg($id, $num, $img);
        if($is !== false) {

            $img_addr = D('TempImg')->getImg();
            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ),
                "message" => L('Successful_operation'), 'img_arr'=>$img ));


        }

        $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => L('Fail_operation') ) );

    }


}
