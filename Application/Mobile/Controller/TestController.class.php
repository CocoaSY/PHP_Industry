<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/13/16
 * Time: 14:15
 */

namespace Mobile\Controller;


use Mobile\Model\FilmCateModel;
use Mobile\Model\FilmModel;
use Mobile\Model\UserInfoModel;
use Think\Controller;

class TestController extends Controller{

    public function testRelation(){

        $userinfoM = new UserInfoModel();
        dump($userinfoM->relation(true)->select());

    }

    public function testJoin(){
        $userinfoM = new UserInfoModel();

        $returnuser = $userinfoM
            ->field(array("z_user.username","z_user_info.nickname","z_location_province.name as pname","z_location_city.name as cname"))
            ->join("Right JOIN __USER__              ON __USER_INFO__.uid          = __USER__.u_id")
            ->join("LEFT JOIN  __LOCATION_PROVINCE__ ON __USER_INFO__.provinceid   = __LOCATION_PROVINCE__.id")
            ->join("LEFT JOIN  __LOCATION_CITY__     ON __USER_INFO__.cityid       = __LOCATION_CITY__.id")
            ->join("LEFT JOIN  __LOCATION_DISTRICT__ ON __USER_INFO__.districtid   = __LOCATION_DISTRICT__.id")
            ->where(array("uid"=>13))
            ->find();
        dump($returnuser);
    }

    public function testJson2(){
        $data['rs'] = 1;
        $data['msg'] = "提示消息";
        $data['info'] = array("aaa","bbb");
        $this->ajaxReturn($data);
    }

    public function testFilmCate(){
        $filmCateM = new FilmCateModel();
        $cates = $filmCateM->field(array("cid","name"))->select();

        if($cates){

                $data['id'] = 1;
                $data['name'] = "类别";
                    $children['data']=$cates;
                $data['children'] = $children;

            $info['data'] = $data;

            $res['rs'] = 1;
            $res['msg'] = "电影分类获取成功";
            $res['info'] = $info;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "电影分类获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);
    }

    public function testFilm(){
        $filmM = new FilmModel();

        $sql = "SELECT a.fid AS 'fid',a.cid AS 'cid',a.name AS 'name',a.ename AS 'ename',a.description AS 'desc',a.pic AS 'pic',a.pic80 AS 'pic80',b.vid AS 'vid',b.type AS 'type',b.size AS 'size',b.path AS 'videoURL' FROM z_film AS a LEFT JOIN z_video AS b ON b.vid=a.video";
        $films = $filmM->query($sql);
        //dump($films);
        $this->ajaxReturn($films);
        /**
         * [{"fid":"1","cid":"1","name":"123","ename":"123","desc":"123","pic":"\/www\/PHP_Industry\/Public\/Uploads\/FilmImage\/20161029\/581467a1aa9e8.jpg","pic80":"\/www\/PHP_Industry\/Public\/Uploads\/FilmImage\/20161029\/581467a1aa9e8X80.jpg","vid":"26","type":"video\/mp4","size":"25122417","videourl":"\/www\/Industry\/Public\/Uploads\/Videos\/20161026\/58103d609f72b.mp4"},{"fid":"2","cid":"3","name":"1234","ename":"1234","desc":"1234","pic":"\/www\/PHP_Industry\/Public\/Uploads\/FilmImage\/20161029\/581467bc81785.jpg","pic80":"\/www\/PHP_Industry\/Public\/Uploads\/FilmImage\/20161029\/581467bc81785X80.jpg","vid":"27","type":"video\/mp4","size":"14646722","videourl":"\/www\/Industry\/Public\/Uploads\/Videos\/20161027\/5810ea28e7a2f.mp4"}]
         */
    }

}