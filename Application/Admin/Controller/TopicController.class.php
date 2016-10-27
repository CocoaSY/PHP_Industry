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


    /**
     * 异步添加话题
     */
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

}