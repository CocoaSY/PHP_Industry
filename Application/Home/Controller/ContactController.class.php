<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/6/16
 * Time: 19:53
 */

namespace Home\Controller;


use Home\Model\CategoryModel;
use Home\Model\ContactModel;

class ContactController extends BaseController{
    public function index(){
        $cate = new CategoryModel();
        if($_GET['cate_id']){
            $cate_id = I("cate_id");
            $aCate = $cate->where("cate_id=".$cate_id)->find();
            //dump($aCate);die;

            $aCate['cate_content'] = htmlspecialchars_decode($aCate['cate_content']);
            $this->assign("aCate",$aCate);
            $this->display();
        }
    }

    public function contact(){
        $contact = new ContactModel();
        //dump($_POST);
        if($_POST['sub']){
            //dump($_POST);die;

            $data['ct_username']    = I("username");    //游客名称
            $data['ct_email']       = I("email");       //游客邮箱
            $data['ct_message']     = I("message");     //游客留言信息

            if($contact->create($data)){
                //dump($data);die;
                $rs = $contact->add($data);
                if($rs){
                    //echo __MODULE__;die;
                    $this->success("留言成功",U("Index/index"));
                }else{
                    $this->error("留言失败:".$contact->getError());
                }

            }else{
                $this->error($contact->getError());
            }

        }
    }
}