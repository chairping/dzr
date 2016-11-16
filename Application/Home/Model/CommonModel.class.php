<?php
namespace Home\Model;
use Think\Model;
use Think\Model\AdvModel;
//class CommonModel extends AdvModel {
class CommonModel extends AdvModel {
    protected $optimLock        =   false;//默认不开启乐观锁，跟正常model一样

    public function getList($param2) {
        $param = array("table" => "", "field" => "*", "order" => "id DESC","condition" => "1=1");
        $param = array_merge($param, $param2);
        if ($param["table"] != "") {
            $param["table"] = str_replace(" ", "", $param["table"]);
            $table_arr = explode(",", $param["table"]);
            $param["table"] = array();
            foreach ($table_arr as $value) {
                $param["table"][C("DB_PREFIX") . $value] = $value;
            }
        }
        $list = array();
        $list = $this->field($param["field"])->where($param["condition"])->order($param["order"])->limit($param["limit"])->select();
        return $list;
    }
    
    public function getPageList($param2) {
        if( is_array($param2['condition']) ){
            $param2['condition']['root_id'] = getHomeRootID();
        }
        $param = array("table" => "", "field" => "*", "order" => "id DESC", "pageCurrent" => I('request.pageCurrent',1,'int'), "pageSize" => I('request.pageSize',20,'int'), "condition" => "1=1");
        $param = array_merge($param, $param2);
        if ($param["table"] != "") {
            $param["table"] = str_replace(" ", "", $param["table"]);
            $table_arr = explode(",", $param["table"]);
            $param["table"] = array();
            foreach ($table_arr as $value) {
                $param["table"][C("DB_PREFIX") . $value] = $value;
            }
        }
        $list = array();
        $list["total"] = $param["table"] == "" ? $this->field($param["field"])->where($param["condition"])->count() : $this->table($param["table"])->field($param["field"])->where($param["condition"])->count();
        $list["pageSize"] = $param["pageSize"];
        $list["pageTotal"] = intval(ceil($list["total"] / $list["pageSize"]));
        $list["pageCurrent"] = intval($param["pageCurrent"]) > $list["pageTotal"] ? $list["pageTotal"] : intval($param["pageCurrent"]);
        $list["pageCurrent"] = $list["pageCurrent"] < 1 ? 1 : $list["pageCurrent"];
        $list["data"] = $param["table"] == "" ? $this->field($param["field"])->where($param["condition"])->order($param["order"])->page($list["pageCurrent"], $list["pageSize"])->select() : $this->table($param["table"])->field($param["field"])->where($param["condition"])->order($param["order"])->page($list["pageCurrent"], $list["pageSize"])->select();

        $list["pageStart"] = $list["pageCurrent"] > 2 ? $list["pageCurrent"] - 2 : 1;
        
        if ($list["pageCurrent"] <= $list["pageTotal"] - 2) {
            $list["pageEnd"] = $list["pageCurrent"] + 3;
        } else if ($list["pageCurrent"] <= $list["pageTotal"] - 1) {
            $list["pageEnd"] = $list["pageCurrent"] + 2;
        } else {
            $list["pageEnd"] = $list["pageCurrent"] + 1;
        }
        return $list;
    }
    
    public function getFormatPageList($param2){
        $user_model = M("UserInfo");
        
        $list = $this->getPageList($param2);
        if(is_array($list["data"])){
            foreach($list["data"] as $key => $value){
                if(isset($value['root_id']) && $value['root_id'] > 0){
                    $user = $user_model->where("id=".$value['root_id'])->find();
                    $list["data"][$key]['root_name'] = $user['name'];
                }
                if(isset($value['update_user_id']) && $value['update_user_id'] > 0){
                    $user = $user_model->where("id=".$value['update_user_id'])->find();
                    $list["data"][$key]['update_user_name'] = $user['name'];
                }
                if(isset($value['user_id']) && $value['user_id'] > 0){
                    $user = $user_model->where("id=".$value['user_id'])->find();
                    $list["data"][$key]['user_name'] = $user['name'];
                }
            }
        }
        return $list;
    }

 /**
     * 检查乐观锁(重写方法，以最新编辑时间为准)
     * @access protected
     * @param inteter $id  当前主键     
     * @param array $data  当前数据
     * @return mixed
     */
    protected function checkLockVersion($id,&$data) {
        // 检查乐观锁
        $identify   = $this->name.'_'.$id.'_lock_version';
        
        if($this->optimLock && isset($_SESSION[$identify])) {
            $lock_version = $_SESSION[$identify];
            $vo   =  $this->field($this->optimLock)->find($id);
            $curr_version = $vo[$this->optimLock];
            //*******************因为AdvModel在find之后会用查询出来的最新的值保存，这是错误的。要用之前用户的version********************//
            $_SESSION[$identify]     =   $lock_version;
      
            if(isset($curr_version)) {
                if($curr_version>0 && $lock_version != $curr_version) {
                    // 记录已经更新
                    $this->error = L('_RECORD_HAS_UPDATE_');
                    //***************这里是等到不一致的时候进行一次更新，符合乐观锁的机制,也就等于要去用户再刷新一次*****************//
                    $this->cacheLockVersion( array( $this->optimLock=>$curr_version,$this->getPk()=>$id) );
                    return false;
                }else{
                    //*******************更新乐观锁记录的最新时间********************//
                    $_SESSION[$identify]     = time();
                }
            }
        }
        return true;
    }
    
