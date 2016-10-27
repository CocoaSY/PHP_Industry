<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/25/16
 * Time: 16:12
 */

namespace Admin\Controller;


use Admin\Model\VideoModel;
use Think\Upload;

class VideoController extends BaseController{

    public function index(){

        $videoM = new VideoModel();
        $videos = $videoM->select();

        $this->assign("videos",$videos);
        $this->display();
    }

    public function addVideo(){

        $videoM = new VideoModel();

        if($_POST){
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $info = I("info");
            if($info){
                $data['path'] = $info['path'];
                $data['type'] = $info['type'];
                $data['size'] = $info['size'];
            }
            $rs = $videoM->add($data);
            if($rs){
                $aVideo = $videoM->where(array("vid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "添加成功";
                $res['info'] = $aVideo;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "添加失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);

        }

    }

    public function video(){
        $videoM = new VideoModel();
        if($_POST){
            $vid = I("vid");
            $video = $videoM->where(array("vid"=>$vid))->find();
            $this->ajaxReturn($video);
        }
    }

    public function updateVideo(){
        $videoM = new VideoModel();
        if($_POST){
            $data['vid'] = I("vid");
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $info = I("info");

            if($info){
                $data['path'] = $info['path'];
                $data['type'] = $info['type'];
                $data['size'] = $info['size'];
                // 删除原始视频
                $videoInfo = $videoM->where(array('vid'=>$data['vid']))->find();
                $delfile_o = ".".substr($videoInfo['path'],strlen(__ROOT__));
                unlink($delfile_o);
            }

            $rs = $videoM->where(array('vid'=>$data['vid']))->save($data);
            if($rs){
                $video = $videoM->where(array("vid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "修改成功";
                $res['info'] = $video;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }



    }

    public function delVideo(){
        $videoM = new VideoModel();

        if($_POST){
            $vid = I("vid");

            // 删除原始视频
            $videoInfo = $videoM->where(array('vid'=>$vid))->find();
            $delfile_o = ".".substr($videoInfo['path'],strlen(__ROOT__));
            unlink($delfile_o);

            $rs = $videoM->where(array("vid"=>$vid))->delete();
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

    public function chgVideoID(){
        $videoM = new VideoModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $videoM->where(array("vid"=>$oldid))->setField("vid",$newid);

            if($rs){
                $video = $videoM->where(array("vid"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $video;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }
    }


    /** 上传文件 */
    public function uploadVideo(){

        //上传视频
        $upConfig = C("upVideo");
        $upload = new Upload($upConfig);
        $info = $upload->upload();
        if($info){
            $file = $info['Filedata']['savename'];
            $ext = ".".$info['Filedata']['ext'];
            $filename = substr($file,0,strlen($file)-strlen($ext));
            $oPath = $info['Filedata']['savepath'].$file;
            $data['path'] = __ROOT__.substr($oPath,1);
            $data['type'] = $info['Filedata']['type'];
            $data['size'] = $info['Filedata']['size'];

            $res['rs'] = 1;
            $res['msg'] = "上传成功";
            $res['info'] = $data;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "上传失败";
            $res['info'] = 0;
        }

        $this->ajaxReturn($res);
    }


}