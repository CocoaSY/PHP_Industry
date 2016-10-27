<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 15:22
 */

namespace Mobile\Model\Location;


use Think\Model;

class LocationDistrictModel extends Model{

    public function districts($cid){
        return $this->where(array("cid"=>$cid))->select();
    }

}