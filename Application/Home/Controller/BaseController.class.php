<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/29/16
 * Time: 10:50
 */

namespace Home\Controller;

use Home\Model\CategoryModel;
use Home\Model\ConfModel;
use Home\Model\LinkModel;
use Think\Controller;

class BaseController extends Controller{
    public function __construct(){
        parent::__construct();

        $this->nav();           //导航
        $this->conf();          //网站配置
        $this->QuickLinks();    //超链接
        $this->OurContact();    //联系我们
        $this->LatestPosts();   //最新发布
        $this->RecentNews();    //最新新闻
    }

    public function nav(){
        $cate = new CategoryModel();
        //$cates = $cate->join("LEFT JOIN __CATEGORY_TYPE__ ON __CATEGORY__.cate_type=__CATEGORY_TYPE__.catet_id")->select();
        //dump($cates);die;

        $navs = $cate->mainNavs();
        foreach($navs as $key=>$val){
            $subNavs = $cate->subCates($val['cate_id']);
            $navs[$key]['subs'] = $subNavs;
        }
        //dump($navs);die;
        $this->assign("navs",$navs);
    }

    public function conf(){
        $conf = new ConfModel();
        $confs = $conf->getConfs();
        //dump($confsArr);die;

        $this->assign("confs",$confs);
    }



    public function QuickLinks(){
        $link = new LinkModel();
        $links = $link->select();
        $this->assign("qLinks",$links);
    }

    public function OurContact(){

    }

    public function LatestPosts(){

    }

    public function RecentNews(){

    }

}