    // 查询成功后的回调方法（重改写，屏蔽自动更新lock_version（因为代码会经常用find），等到出错时候再更新（checkLockVersion部分））
    protected function _after_find(&$result,$options='') {
        // 检查序列化字段
        $this->checkSerializeField($result);
        // 获取文本字段
        $this->getBlobFields($result);
        // 检查字段过滤
        $result   =  $this->getFilterFields($result);
        
        if(   $this->optimLock  ){//相当于缓存乐观锁操作，只不过是未设置时先初始化
            $id =  $result[  $this->getPk()]; 
            $identify   = $this->name.'_'.$id.'_lock_version';  
            !isset($_SESSION[$identify]) &&  $_SESSION[$identify] = $result[  $this->optimLock ];
        }
        // 缓存乐观锁（改写，屏蔽，因为代码会经常用find）
        //$this->cacheLockVersion($result);
       
    }

        /*
    * @author 曹梦瑶
    * 用户升级 联动用户的推荐人升级
    * @params 升级用户id 升级星级数
    */
    public function upgrade($user_id){
//        $user_id = 16800053;     //测试

        //寻找用户id是否有推荐人 以及推荐人底下的被推荐人 和用户等级相同的几个 是否满足升级规则
        $referee_store_num = M('sisa_user_info')->where(array('id' => $user_id))->getField('store_num');
        if ($referee_store_num) {
            //判断该推荐码是否有效
            $is_exist = M('sisa_user_info')->where(array('my_id' => $referee_store_num))->find();
            $star_all_cmy = M('sisa_star_level_role')->where(array('status' => 1))->getField('to_star_level', true);
            if(!in_array($is_exist['star_level'] + 1, $star_all_cmy)) {
                return true;
            }

            if ($is_exist) {
                //推荐人相应升级星级数 限制表
                $star_level_role_list = M('sisa_star_level_role')->where(array('status' => 1, 'to_star_level' => $is_exist['star_level'] + 1))->field(array('user_num', 'start_level', 'to_star_level'))->select();
                foreach ($star_level_role_list as $k => $v) {
                    $person_real_num = M('sisa_user_info')->where(array('store_num' => $referee_store_num,
                        'main_id' => 1, 'status' => 1, 'star_level' => $v['start_level']))->count();
                    if ($person_real_num >= $v['user_num']) {
                        return true;
                    }

                }

            }
        }
        return false;
    }


    /*
  * @author 曹梦瑶
  * 用户升级 联动用户的推荐人升级
  * @params 升级用户id 升级星级数
  */
    public function upgrade1($user_id, $star_level) {
//    public function upgrade() {     //测试
//        $user_id = 16800019;     //测试
//        $star_level = 2;    //测试
        //推荐人相应升级星级数 表
        $star_level_role_list = M('sisa_star_level_role')->where(array('status' => 1))->field(array('user_num', 'start_level', 'to_star_level'))->select();
        $star_role = array();       //会员个数_会员星级=> 推荐人相应升级星级数
        $person_num = array();      //取出升级呗推荐人个数
        foreach ($star_level_role_list as $k => $v) {
//            $temp[$v['user_num'].'_'.$v['start_level']] = $v['to_star_level'];
//            $star_role[$v['user_num']][] = $temp;
            $star_role[$v['user_num']][$v['user_num'].'_'.$v['start_level']] = $v['to_star_level'];

            !in_array($v['user_num'], $person_num) && $person_num[] = $v['user_num'];

        }

        //寻找用户id是否有推荐人 以及推荐人底下的被推荐人 和用户等级相同的几个 是否满足升级规则
        $referee_store_num = M('sisa_user_info')->where(array('id'=>$user_id))->getField('store_num');
        if($referee_store_num) {
            //判断该推荐码是否有效
            $is_exist =  M('sisa_user_info')->where(array('my_id'=>$referee_store_num))->find();
            if($is_exist) {
                //查找推荐人 除了用户 底下的被推荐人和用户等级一样的有效等级
                foreach ($person_num as $k => $v) {
                    $person_list = M('sisa_user_info')->where(array('store_num'=>$referee_store_num, 'is_upgrade'=>1,
                        'main_id'=>1, 'star_level'=>$star_level))->limit($v)->select();
                    if($person_list) {
                        //推荐人等级升级 等级联动生效
                        M('sisa_user_info')->where(array('my_id'=>$referee_store_num))->save(array(
                            'star_level' => $is_exist['star_level'] + $star_role[$v][$v.'_'.$star_level],
                            'update_time' => time(),
                            'is_upgrade' => 1
                        ));
//                            dd(M('sisa_user_info')->getLastSql());
                        //被推荐人 这里包括用户 等级联动失效
//                            M('sisa_user_info')->where(array('id'=>$user_id))->save(array(
//                                'update_time' => time(),
//                                'is_upgrade' => 1
//                            ));

                        foreach ($person_list as $kk => $vv) {
                            M('sisa_user_info')->where(array('id'=>$vv['id']))->save(array(
                                'update_time' => time(),
                                'is_upgrade' => 2
                            ));
                        }

                        //递归
//                        $this->upgrade('168'.$referee_store_num, $is_exist['star_level'] + $star_role[$v][$v.'_'.$star_level]);
                    }
                }

            }

        } 

    }


}

?>
