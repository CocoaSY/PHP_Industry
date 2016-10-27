<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/20/16
 * Time: 17:12
 */

namespace Mobile\Controller;

use Mobile\Model\TopicCateModel;
use Mobile\Model\TopicModel;
use Think\Controller;

class TopicController extends Controller{

    public function cates(){
        $topicCateM = new TopicCateModel();
        $topiccates = $topicCateM->select();
        $this->ajaxReturn($topiccates);

    }

    public function topics(){
        $topicM = new TopicModel();
        $topicCateM = new TopicCateModel();

        if($_GET){
            $cid = I("cid");
            if($cid == 0){
                $res = $topicM->select();
            }else{
                $res = $topicM->where(array("cateid"=>$cid))->select();
            }
            $this->ajaxReturn($res);
        }

    }



}