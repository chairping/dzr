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
            $username = $post['username'];
            $pwd = $post['password'];

            if (!D('AdminInfo')->is_exist_username($username)) {
                $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'), "message" => L('Error_no_username')));
            }

            $is = D('AdminInfo')->is_exist($username, $pwd);
            if ($is !== false) {
                $this->ajaxReturn(
                    array(
                        "statusCode" => C( 'SUC_CODE' ),
                        "message" => L('Success'),
                        'url' => __ROOT__.'/admin.php/Index/index') );
                }
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" => L('Error_pwd')));

         
        } else {
            if (!session('id')) {
                $this->display('Public/login');
            } else {
                $this->display('Index/index');
            }
        }
    }

    /*
   * @author 曹梦瑶
   * 登出
   */
    public function logout() {
        session_destroy();
        $this->display('Public/login');
    }

}
