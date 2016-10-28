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

    private $topicCateM;
    private $topicM;

    public function __construct(){
        parent::__construct();
        $this->topicCateM   = new TopicCateModel();
        $this->topicM       = new TopicModel();
    }

    public function categorys(){
        $categorys = $this->topicCateM->select();
        if($categorys){
            $res['rs'] = 1;
            $res['msg'] = "话题分类获取成功";
            $res['info'] = $categorys;
        }else{
            $res['rs'] = 1;
            $res['msg'] = "话题分类获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);

    }

    public function topics(){
        if($_GET){
            $cid = I("cid");
            if($cid == 0){
                $topics = $this->topicM->select();
                if($topics){
                    $res['rs'] = 1;
                    $res['msg'] = "话题获取成功";
                    $res['info'] = $topics;
                }else{
                    $res['rs'] = 1;
                    $res['msg'] = "话题获取失败";
                    $res['info'] = 0;
                }
            }else{
                $topics = $this->topicM->where(array("cateid"=>$cid))->select();
                if($topics){
                    $res['rs'] = 1;
                    $res['msg'] = "话题获取成功";
                    $res['info'] = $topics;
                }else{
                    $res['rs'] = 1;
                    $res['msg'] = "话题获取失败";
                    $res['info'] = 0;
                }
            }
            $this->ajaxReturn($res);
        }

    }



}