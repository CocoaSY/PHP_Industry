<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/6/16
 * Time: 14:32
 */

namespace Mobile\Model;


use Think\Model;

class BannerModel extends Model{

    public function banners(){
        $banners = $this->where("bn_show=1")->select();
        return $banners;
    }

}