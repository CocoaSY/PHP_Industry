<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/1/16
 * Time: 13:05
 */

namespace Admin\Controller;


use Admin\Model\AdminModel;
use Think\Controller;

class AdminController extends BaseController{

    public function index(){
        $adminModel = new AdminModel();
        $admins = $adminModel->getAllAdmins();

        $this->assign("admins",$admins);
        $this->display();
    }

    public function add(){

        $adminM = new AdminModel();

        if($_POST['sub']){
            $data['ad_name'] = I("ad_name");
            $password = I("ad_password");
            $data['regtime'] = time();
            $data['ad_password'] = $adminM->encodepass($data['regtime'],$password);
            $data['regtime'] = time();
            //dump($data);die;
            $rs = $adminM->create($data);
            //dump($rs);die;
            if($rs){
                if($adminM->add($data)){

                    $this->success("管理员账户添加成功!",U("index"));
                }else{
                    $this->error("管理员账户添加失败!");
                }
            }else{
                $this->error($adminM->getError());
            }
            return ;
        }

        $this->display();
    }

    public function edit(){
        $adminM = new AdminModel();

        if($_POST['sub']){
            $data['ad_id']          = I("ad_id");
            $data['ad_name']        = I("ad_name");
            $admin = $adminM->where(array("ad_id"=>$data['ad_id']))->find();
            $regtime = $admin['regtime'];
            $data['ad_password']    = $adminM->encodepass($regtime,I("ad_password"));
            if($adminM->create($data)){
                $rs = $adminM->where("ad_id=".$data['ad_id'])->save($data);
                if($rs){
                    $this->success("管理员账户编辑成功!",U("index"));
                }else{
                    $this->error("管理员账户编辑失败!");
                }
            }else{
                $this->error($adminM->getError());
            }


            return ;
        }

        if($_GET['ad_id']){
            $ad_id = I("ad_id");
            $aAdmin = $adminM->find($ad_id);
            $this->assign("aAdmin",$aAdmin);
        }

        $this->display();
    }


    public function deleteAdmin($ad_id){
        $admin = D("Admin");
        $ad_id = I("ad_id");
        $rs = $admin->where("ad_id=".$ad_id)->delete();
        if($rs){
            $this->success("管理员账户删除成功!",U("index"));
        }else{
            $this->error("管理员账户删除失败!");
        }

    }

    public function deleteAdminM(){

    }


}