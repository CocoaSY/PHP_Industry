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

    private $bannerM;

    public function __construct(){
        parent::__construct();
        $this->bannerM = new BannerModel();
    }

    public function banners(){
        $banners = $this->bannerM->getBanners();
        if($banners){
            $res['rs'] = 1;
            $res['msg'] = "横幅获取成功";
            $res['info'] = $banners;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "横幅获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);
    }

}