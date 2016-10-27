<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/4/16
 * Time: 15:39
 */

namespace Home\Controller;

use Home\Model\ArticleModel;
use Home\Model\CategoryModel;

class ProductController extends BaseController{
    public function index(){
        $cate = new CategoryModel();
        $article = new ArticleModel();

        if($_GET['cate_id']){
            $cate_id = I("cate_id");
            $cCate = $cate->where("cate_id=".$cate_id)->find();
            $cCate['cate_content'] = htmlspecialchars_decode($cCate['cate_content']);
            $articles = $article->where("ar_cateid=".$cate_id)->select();
            //dump($cCate);dump($articles);die;

            $this->assign("cCate",$cCate);
            $this->assign("articles",$articles);
            $this->display();
        }
    }
}