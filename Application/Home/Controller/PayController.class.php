<?php

namespace Home\Controller;
use Think\Controller;

//var_dump(realpath(APP_PATH . '/Home/Common/lib/WxPay.Api.php'));exit;


class PayController extends Controller {

    public function __construct() {
        parent::__construct();

        vendor("WxPayPubHelper.WxPayPubHelper"); //导入外部类文件//
        header("Content-Type:text/html; charset=utf-8");
    }

    public function index() {
//        ①、获取用户openid
//        $tools = new \JsApiPay();
//        $openId = $tools->GetOpenid();
//
////②、统一下单
//        $input = new \WxPayUnifiedOrder();
//        $input->SetBody("test");
//        $input->SetAttach("test");
//        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
//        $input->SetTotal_fee("1");
//        $input->SetTime_start(date("YmdHis"));
//        $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag("test");
//        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
//        $input->SetTrade_type("JSAPI");
//        $input->SetOpenid($openId);
//        $order = \WxPayApi::unifiedOrder($input);

//        var_dump($order);exit;

    }


    public function jsApiCall()
    {
        //使用jsapi接口
        $jsApi = new \JsApi_pub();

        //=========步骤1：网页授权获取用户openid============
        //通过code获得openid
        if (!isset($_GET['code']))
        {
            //触发微信返回code码
            $url = $jsApi->createOauthUrlForCode(C('WxPayConf_pub.JS_API_CALL_URL'));
            Header("Location: $url");
            exit;
        }else
        {
            //获取code码，以获取openid
            $code = $_GET['code'];
            $jsApi->setCode($code);
            $openid = $jsApi->getOpenId();
        }

        //=========步骤2：使用统一支付接口，获取prepay_id============
        //使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub();

        //设置统一支付接口参数
        //设置必填参数
        //appid已填,商户无需重复填写
        //mch_id已填,商户无需重复填写
        //noncestr已填,商户无需重复填写
        //spbill_create_ip已填,商户无需重复填写
        //sign已填,商户无需重复填写
        $unifiedOrder->setParameter("openid", $openid);//商品描述
        $unifiedOrder->setParameter("body","贡献一分钱");//商品描述
        //自定义订单号，此处仅作举例
        $timeStamp = time();
        $out_trade_no = C('WxPayConf_pub.APPID').$timeStamp;
        $unifiedOrder->setParameter("out_trade_no", $out_trade_no);//商户订单号
        $unifiedOrder->setParameter("total_fee", "1");//总金额
        $unifiedOrder->setParameter("notify_url", C('WxPayConf_pub.NOTIFY_URL'));//通知地址
        $unifiedOrder->setParameter("trade_type", "JSAPI");//交易类型
        //非必填参数，商户可根据实际情况选填
        //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
        //$unifiedOrder->setParameter("device_info","XXXX");//设备号
        //$unifiedOrder->setParameter("attach","XXXX");//附加数据
        //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
        //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
        //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
        //$unifiedOrder->setParameter("openid","XXXX");//用户标识
        //$unifiedOrder->setParameter("product_id","XXXX");//商品ID

        $prepay_id = $unifiedOrder->getPrepayId();
        //=========步骤3：使用jsapi调起支付============
        $jsApi->setPrepayId($prepay_id);

        $jsApiParameters = $jsApi->getParameters();

        $this->assign('jsApiParameters',$jsApiParameters);
        $this->display('pay');
        //echo $jsApiParameters;
    }

}