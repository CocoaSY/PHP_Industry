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
                    ->join("LEFT JOIN __TOPIC_CATE__ ON __TOPIC__.cateid=__TOPIC_CATE__.t_id")
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
            $data['name'] = I("tcatename");
            $data['ename'] = I("tcateename");
            $rs = $topiccateM->add($data);
            if($rs){
                $cate = $topiccateM->where(array("t_id"=>$rs))->find();
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
        $category = $this->topicCateM->where(array("t_id"=>$cid))->find();
        $this->ajaxReturn($category);
    }

    public function updateCategory(){
        if(IS_POST){
            $data['t_id'] = I("cid");
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $rs = $this->topicCateM->where(array("t_id"=>$data['t_id']))->save($data);
            if($rs){
                $cate = $this->topicCateM->where(array("t_id"=>$rs))->find();
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

            $rs = $this->topicCateM->where(array('t_id'=>$cid))->delete();
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