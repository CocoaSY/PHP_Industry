<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/9/16
 * Time: 13:07
 */

namespace Mobile\Controller;


use Mobile\Model\BannerModel;
use Think\Controller;

class BannerController extends Controller{

    public function index(){
        $this->banners();
    }

    public function banners(){
        $banner = new BannerModel();
        $banners = $banner->banners();
        //dump($banners);
        $this->ajaxReturn($banners);
    }
}