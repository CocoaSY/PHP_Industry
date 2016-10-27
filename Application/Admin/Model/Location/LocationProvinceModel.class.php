<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 15:19
 */

namespace Admin\Model\Location;

use Think\Model;

class LocationProvinceModel extends Model{

    public function provinces(){
        return $this->select();
    }

}