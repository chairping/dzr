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
 * 用户密码加密规则  md5(md5(密码).用户id)
 * @params(用户id , md5(密码))
 */
function makePwd($user_id, $pwd) {
    return md5($pwd.$user_id);
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




