<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    private $product;
//    private $user;
//    private $goods_carts;
//    private $integral_log;
    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
//        $this->product = M('sisa_product');
//        $this->user = M('user');
//        $this->goods_carts = M('goods_carts');
//        $this->integral_log = M('integral_log');
//        header("Content-Type:text/html; charset=utf-8");
    }

    /*
  *  生成指定长度的随机码。
  *  @param int $length 随机码的长度。
  *  @access public
 */
    public function createRandomCode($length) {
        $randomCode = "";
        $randomChars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $length; $i++) {
            $randomCode .= $randomChars { mt_rand(0, 35) };
        }
        return $randomCode;
    }

    /*
     * @author 曹梦瑶
     * 前台显示系统首页
     */
    public function index(){
//
//        $list = $this->product->where(array('status' => 1 ))->field(array('id', 'price', 'img', 'product_name'))->find();
////        $list['id'] = endes($list['id']);
//        $list['id'] = urlencode(endes($list['id']));
////        $list['id'] = urlsafe_b64decode($list['id']);
////        $list['id'] = base64_encode($list['id']);
////	$list['img'] = __ROOT__.$list['img'];
////昨日
//        $pay_review = M('sisa_pay_review');
//        $yesterday_start = strtotime(date("Y-m-d 00:00:00",strtotime("-1 day")));
//        $yesterday_end = strtotime(date("Y-m-d 23:59:59",strtotime("-1 day")));
////                $yesterday_end = time();
//        $num = $pay_review->where(array(
//            'review_time' => array(array('egt', $yesterday_start), array('elt', $yesterday_end)),
//            'review_status' => 2
//        ))->field(array('money', 'pro_id'))->select();
//
//        $turnover = 0;
//        foreach ($num as $k => $v ){
//            $turnover += $v['money'];
//        }
//
//        $this->assign('turnover', $turnover);
//
//        $this->assign('list', $list);
//        $this->display('Index/index');
    }

    /*
    * @author 曹梦瑶
    * 登录
    */
    public function login() {

//        if(1) {     //测试
        if(IS_POST) {
            $data = I('post.');
            $account = $data['account'];
            $pwd = $data['pwd'];
//            $tel_num = 123;     //测试
//            $pwd = 234;         //测试
            (empty($account) || empty($pwd)) && $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '账号或密码不能为空' ) );
            $user_info_Model = D('UserInfo');

            $id = $user_info_Model->where(array('account' => $account, 'status' => 1))->getField('id');
            if(!$id) {
                $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '账户不存在或者不可用' ) );
            }
            $is = $user_info_Model
                ->where(array(
                    'account' => $account,
                    'pwd' => makePwd($id, $pwd)
                ))->find();
//dd($user_info_Model->getLastSql(),$is);
            //if用户登录成功
            if($is) {
                unset($is['pwd']);
                unset($is['two_pwd']);
//                session('user_info', $is);
                session('id', $is['id']);
                //写入日志
                !empty(logLogin()) && $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ),
                    "message" => '登录成功','url' => __ROOT__.'/index.php/Index/index') );
                $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '登录失败' ) );
            } else {
                $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '登录失败，账号与密码不匹配' ) );
            }

        } else {
            $this->display('Index/login');
        }
    }

    /*
   * @author 曹梦瑶
   * 登出
   */
    public function logout() {
        session_destroy();
        addApiLog("用户退出", 3);
        $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ), "message" => '退出成功', 'url' => __ROOT__.'/index.php/Index/index') );
    }

    /*
     * 验证推荐人ID号存不存在
     */
    public function checkCode() {
//        $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' )) );    //测试！！！！！！！！！！！
        $code = I('post.code');
        if(D('UserInfo')->where(array('my_id'=>$code))->find()) {
            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' )) );
        } else {
            $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '推荐人ID号不存在' ) );
        }


    }

    /*
   * @author 曹梦瑶
   * 注册
   */
    public function register() {
//        if ( 1 ) {      //测试
        if ( IS_POST ) {
            $data = I('post.');
//            $data['user_name'] = '曹梦瑶';    //测试
//            $data['tel_num'] = '18850459421';  //测试
//            $data['pwd'] = 'ff18c8a4ae905b989bc5cebdc4ef8c2e'; //测试
//            $data['province_id'] = '4';//测试
//            $data['city_id'] = '55';//测试
//            $data['state_id'] = '538';//测试
//            $data['store_num'] = 'cmy001';//测试

            $data['account'] = trim($data['account']);
            (!$data['account'] || !$data['tel_num'] || !$data['pwd'] || !$data['two_pwd'] || !$data['province_id'] || !$data['city_id']
                || !$data['state_id']|| !$data['address']|| !$data['store_num']) && $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '参数输入有误' ) );

            $retRegisterInfo = D("UserInfo")->register($data);

            //会员联动升级
