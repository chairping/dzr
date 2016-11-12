<?php

namespace Admin\Model;

use Think\Model;
use Admin\Model\CommonModel;

class AdminInfoModel extends Model {
    protected $tableName = "admin_info";

//    protected $optimLock        =   'update_time';
//    // 1->insert 2->update, 3->both require
//    protected $_validate = array(
////        array( 'mail', '', 'email已被注册！',0,'unique',1),
////        array( 'nickname', '', '登录名已被注册！',0,'unique',1 ),
////        array('mobile', 'require', '类型必须！'),
////        array( 'passwd', 'require', '密码必须！', 1 ,null,1),
////        array( 'status', array( 0, 1, 2 ,3), '值的范围不正确！', 1, 'in' ),
//        // array('group_name', 'unique', '名称已经存在！'),
//        // array('status',array(0,1),'值的范围不正确！',3,'in')// 在新增的时候验证name字段是否唯一
//    );
//    protected $_auto = array(
////        array('login_time', 'time', 1, 'function'),
////        array( 'root_id', 'getHomeRootID', 1, 'function' ),
////        array( 'create_time', 'time', 1, 'function' ), // 对create_time字段在更新的时候写入当前时间戳
//        array( 'update_time', 'time', 3, 'function' ), // 对update_time字段在更新的时候写入当前时间戳
//    );

    /*
     * @author 曹梦瑶
     * 判断账户是否存在
     */
    public function is_exist_username($username) {
        $return  = false;
        $is = $this->where(array(
            'username' => $username,
            'status' => 1
        ))
            ->find();
//        dd($this->getLastSql());
        $is && $return = true;
        return $return;
    }


//    public function find_email($email, $id) {
//        $is = $this->where(array(
//            'id' => array('neq', $id),
//            'email' => $email,
//            'status' => 1
//        ))
//            ->getField('id');
//
//        return $is;
//    }

    /*
     * @author 曹梦瑶
     * 判断d登录信息是否存在
     */
    public function is_exist($username, $pwd) {
//        $return  = false;
//        $user_id = $this->where(array('email'=>$email))->getField('id');
        $is = $this->where(array(
            'username' => $username,
            'password' => sha1($pwd)
        ))
            ->find();
//        $is && $return = true;
        return $is;
    }



//    public function register($data) {
//
//        $data['email'] = trim($data['email']);
////        dd( $data);
//        if($this->where(array('email' => $data['email']))->find()) {
//            return array("statusCode" => C('ERROR_CODE'),"message" => L('Error_email_be_used'));
//        }
//
//        $pwd = $data['pwd'];
//        $params_user['user_name'] =  $data['user_name'];
//        $params_user['email'] =  $data['email'];
//        $params_user['tel_num'] =  $data['tel_num'];
//        $params_user['update_time'] = time();
//        $params_user['register_time'] = time();
//
//        if ($this->create($params_user)) {
//            $id = $this->add();
//            $user_id = $id;
//            //保存密码 md5(密码 + id) --始
//            $params = array('pwd' => makePwd($id, $pwd), 'update_time' => time());
//            $this->where(array('id' => $id))->save($params);
//            //保存密码 md5(密码 + id) --终
//            //写日志
//            addApiLog('用户注册', 1);
//
//            //将店铺写入店铺表
//            $params_user['shop_name'] =  $data['shop_name'];
//            $params_user['shop_type_id'] =  $data['shop_type_id'];
//            $params_user['shop_owner_id'] =  $id;
//            $params_user['cover_img'] =  D('DefaultImage')->getImg();
//
//            $params_user['update_time'] =  time();
//            $id = D('ShopInfo')->addInfo($params_user);
//
//            //保存二维码
//            D('ShopInfo')->saveInfoImg1($id, $params_user['cover_img']);
//
//            //写日志
//            addApiLog('店铺注册', 1);
//
//            //设置一个默认的类别
//            D('CategoryInfo')->addOne($user_id);
//
//            return array("statusCode" => C('SUC_CODE'), "message" =>  L('Register_success'),'url' => __ROOT__.'/admin.php/Index/user_login' );
//        } else {
//            return array("statusCode" => C('ERROR_CODE'),"message" => L('Register_error') );
//        }
//    }
//
//    public function allDeleteById($id_arr) {
//        $is = $this->where(array(
//            'id' => array('in', $id_arr)
//        ))
//            ->save(array(
//                'status' => 2,
//                'update_time' => time()
//            ));
//        if($is !== false) {
//            return true;
//        }
//        return false;
//    }
//    public function allCnacelDeleteById($id_arr) {
//        $is = $this->where(array(
//            'id' => $id_arr
//        ))
//            ->save(array(
//                'status' => 1,
//                'update_time' => time()
//            ));
//        if($is !== false) {
//            return true;
//        }
//        return false;
//    }
//
//    public function deleteById($id) {
//        $is = $this->where(array(
//            'id' => $id
//        ))
//            ->save(array(
//                'status' => 2,
//                'update_time' => time()
//            ));
//        if($is !== false) {
//            return true;
//        }
//        return false;
//    }
//
//
//
//    /*
//     * @author 曹梦瑶
//     * 重置密码
//     */
//    public function resetPwd($tel_num, $pwd) {
//        $where = array(
//            'tel_num' => $tel_num
//        );
//        $id = $this->where( $where )->getField( 'id');
//        $is = $this->where($where)
//            ->save(array(
//                'pwd' => makePwd($id, $pwd),
//                'update_time' => time()
//            ));
//
//        if($is !== false) {
//            return 1;
//        } else {
//            return 0;
//        }
//    }
//
    /*
     * @author 曹梦瑶
     * 获取用户信息
     */
    public function getInfo($id) {
        $list = array();
        $list = $this->where(array(
            'id' => $id,
            'status' => 1
        ))
            ->find();
//        dd($this->getLastSql());
        return $list;
    }
//
//    public function getNoAllInfo() {
//        $list = array();
//        $list = $this->where(array(
//            'status' => 2
//        ))
//            ->select();
//        return $list;
//    }
//
//    public function saveInfoById($id, $data) {
//        $data['update_time'] = time();
////        $data['login_time'] = time();
//        $is = $this->where(array(
//            'id' => $id
//        ))
//            ->save($data);
//
//        if($is !== false) {
//            addApiLog('操作用户权限', 2);
//
//            return true;
//        } else {
//            return false;
//        }
//    }

}

?>