<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/1/16
 * Time: 21:54
 */

namespace Admin\Controller;


use Think\Controller;

class BaseController extends Controller{

    public function __construct(){
        parent::__construct();
        $this->checkLogin();
    }

    public function checkLogin(){
        $admin = D("Admin");

        if (!isset($_POST['SESSION_ID'])) {

            $admin_ids = $admin->getField("ad_id",true);
            //dump($admin_ids);die;
            $admin_id = session("admin_id");
            if(!$admin_id){

                $this->error("当前用户未登录!",U("Login/index"));

                $is_admin = in_array($admin_id,$admin_ids);
                if(!$is_admin){
                    $this->error("不是后台管理员!",U("Login/index"));
                }

            }else{
                $aAdmin = $admin->where(array("ad_id"=>$admin_id))->find();
                $this->assign("aAdmin",$aAdmin);
            }

        } else {
            session_id($_POST['SESSION_ID']);
            session_start();
        }


    }

    protected function ajaxReturn($data) {
        echo json_encode($data);
        exit;
    }

}

