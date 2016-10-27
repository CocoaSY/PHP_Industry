<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 15:32
 */

namespace Admin\Controller;


use Admin\Model\Location\LocationCityModel;
use Admin\Model\Location\LocationDistrictModel;
use Admin\Model\Location\LocationProvinceModel;

class LocationController extends BaseController{

    public function provinces(){
        $province = new LocationProvinceModel();
        return $province->provinces();
    }

    public function citys(){
        $city = new LocationCityModel();
        if($_POST){
            $pid = I("pid");
            $citys = $city->citys($pid);
            $this->ajaxReturn($citys);
        }
    }

    public function districts(){
        $district = new LocationDistrictModel();
        if($_POST){
            $cid = I("cid");
            $districts = $district->districts($cid);
            $this->ajaxReturn($districts);
        }
    }

}