<?php
namespace Common\Lib\Wx;


class Wx {

    protected $_url = 'https://api.weixin.qq.com/cgi-bin/';
    protected $app_id;
    protected $app_secret;
    protected $_token;

    public function __construct() {

        $this->app_id = C('WxPayConf_pub.APPID');
        $this->app_secret = C('WxPayConf_pub.APPSECRET');

        $this->_token = S('access_token');
        $this->getToken();
    }

    public function getToken() {
        if (!$this->_token) {

            $url = $this->_url . 'token?grant_type=client_credential&appid=' . $this->app_id . '&secret=' . $this->app_secret;
            $result = $this->_curlGet($url);
            $this->_token = $result['access_token'];

            S('access_token', $this->_token, 7200);

        }

        return $this->_token;
    }

    /**
     * 创建二维码
     * @param $spotsId
     * @return
     * {
     * "ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==",
     * "expire_seconds":60,
     * "url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"
     * }
     */
    public function qrcodeCreate($spotsId) {
        $url = $this->_buildUrl('qrcode/create');

        $params = array(
            "action_name" => "QR_LIMIT_SCENE",
            "action_info" => array(
                "scene" => array(
                    "scene_id" => $spotsId
                )
            )
        );

        return $this->_curlPost($url, json_encode($params));
    }

    /**
     * 二维码下载
     * @param $ticket
     * @param $id
     */
    public function showQrcode($ticket, $id) {
        $ticket = urlencode($ticket);

        $url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $ticket;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);

        $imageInfo = array_merge(array('body' => $package), array('header' => $httpinfo));
        $webPath = dirname(realpath(APP_PATH));
        $imagePath = '/Public/upload/qrcode'  . DIRECTORY_SEPARATOR;
        $saleImagePath =  $webPath . $imagePath;

        if (!is_readable($saleImagePath)) {
            if(!chmod($saleImagePath, 0777)) {
                throw new \LogicException("图片保存失败，{$saleImagePath}目录不可写");
            }
        }

        $filename = $saleImagePath . $id .".jpg";

        $local_file = fopen($filename, 'w');
        if (false !== $local_file){
            if (false !== fwrite($local_file, $imageInfo["body"])) {
                fclose($local_file);
            }
        }

    }

    /**
     * 构造访问地址
     * @param $action
     * @return string
     */
    public function _buildUrl($action) {
        return $this->_url . $action . '?access_token=' . $this->getToken();
    }

    protected function _curlGet($url, $params = [], $header = []) {

        $result = getUrl($url, $params);
        $result = json_decode($result, true);
        return $result;
    }

    protected function _curlPost($url, $params = [], $header = []) {
        $result = postUrl($url, $params);

        $result = json_decode($result, true);
        return $result;
    }

}