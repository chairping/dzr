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
                session('username', $user_info['username']);
//dd($user_info, session('username'));
                $type_name = C('TYPE_NAME');
                session('type_name', $type_name[$user_info['type']]);

                //插入日志
                addApiLog('用户登录成功', 1);

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
        //插入日志
        addApiLog('用户退出成功', 1);

        session_destroy();

        $this->display('Public/login');
    }

    /*
     * @author 曹梦瑶
     * 修改个人信息
     */
    public function info() {
        $user_info = D('AdminInfo')->getInfo(session('id'));
        
        //登录记录
        $log_history = D('LogSystem')->getInfo();
//        dd($log_history);
        $this->assign('user_info', $user_info);
        $this->assign('log_history', $log_history);
        $this->display('info');

    }

    /*
     * @author 曹梦瑶
     * 修改密码
     */
    public function change_pwd() {
        $post = I('post.');
        $id = $post['id'];
        $pwd = $post['password'];
        $pwdr = $post['passwordr'];

        //判断原密码是否正确
        $user_info = D('AdminInfo')->is_exist_id($id, $pwd);

//        dd($user_info);
        if($user_info) {
            //修改密码
            $is = D('AdminInfo')->resetPwd($id, $pwdr);

            if($is) {
                $this->ajaxReturn(
                    array(
                        "statusCode" => C( 'SUC_CODE' ),
                        "message" => '操作成功') );
            }

        } else {
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'原密码输入不正确'));
        }
        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'修改密码失败'));

    }

    /*
     * @author 曹梦瑶
     * 保存修改个人信息
     */
    public function saveChange() {
        $post = I('post.');
        $id = $post['id'];
        $username = $post['username'];
        //判断账户是否已经存在
        $is_exist = D('AdminInfo')->is_exist_username($username, $id);
        if($is_exist) {
            $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'账号已经存在'));
        }

//        $type = $post['type'];
//        if($type != 2) {
            //非平台管理员
            $id = $post['id'];
//                        type: type,
//                        weixin_account: weixin_account,
//                        alipay_acount: alipay_acount,
//                        bank_name: bank_name,
//                        bank_user_name: bank_user_name,
//                        bank_account: bank_account,
//                        bank_branches: bank_branches,
            $data = $post;
            unset($data['id']);
            
            $is = D('AdminInfo')->saveInfoById($id, $data);
            if($is) {
                $this->ajaxReturn(
                    array(
                        "statusCode" => C( 'SUC_CODE' ),
                        "message" => '操作成功') );
            }
//        } else {
//
//        }

        $this->ajaxReturn(array("statusCode" => C('ERROR_CODE'),  "message" =>'修改信息失败'));

    }

}
