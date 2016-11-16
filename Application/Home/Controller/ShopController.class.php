<?php
namespace Home\Controller;
use Think\Controller;
class ShopController extends Controller {

    public function __construct() {
        parent::__construct();
        header("Content-Type:text/html; charset=utf-8");
    }

    /*
     * 本景点商品
     */
    public function shop() {
        //以下暂时注释掉
       /* $code = $_GET['code'];
        $url_data = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxf65f531bc5bad11c&secret=8d5bcc73f0a26475a706f35835305cb3&code=$code&grant_type=authorization_code");
        $url_data_real = json_decode($url_data, true);

        $openid = $url_data_real['openid'];

//      1、如果之前有扫描过景点的二维码，则跳转至UC3 景点主页
//      2、如果之前扫描过很多景点的二维码，则跳转至最近一次关注的景点主页
//      3、如果没有扫描过景点的二维码，则推送文字“你还没有关注过景点，请先关注景点”
//dd($openid);
        //查找用户是否关注过景点
        $spots_id = D('ActionHistory')->isIn($openid);*/

        $spots_id = 2; //测试
        if($spots_id) {
            //获取景点信息
            $spots_name = D('ScenicSpots')->getInfo($spots_id);

            //获取有效的商品信息
            $pro_arr = D('Goods')->getInfo();



//dd($product_info);
            $this->assign('spots_id', $spots_id);
            $this->assign('spots_name', $spots_name);
            $this->assign('pro_arr', $pro_arr );

            $this->display('index');
        } else {
            $this->display('notFind');
        }
    }

}