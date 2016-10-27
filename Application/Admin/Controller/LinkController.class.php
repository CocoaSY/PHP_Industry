<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 13:18
 */

namespace Admin\Controller;


use Think\Controller;
use Think\Upload;

class LinkController extends BaseController{

    public function index(){

        $link = D("Link");
        $links = $link->select();
        $this->assign("links",$links);
        $this->display();
    }

    public function add(){

        $link = D("Link");

        if($_POST['sub']){


            $data['li_title']   = I("li_title");    //超链接标题
            $data['li_url']     = I("li_url");      //超链接地址
            $data['li_show']    = I("li_show");     //是否显示超链接
            $data['li_desc']    = I("li_desc");     //超链接描述

            //图片上传
            if($_FILES['li_pic']['tmp_name']!=''){
                //图片上传
                $upload = new Upload();
                $upload->maxSize = 3145728;
                $upload->exts = array('jpg','png','gif','jpeg');
                $upload->rootPath = "./";
                $upload->savePath = "./Public/Uploads";

                //上传单个文件
                $info = $upload->uploadOne($_FILES['li_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['li_pic'] = $pic_path;    //缩略图地址
                }
            }

            if($link->create($data)){
                $rs = $link->add($data);
                if($rs){
                    $this->success("超链接新增成功",U('index'));
                }else{
                    $this->error("超链接新增失败");
                }
            }else{
                $this->error($link->getError());
            }
            return ;
        }

        $this->display();
    }

    public function edit($li_id){
        $link = D("Link");

        if($_POST["sub"]){

            $data['li_id']      = I("li_id");       //超链接ID
            $data['li_title']   = I("li_title");    //超链接标题
            $data['li_url']     = I("li_url");      //超链接地址
            $data['li_show']    = I("li_show");     //是否显示超链接
            $data['li_desc']    = I("li_desc");     //超链接描述

            //图片上传
            if($_FILES['li_pic']['tmp_name']!=''){
                //图片上传
                $upload = new Upload();
                $upload->maxSize = 3145728;
                $upload->exts = array('jpg','png','gif','jpeg');
                $upload->rootPath = "./";
                $upload->savePath = "./Public/Uploads";

                //上传单个文件
                $info = $upload->uploadOne($_FILES['li_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['li_pic'] = $pic_path;    //缩略图地址
                }
            }

            if($link->create($data)){
                $rs = $link->where("li_id=".$data['li_id'])->save();
                if($rs){
                    $this->success("超链接保存成功",U('index'));
                }else{
                    $this->error("超链接保存失败");
                }
            }else{
                $this->error($link->getError());
            }
            return ;
        }

        if($_GET["li_id"]){
            $lin = $link->where("li_id=".$_GET["li_id"])->find();
            $this->assign("link",$lin);
            $this->display();
        }

    }

    public function deleteLink($li_id){
        $link = D("Link");
        if($_GET["li_id"]){
            $rs = $link->deleteLink(I("li_id"));
            if($rs){
                $this->success("超链接删除成功",U("index"));
            }else{
                $this->error("超链接删除成功",U("index"));
            }
        }
    }

    public function deleteLinkM(){
        $link = D("Link");
        if($_POST["sub"]){
            $li_ids = I("dels");
            if(!empty($li_ids)){
                $rs = $link->deleteLinkM($li_ids);
                if($rs){
                    $this->success("超链接批量删除成功",U("index"));
                }else{
                    $this->error("超链接批量删除成功",U("index"));
                }
            }else{
                $this->error("未选择超链接",U("index"));
            }

        }
    }

}