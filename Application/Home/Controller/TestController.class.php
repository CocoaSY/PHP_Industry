<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/6/16
 * Time: 17:37
 */

namespace Home\Controller;


use Home\Model\ArticleModel;
use Home\Model\CategoryModel;

class TestController extends BaseController{
    public function index(){
        $this->service();
        $this->display();
    }

    public function service(){
        $article = new ArticleModel();

        $services = $article
            ->where("ar_cateid=66")
            ->join("LEFT JOIN __CATEGORY__ on __ARTICLE__.ar_cateid=__CATEGORY__.cate_id")
            ->join("LEFT JOIN __ARTICLE_ICON__ on __ARTICLE__.ar_icon=__ARTICLE_ICON__.ari_id")
            ->select();
        //dump($services);

        $this->assign("services",$services);
    }

}