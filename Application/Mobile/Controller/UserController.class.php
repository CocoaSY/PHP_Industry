<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/11/16
 * Time: 14:38
 *
 * 用户接口
 *
 */

namespace Mobile\Controller;


use Mobile\Model\UserInfoModel;
use Mobile\Model\UserModel;
use Think\Controller;

class UserController extends Controller{

    private $userM;
    private $userInfoM;

    public function __construct(){
        parent::__construct();
        $this->userM        = new UserModel();
        $this->userInfoM    = new UserInfoModel();
    }

    private function checkLogin($userID,$token){

        if(empty($userID)||empty($token)) return false;

        $user = $this->userM->where(array("u_id"=>$userID))->find();
        $userInfo = $this->userInfoM->where(array("uid"=>$userID))->find();

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

    /**
     * 用户注册接口
     */
    public function regis(){

        if(IS_POST){
            $data['username'] = I("username");
            $data['regtime'] = time();
            $data['password'] = encodePass($data['regtime'],I("password"));
            $data['email'] = I("email");

            $return = array();

            if($this->userM->create($data)){           // 用户注册数据验证成功
                $rs = $this->userM->add($data);
                if($rs){            // 用户注册成功

                    $uinfo["uid"] = $rs;
                    $uinfo["email"] = $data['email'];
                    $this->userInfoM->add($uinfo);

                    //$return['rs'] = 1;
                    $return['uid'] = $rs;
                    $return['username'] = $data['username'];

                    $res['rs'] = 1;
                    $res['msg'] = "用户注册成功";
                    $res['info'] = $return;
                }
                else {              // 用户注册失败
                    //$return['rs'] = 0;
                    $res['rs'] = 0;
                    $res['msg'] = "用户注册失败";
                    $res['info'] = 0;
                }


            }else{                              // 用户注册数据验证失败
                //$return['rs'] = "error";
                $res['rs'] = 0;
                $res['msg'] = "用户注册数据验证失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);


        }

    }

    /**
     * 用户登录接口
     */
    public function login(){

        if(IS_POST){

            $username = I("username");
            $password = I("password");

            $return = array();

            $user = $this->userM->where(array("username"=>$username))->find();
            if($user){
                if(checkPass($user['u_id'],$password)){

                    $userinfo = $this->userInfoM->where(array("uid"=>$user['u_id']))->find();
                    $islock = $user['islock'];

                    if($islock!=0){//用户被锁定
                        $return['err'] = "0403";

                        $res['rs'] = 0;
                        $res['msg'] = "用户被锁定";
                        $res['info'] = $return;

                    }else{

                        // 验证token是否过期
                        $token = $userinfo['token'];
                        $outdated = $userinfo['outdated'];

                        $cTime = time();
                        if($cTime<$outdated){
                            $info['token'] = $token;
                            $info['outdated'] = $outdated;
                        }else{      //token过期 登录添加积分 重新计算token和过期时间
                            $info['integral'] = $userinfo['integral'] + C(INTEGRAL_LOGIN);
                            $info['token'] = md5($cTime);
                            $info['outdated'] = $cTime+24*60*60;
                        }

                        $info['logintime'] = $cTime;
                        $info['loginip'] = get_client_ip();

                        $this->userInfoM->where(array("uid"=>$user['u_id']))->save($info); // 保存token和过期时间

                        $returnuser = $this->userInfoM
                                        ->field(array("z_user.u_id as uid","z_user.username","z_user.email","z_user.regtime","z_user_info.nickname","z_user_info.sex","z_user_info.job","z_location_province.name as province","z_location_city.name as city","z_location_district.name as district","z_user_info.intro","z_user_info.face50","z_user_info.face80","z_user_info.face180","z_user_info.integral","z_user_info.token"))
                                        ->join("Right JOIN __USER__              ON __USER_INFO__.uid          = __USER__.u_id")
                                        ->join("LEFT JOIN  __LOCATION_PROVINCE__ ON __USER_INFO__.provinceid   = __LOCATION_PROVINCE__.id")
                                        ->join("LEFT JOIN  __LOCATION_CITY__     ON __USER_INFO__.cityid       = __LOCATION_CITY__.id")
                                        ->join("LEFT JOIN  __LOCATION_DISTRICT__ ON __USER_INFO__.districtid   = __LOCATION_DISTRICT__.id")
                                        ->where(array("uid"=>$user['u_id'],"islock"=>0))
                                        ->find();

                        $return['user'] = $returnuser;
                        $return['token'] = $info['token'];

                        $res['rs'] = 1;
                        $res['msg'] = "登录成功";
                        $res['info'] = $return;

                    }
                }else{
                    //密码不正确
                    $return['err'] = 0401;

                    $res['rs'] = 0;
                    $res['msg'] = "登录失败,密码不正确";
                    $res['info'] = $return;
                }
            }else{
                //用户不存在
                $return['err'] = 0402;

                $res['rs'] = 0;
                $res['msg'] = "用户不存在";
                $res['info'] = $return;
            }
            $this->ajaxReturn($res);
        }


    }

    /**
     * 用户退出登录接口
     */
    public function logout(){
//        $userM = new UserModel();
//        $userinfoM = new UserInfoModel();

        if(IS_POST){
            $return = array();

            $userid = I("uid");
            $token = I("token");

            $return = array();

            $isLogin = $this->checkLogin($userid,$token);

            if($isLogin){
                $user = $this->userM->where(array("u_id"=>$userid))->find();
                $userinfo = $this->userInfoM->where(array("uid"=>$userid))->find();

                $info['outdated'] = time();
                $userinfo = $this->userInfoM->where(array("uid"=>$userid))->save($info);

                //退出登录成功
                $res['rs'] = 1;
                $res['msg'] = "退出登录成功";
                $res['info'] = 0;
            }else{
                //用户未登录
                $return['err'] = "0404";

                $res['rs'] = 0;
                $res['msg'] = "用户还未登录";
                $res['info'] = $return;
            }


            $this->ajaxReturn($res);
        }
    }

    /**
     * 获取用户信息接口
     */
    public function userInfo(){

        $userM = new UserModel();
        $userinfoM = new UserInfoModel();

        if(IS_POST){
            $userid = I("uid");
            $token = I("token");

            $return = array();

            $isLogin = $this->checkLogin($userid,$token);

            if($isLogin){
                $user = $userM->where(array("u_id"=>$userid))->find();
                $islock = $user['islock'];
                if($islock==0){
                    //$userinfo = $userinfoM->where(array("uid"=>$userid))->find();
                    $userinfo = $userM
                                ->table("__USER__ AS user")
                                ->join("LEFT JOIN __USER_INFO__ AS userinfo ON userinfo.uid=user.u_id")
                                ->field(array("user.u_id","user.username","user.email","user.regtime","userinfo.sex","userinfo.job","userinfo.location","userinfo.intro","userinfo.face50","userinfo.face80","userinfo.face180","userinfo.integral","userinfo.logintime","userinfo.loginIP","userinfo.outdated"))
                                ->where(array("u_id"=>$userid))
                                ->find();

                    $res['rs'] = 1;
                    $res['msg'] = "用户信息获取成功";
                    $res['info'] = $userinfo;

                }else{
                    //用户被锁定
                    $return['err'] = "0403";

                    $res['rs'] = 0;
                    $res['msg'] = "用户信息获取失败,用户被锁定";
                    $res['info'] = $return;

                }
            }else{
                //用户未登录
                $return['err'] = "0404";

                $res['rs'] = 0;
                $res['msg'] = "用户信息获取失败,用户还未登录";
                $res['info'] = $return;
            }

            $this->ajaxReturn($res);
        }


    }

    /**
     * 获取用户信息
     */
    public function show(){
        $this->userInfo();
    }

    /**
     * 批量获取用户的粉丝数、关注数、微博数
     */
    public function counts(){

    }


}