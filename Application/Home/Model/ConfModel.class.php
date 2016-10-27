<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/4/16
 * Time: 20:03
 */

namespace Home\Model;


use Think\Model;

class ConfModel extends Model{

    public function getConfs(){
        $confs = $this->select();
        $confsArr = array();
        foreach($confs as $key=>$value){
            $kName = $value["cf_ename"];
            $confsArr[$kName] = $value;
        }
        return $confsArr;
    }

}