//            $this->upgrade(16800019, 2);

            $this->ajaxReturn( $retRegisterInfo );
        } else {
            //获得省份信息
            $province_info = D('Region')->getProvinceInfo();
            $city_info =  D('Region')->getCityByProvince(current($province_info)['region_id']);
            $state_info = D('Region')->getStateByCity(current($city_info)['region_id']);

            $agreement= $this->showAgreement();
            $this->assign('agreement', $agreement);
            $this->assign('province_info', $province_info);
            $this->assign('city_info', $city_info);
            $this->assign('state_info', $state_info);
            $this->display();
        }
    }

    /*
     * @author 曹梦瑶
     * 找回密码
     */
    public function findPwd() {
        if(IS_POST) {
            $tel_num = I('post.tel_num');

            $is = D('UserInfo')->where(array('tel_num' => $tel_num, 'status'=>1))->find();

            if(!$is) {
                $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '找回密码失败，该手机号不存在已经注册过的用户' ) );
            }

            //发送短信  --始
            $code = getCode();
            //将短信和验证码存入数据库表
            $is = M('sisa_message')->add(array(
                'tel_num' => $tel_num,
                'code' => $code,
                'update_time' => time()
            ));
            $is && $this->getSMS($code, '短信验证', $tel_num);
            //发送短信  --终

            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ),
                "message" => '操作成功','url' => __ROOT__."/index.php/Index/checkPwd/tel_num/$tel_num") );
//            $this->assign('tel_num', $tel_num);
//            $this->display('Index/checkPwd');

        } else {
            $this->display('findPwd');
        }
    }

    /*
     * @author 曹梦瑶
     * 验证验证码
     */
    public function checkPwd() {
        if(IS_POST) {
            $data = I('post.');
            $code = $data['code'];
            $tel_num = $data['tel_num'];
            //验证短信 --始

            if($code != M('sisa_message')->where(array('tel_num'=>$tel_num))->order('id desc')->getField('code', 1)) {
                $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '验证码错误' ) );
            }

            //验证短信 --终
//            cookie('tel_num', $tel_num);
            $list_account = D('UserInfo')->where(array('tel_num'=>$tel_num, 'status'=>1))->getField('account', true);
            cookie('list_account', $list_account);
//dd($list_account);
            $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ), 'url' => __ROOT__.'/index.php/Index/resetPwd') );
        } else {
            $tel_num = I('get.tel_num');
            $this->assign('tel_num', $tel_num);
            $this->display('checkPwd');
        }
    }

    /*
     * @author 曹梦瑶
     * 重置密码
     */
    public function resetPwd() {
        if(IS_POST) {
            $data = I('post.');
//            $tel_num = $data['tel_num'];
//            $tel_num =  cookie('tel_num');

            $account = $data['account'];
            $pwd = $data['pwd'];
            $is = D('UserInfo')->resetPwd1($account, $pwd);
            if(1 == $is) {
                //写入日志
                !empty(logLogin()) && $this->ajaxReturn( array( "statusCode" => C( 'SUC_CODE' ), "message" => '找回密码成功', 'url' => __ROOT__.'/index.php/Index/login') );
            }
            $this->ajaxReturn( array( "statusCode" => C( 'ERROR_CODE' ), "message" => '找回密码失败' ) );

        }  else {
            $list_account = cookie('list_account');
//            dd($list_account);
            $this->assign('list_account', $list_account);
            $this->display('resetPwd');
        }
    }

    /*
     * @author 曹梦瑶
     * 用户协议
     */
    public function showAgreement() {
        $list = array();
        $agreement_Model = M('sisa_agreement');
        $list = $agreement_Model->getField('agreement_content');
//            dd($list);
        $list = base64_decode($list);

        return $list;
//        $this->assign('list', $list);
//        $this->display();
    }

}
