<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/17/16
 * Time: 15:34
 */

namespace Admin\Controller;


use Admin\Model\TopicCateModel;
use Admin\Model\TopicModel;
use Think\Image;
use Think\Upload;

class TopicController extends BaseController{

    private $topicM;
    private $topicCateM;

    public function __construct(){
        parent::__construct();
        $this->topicM = new TopicModel();
        $this->topicCateM = new TopicCateModel();
    }

    public function index(){
        $topicM = new TopicModel();
        $topics = $topicM
                    ->join("LEFT JOIN __USER__ ON __TOPIC__.userid=__USER__.u_id")
                    ->join("LEFT JOIN __TOPIC_CATE__ ON __TOPIC__.cateid=__TOPIC_CATE__.cid")
                    ->select();
        //dump($topics);die;

        $this->assign("topics",$topics);
        $this->display();
    }

    public function category(){
        $topiccateM = new TopicCateModel();
        $tcates = $topiccateM->select();

        $this->assign("tcates",$tcates);
        $this->display();
    }


    /** 异步请求 话题 */
    public function addTopic(){

        $topicM = new TopicModel();

        if(IS_POST){
            $data['userid'] = I("userid");
            $data['title'] = I("topictitle");
            $data['keywords'] = I("topickeywords");
            $data['tags'] = I("topictags");
            $data['content'] = I("topiccontent");
            $data['cateid'] = I("topiccateid");
            $data['attachment'] = I("topicattachment");
            //dump($data);die;

            $rs = $topicM->add($data);
            if($rs){
                $aTopic = $topicM->where(array("tp_id"=>$rs))->find();
                $res['rs']=1;
                $res['msg']="数据插入成功";
                $res['info']=$aTopic;
            }else{
                $res['rs']=0;
                $res['msg']="数据插入失败";
                $res['info']=0;
            }
            $this->ajaxReturn($res);

        }
    }


    /** 异步请求 话题分类*/
    public function addCategory(){

        $topiccateM = new TopicCateModel();
        if(IS_POST){
            $data['name']           = I("name");
            $data['ename']          = I("ename");
            $data['description']    = I("desc");

            $upConfig = C("upTopicCate");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){
                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic100 = $info['pic']['savepath'].$filename."X100".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(100,100)->save($pic100);
                $img->thumb(200,200)->save($pic200);

                $data['pic']    = __ROOT__.substr($oPath,1);
                $data['pic50']  = __ROOT__.substr($pic50,1);
                $data['pic100'] = __ROOT__.substr($pic100,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);
            }

            $rs = $topiccateM->add($data);
            if($rs){
                $cate = $topiccateM->where(array("cid"=>$rs))->find();
                $res['rs']=1;
                $res['msg']="数据插入成功";
                $res['info']=$cate;
            }else{
                $res['rs']=0;
                $res['msg']="数据插入失败";
                $res['info']=0;
            }
            $this->ajaxReturn($res);
        }

    }

    public function getCategory(){
        $cid = I("cid");
        $category = $this->topicCateM->where(array("cid"=>$cid))->find();
        $this->ajaxReturn($category);
    }

    public function updateCategory(){
        if(IS_POST){
            $data['cid']            = I("cid");
            $data['name']           = I("name");
            $data['ename']          = I("ename");
            $data['description']    = I("desc");

            //更改图片
            $upConfig = C("upTopicCate");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){
                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic100 = $info['pic']['savepath'].$filename."X100".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(100,100)->save($pic100);
                $img->thumb(200,200)->save($pic200);

                // 保存新图片
                $data['pic']    = __ROOT__.substr($oPath,1);
                $data['pic50']  = __ROOT__.substr($pic50,1);
                $data['pic100'] = __ROOT__.substr($pic100,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);

                // 删除原始图片
                $topicCate = $this->topicCateM->where(array('cid'=>$data['cid']))->find();
                $delfile_o      = ".".substr($topicCate['pic'],strlen(__ROOT__));
                $delfile_50     = ".".substr($topicCate['pic50'],strlen(__ROOT__));
                $delfile_100    = ".".substr($topicCate['pic100'],strlen(__ROOT__));
                $delfile_200    = ".".substr($topicCate['pic200'],strlen(__ROOT__));
                unlink($delfile_o);
                unlink($delfile_50);
                unlink($delfile_100);
                unlink($delfile_200);
            }

            $rs = $this->topicCateM->where(array("cid"=>$data['cid']))->save($data);
            if($rs){
                $cate = $this->topicCateM->where(array("cid"=>$rs))->find();
                $res['rs']=1;
                $res['msg']="数据更新成功";
                $res['info']=$cate;
            }else{
                $res['rs']=0;
                $res['msg']="数据更新失败";
                $res['info']=0;
            }
            $this->ajaxReturn($res);
        }
    }

    public function delCategory(){
        if($_POST){
            $cid = I("cid");
            $rs = $this->topicCateM->where(array('cid'=>$cid))->delete();
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

}