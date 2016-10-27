<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/29/16
 * Time: 10:08
 */

function checkLogin($userID,$token){

    $userM = new \Mobile\Model\UserModel();
    $userinfoM = new \Mobile\Model\UserInfoModel();

    if(empty($userID)||empty($token)) return false;

    $user = $userM->where(array("u_id"=>$userID))->find();
    $userInfo = $userinfoM->where(array("uid"=>$userID))->find();

    $cTime = time();
    if($cTime<$userInfo['outdated']){
        if($token==$userInfo['token']){
            //用户已经登录
            return true;
        }else{
            //用户未登录
            return false;
        }
    }else{
        //登录过期
        return false;
    }
}

//用户密码加密
function encodePass($regtime,$originPass){
    $new = $regtime.$originPass;
    return md5($new);
}

//用户密码检测
function checkPass($uid,$pass){
    $userM = new \Mobile\Model\UserModel();
    $where = array("u_id"=>$uid);
    $regtime = $userM->where($where)->getField("regtime");
    $userpass = $userM->where($where)->getField("password");
    if($userpass==encodePass($regtime,$pass)){
        return true;
    }else{
        return false;
    }
}

//修改首页列表配置文件
function update_config_index($key, $value){
    $file = CONF_PATH.'IndexConf.php';
    if(!file_exists($file)) return false;
    $arr = IndexConfig();
    foreach($arr as $k=>$v){
        if($k = $key){
            $arr[$k]=$value;
        }
    }
    //dump($arr);
    file_put_contents($file,"<?php \n function IndexConfig(){ return ".var_export($arr,true)."; }");
}

//修改积分配置文件
function update_config_integral($key, $value){
    $file = CONF_PATH.'IntegralConf.php';
    if(!file_exists($file)) return false;
    $arr = IntegralConfig();
    foreach($arr as $k=>$v){
        if($k = $key){
            $arr[$k] = intval($value);
        }
    }
    //dump($arr);
    file_put_contents($file,"<?php \n function IntegralConfig(){ \n  return ".var_export($arr,true)."; }");
}

