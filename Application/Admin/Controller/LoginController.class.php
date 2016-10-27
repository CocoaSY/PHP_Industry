<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/1/16
 * Time: 19:52
 */

namespace Admin\Controller;


use Admin\Model\AdminModel;
use Think\Controller;

class LoginController extends Controller{

    public function index(){

        $this->display();
    }

    public function login(){

        $adminM = new AdminModel();

        if($_POST["ad_name"] && $_POST["ad_password"]){
            $ad_name = I("ad_name");
            $ad_password = I("ad_password");

            $aAdmin = $adminM->where(array("ad_name"=>$ad_name))->find();
            if($aAdmin){
                if($adminM->checkPass($aAdmin['ad_id'],$ad_password)){
                    $this->success("用户登录成功",U("Index/index"));
                    session("admin_id",$aAdmin['ad_id']);
                    session("admin_name",$aAdmin['ad_name']);

                }else{
                    $this->error("用户登录失败",U("Login/index"));
                }
            }else{
                $this->error("用户名不存在",U("Login/index"));
            }

        }else{
            $this->error("请输入用户名和密码",U("Login/index"));
        }
    }


    public function logout(){
        session(null);
        $this->success("退出登录成功",U("Login/index"));
    }
}