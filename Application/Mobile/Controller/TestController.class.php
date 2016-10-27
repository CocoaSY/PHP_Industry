<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/13/16
 * Time: 14:15
 */

namespace Mobile\Controller;


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

}