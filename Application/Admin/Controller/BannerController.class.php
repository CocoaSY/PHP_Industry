<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/6/16
 * Time: 13:44
 */

namespace Admin\Controller;


use Admin\Model\BannerModel;
use Think\Upload;

class BannerController extends BaseController{

    public function index(){

        $banner = D("Banner");
        $banners = $banner->select();

        $this->assign("banners",$banners);
        $this->display();
    }

    public function add(){

        $banner = D("Banner");

        if($_POST['sub']){

            $data['bn_name']    = I("bn_name");             //横幅中文名称
            $data['bn_ename']   = I("bn_ename");            //横幅英文名称
            $data['bn_desc']    = I("bn_desc");             //横幅描述
            $data['bn_show']    = I("bn_show")=="on"?1:0;   //是否显示该横幅

            //图片上传
            if($_FILES['bn_pic']['tmp_name']!=''){
                //图片上传
                $upload = new Upload(C("bannerImg"));

                //上传单个文件
                $info = $upload->uploadOne($_FILES['bn_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['bn_pic'] = $pic_path;    //缩略图地址
                }
            }

            //dump($data);die;

            if($banner->create($data)){
                $rs = $banner->add($data);
                if($rs){
                    $this->success("横幅新增成功",U('index'));
                }else{
                    $this->error("横幅新增失败");
                }
            }else{
                $this->error($banner->getError());
            }

            return;
        }


        $this->display();
    }

    public function edit(){

        $banner = D("Banner");

        if($_POST['sub']){

            $data['bn_id']      = I("bn_id");               //横幅ID
            $data['bn_name']    = I("bn_name");             //横幅中文名称
            $data['bn_ename']   = I("bn_ename");            //横幅英文名称
            $data['bn_desc']    = I("bn_desc");             //横幅描述
            $data['bn_show']    = I("bn_show")=="on"?1:0;   //是否显示该横幅

            //图片上传
            if($_FILES['bn_pic']['tmp_name']!=''){
                //图片上传
                $upload = new Upload(C("bannerImg"));

                //上传单个文件
                $info = $upload->uploadOne($_FILES['bn_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['bn_pic'] = $pic_path;    //缩略图地址
                }
            }

            //dump($data);die;

            if($banner->create($data)){
                $rs = $banner->where("bn_id=".$data['bn_id'])->save($data);
                if($rs){
                    $this->success("横幅修改成功",U('index'));
                }else{
                    $this->error("横幅修改失败");
                }
            }else{
                $this->error($banner->getError());
            }



            return;
        }

        if($_GET['bn_id']){

            $bn_id = I("bn_id");
            $aBanner = $banner->where("bn_id=".$bn_id)->find();

            $this->assign("aBanner",$aBanner);
            $this->display();
        }

    }

    public function deleteBanner(){
        $banner = D("Banner");
        if($_GET['bn_id']){

            $bn_id = I("bn_id");
            $rs = $banner->where("bn_id=".$bn_id)->delete();
            if($rs){
                $this->success("横幅删除成功",U("index"));
            }else{
                $this->error("横幅删除失败",U("index"));
            }

        }
    }

    public function deleteBannerM(){

        $banner = D("Banner");

        if($_POST['sub']){
            $dels = I('dels');

            if(!empty($dels)){
                $rs = $banner->deleteCateM($dels);
                if($rs){
                    $this->success("批量删除成功",U("index"));
                }else{
                    $this->error("批量删除失败",U("index"));
                }
            }else{
                $this->error("未选择删除横幅",U("index"));
            }

        }
    }




    /** 异步数据处理 */
    public function addBanner(){
        $banner = new BannerModel();

        if(IS_AJAX){
            $data['bn_name']    = I("bn_name");             //横幅中文名称
            $data['bn_ename']   = I("bn_ename");            //横幅英文名称
            $data['bn_desc']    = I("bn_desc");             //横幅描述
            $data['bn_show']    = I("bn_show")=="on"?1:0;   //是否显示该横幅

            //图片上传
            $upload = new Upload(C("bannerImg"));
            //上传单个文件
            $info = $upload->upload();
            if($info){
                $pic_path = __ROOT__.substr($info['pic']['savepath'].$info['pic']['savename'],1);
                $data['bn_pic'] = $pic_path;    //缩略图地址
            }

            $rs = $banner->add($data);
            if($rs){
                $aBanner = $banner->where(array("bn_id"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "横幅新增成功";
                $res['info'] = $aBanner;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "横幅新增失败";
                $res['info'] = 0;

            }
            $this->ajaxReturn($res);

        }
    }

    public function getBanner(){
        $bannerM = new BannerModel();
        $bid = I("bid");
        $banner = $bannerM->where(array("bn_id"=>$bid))->find();
        $this->ajaxReturn($banner);
    }

    public function updateBanner(){
        $bannerM = new BannerModel();

        if(IS_AJAX){
            $data['bn_id']      = I("bn_id");
            $data['bn_name']    = I("bn_name");             //横幅中文名称
            $data['bn_ename']   = I("bn_ename");            //横幅英文名称
            $data['bn_desc']    = I("bn_desc");             //横幅描述
            $data['bn_show']    = I("bn_show")=="on"?1:0;   //是否显示该横幅

            //图片上传
            $upload = new Upload(C("bannerImg"));
            //上传单个文件
            $info = $upload->upload();
            if($info){

                // 删除原始图片
                $bannerInfo = $bannerM->where(array('bn_id'=>$data['bn_id']))->find();
                $delfile_o = ".".substr($bannerInfo['bn_pic'],strlen(__ROOT__));
                unlink($delfile_o);

                $pic_path = __ROOT__.substr($info['pic']['savepath'].$info['pic']['savename'],1);
                $data['bn_pic'] = $pic_path;    //缩略图地址
            }

            $rs = $bannerM->where(array('bn_id'=>$data['bn_id']))->save($data);
            if($rs){
                $aBanner = $bannerM->where(array("bn_id"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "横幅更新成功";
                $res['info'] = $aBanner;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "横幅更新失败";
                $res['info'] = 0;

            }
            $this->ajaxReturn($res);

        }
    }

    public function delBanner(){
        $bannerM = new BannerModel();

        if($_POST){
            $bid = I("bid");

            // 删除原始图片
            $bannerInfo = $bannerM->where(array('bn_id'=>$bid))->find();
            $delfile_o = ".".substr($bannerInfo['bn_pic'],strlen(__ROOT__));
            unlink($delfile_o);

            $rs = $bannerM->where(array('bn_id'=>$bid))->delete();
            if($rs){
                $res['rs'] = 1;
                $res['msg'] = "删除成功";
                $res['info'] = 1;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "删除失败";
                $res['info'] = 0;
            }
            $this->ajaxReturn($res);
        }
    }

    public function chgBannerID(){
        $bannerM = new BannerModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $bannerM->where(array("bn_id"=>$oldid))->setField("bn_id",$newid);

            if($rs){
                $banner = $bannerM->where(array("bn_id"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $banner;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }

    }


}