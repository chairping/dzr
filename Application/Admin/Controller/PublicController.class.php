<?php

namespace Admin\Controller;

//use Common/Controller/BaseController;

class PublicController extends \Think\Controller {

    public function index() {

        var_dump(11);
    }
    /*
    * @author 曹梦瑶
    * 登录
    */
    public function login() {
        if (IS_POST) {
            $post = I('post.');
            $email = $post['username'];
            $pwd = $post['password'];

            if (!D('UserInfo')->is_exist_email($email)) {
                $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'), "mark" => 'email', "message" => L('Error_no_email')));
            }

            $is = D('UserInfo')->is_exist($email, $pwd);
            if (!$is) {
                $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'), "mark" => 'pwd', "message" => L('Error_pwd')));
            }


            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ), 'url' => __ROOT__.'/admin.php/Index/index') );
        } else {
            if (!session('id')) {
                $this->display('Public/login');
            } else {
                $this->display('Index/index');
            }
        }
    }

}
