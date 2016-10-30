<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/27/16
 * Time: 12:14
 */

namespace Mobile\Controller;


use Mobile\Model\FilmCateModel;
use Mobile\Model\FilmModel;

class FilmController extends BaseController{

    private $filmM;
    private $filmCateM;

    public function __construct(){
        parent::__construct();
        $this->filmM        = new FilmModel();
        $this->filmCateM    = new FilmCateModel();
    }

    public function categorys(){
        $cates = $this->filmCateM->field(array("cid","name"))->select();
        if($cates){
            $res['rs'] = 1;
            $res['msg'] = "电影分类获取成功";
            $res['info'] = $cates;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "电影分类获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);



    }

    public function films(){
        if(IS_POST){
            $cid = I("cid");
            if($cid == 0){
                $sql = "SELECT a.fid AS 'fid',a.cid AS 'cid',a.name AS 'name',a.ename AS 'ename',a.description AS 'desc',a.pic AS 'pic',a.pic80 AS 'pic80',b.vid AS 'vid',b.type AS 'type',b.size AS 'size',b.path AS 'videoURL' FROM z_film AS a LEFT JOIN z_video AS b ON b.vid=a.video";
                $films = $this->filmM->query($sql);
                if($films){
                    $res['rs'] = 1;
                    $res['msg'] = "电影获取成功";
                    $res['info'] = $films;
                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "电影获取失败";
                    $res['info'] = 0;
                }
            }else{
                $sql = "SELECT a.fid AS 'fid',a.cid AS 'cid',a.name AS 'name',a.ename AS 'ename',a.description AS 'desc',a.pic AS 'pic',a.pic80 AS 'pic80',b.vid AS 'vid',b.type AS 'type',b.size AS 'size',b.path AS 'videoURL' FROM z_film AS a LEFT JOIN z_video AS b ON b.vid=a.video WHENEVER a.cid=".$cid;
                $films = $this->filmM->query($sql);
                if($films){
                    $res['rs'] = 1;
                    $res['msg'] = "电影获取成功";
                    $res['info'] = $films;
                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "电影获取失败";
                    $res['info'] = 0;
                }
            }
            $this->ajaxReturn($res);
        }
    }




}