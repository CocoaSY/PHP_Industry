<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 15:21
 */

namespace Mobile\Model\Location;


use Think\Model;

class LocationCityModel extends Model{

    public function citys($pid){
        return $this->where(array("pid"=>$pid))->select();
    }

}