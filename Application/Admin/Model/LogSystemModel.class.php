<?php

namespace Admin\Model;

use Think\Model;
use Admin\Model\CommonModel;

class LogSystemModel extends Model {
    protected $tableName = "log_system";

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
     * 查找 登录用户历史记录
     */
    public function getInfo() {
        $username = session('username');
        
        $list = $this->where(array(
            'username' => $username,
        ))
            ->order('id desc')
            ->limit(50)
            ->select();
//        dd($list);
        return $list;
    }

}

?>