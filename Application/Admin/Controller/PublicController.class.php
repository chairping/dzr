<?php

namespace Admin\Controller;

//use Common/Controller/BaseController;

class PublicController extends \Think\Controller {

    public function index() {

        $this->display();
    }
    /*
    * @author 曹梦瑶
    * 登录
    */
    public function login() {
//        dd(sha1(md5(123)));
        if (IS_POST) {
            $post = I('post.');
            $username = $post['username'];
            $pwd = $post['password'];

            if (!D('AdminInfo')->is_exist_username($username)) {
                $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'), "message" => '账户不存在'));
            }

            $user_info = D('AdminInfo')->is_exist($username, $pwd);
            if ($user_info) {

                //获取用户信息
                session('id', $user_info['id']);
                session('type', $user_info['type']);

                $type_name = C('TYPE_NAME');
                session('type_name', $type_name[$user_info['type']]);

                $this->ajaxReturn(
                    array(
                        "statusCode" => C( 'SUC_CODE' ),
                        "message" => '操作成功',
                        'url' => __ROOT__.'/admin.php/Index/index') );
                }
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'密码错误'));

         
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

    /*
     * @author 曹梦瑶
     * 修改个人信息
     */
    public function info() {
        $user_info = D('AdminInfo')->getInfo(session('id'));
//        dd($user_info);

        $this->assign('user_info', $user_info);
        $this->display('info');

    }

}
