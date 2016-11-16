<?php
/** Home模块获取当前操作用户ID */
function getHomeUserID() {
    return $_SESSION['id'];
}


if (version_compare(PHP_VERSION,'5.5.0','<')) {
	function array_column($array, $value, $key = '') {
		$resultArray = array();

		foreach ($array as $k => $v) {
			if ($key) {
				$resultArray[$value[$key]] = $v[$value];
			} else {
				$resultArray[] = $v[$value];
			}
		}

		return $resultArray;
	}
}

function dd() {
    $arr = func_get_args();
    header("Content-type:text/html;charset=utf-8");
    echo '<pre>';
    foreach ($arr as $v) {
        var_dump($v);
    }
    echo '</pre>';
    exit();
}

/*
获取访问IP
*/
function getIP(){
    global $ip;
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    return $ip;
}


/**
 * 获取完整URL
 */
function getAllUrl() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}

/*
* @param string $opr_name $type 操作类型:1:增,2:删,3:改,4:查
* @param $data
* 写入接口日志
*/
function addApiLog($opr_name = "API操作", $type) {
    $data = array();
    $data['opr_name'] = $opr_name;
    $data['username'] = session('username');
    $data['ip'] = getIP();
    $data['time'] = time();
    $sql = M()->getLastSql();

    $data['sql'] = addslashes($sql);
    $data['url'] = getAllUrl();

    M('log_system')->add($data);

}

function sql($var=''){
    $sql = M()->getLastSql();
    if($var){
        dd($var,$sql);
    }else{
        dd($sql);
    }
}

/*
 * @author 曹梦瑶
 * 用户密码加密规则  sha1(md5(密码).用户id)
 * @params( md5(密码))
 */
function makePwd($pwd) {
    return sha1($pwd);
}

/*
 * @author 曹梦瑶
 * 验证用户是否登录
 */
function is_login() {
    if ( !$_SESSION['id'] ) {
//        echo 'floatNotify.simple(用户登录失效，请先进行登录);';
//        $this->redirect("Public/index");
        return false;
    } else {
        return true;
    }
}

/**
 * .......
 * @param $url
 * @param array $params
 * @return string
 */
function cp_U($url, $params = []) {
    $url = __APP__ . '/admin.php/' . $url;

    if ($params) {
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

/**
 * 格式化金额
 * @param $money
 * @param bool $isShow 是否展示
 * @return float
 */
function formatMoney($money, $isShow = false) {
    if ($isShow) {
        return round($money/100, 2);
    } else {
        return $money * 100;
    }

}



