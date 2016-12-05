<?php
namespace Home\Controller;
use Think\Controller;
class IntegralController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
   * @author 曹梦瑶
   * 积分商城
   */
    public function index() {
        $_SESSION['id'] = 1;  //测试
        $spots_id = 4; //测试
        //查找出用户的积分
        $integral = D('UserInfo')->getIntegral();

        //查找积分商品
        $goods = D('Goods')->getInfo(2);
        $banner = array();  //轮播的精品
        foreach ($goods as $k => $v) {
            if(2 == $v['is_better']) {
                $banner[] = $v;
            }
        }
//        dd($goods,$banner);

//
        $this->assign('spots_id', $spots_id);
        $this->assign('integral', $integral);
        $this->assign('goods', $goods);
        $this->assign('banner', $banner);
        $this->assign('menu', 'integral');
//        $this->assign('deliver_status', C('DELIVER_STATUS'));
//dd($order_info,$goods_info);
        $this->display('index');
    }

    /*
     * @author 曹梦瑶
     * 更多分类
     */
    public function showMore() {
        $sort_list = D('IntegralSort')->getInfo();
//        dd($sort_list);
        $this->assign('sort_list', $sort_list);
        $this->assign('menu', 'integral');
        $this->display('showMore');
    }

    /*
     * @author 曹梦瑶
     * 按分类搜索
     */
    public function sort_goods() {
        $sort_id = I('get.sort_id');
        $spots_id = 4; //测试


        //查找积分商品
        $goods = D('Goods')->getSortInfo($sort_id);
        
        //获取分类名称
        $sort_name = D('IntegralSort')->getNameById($sort_id);

//        dd($goods);

        $this->assign('sort_name', $sort_name);
        $this->assign('spots_id', $spots_id);
        $this->assign('goods', $goods);
        $this->assign('menu', 'integral');
        $this->display('sort_goods');

    }

}