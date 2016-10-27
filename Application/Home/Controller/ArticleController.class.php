<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/4/16
 * Time: 15:45
 */

namespace Home\Controller;


use Home\Model\ArticleModel;

class ArticleController extends BaseController{
    public function index(){
        $article = new ArticleModel();
        if($_GET['ar_id']){
            $ar_id = I("ar_id");
            $aArticle = $article->where("ar_id=".$ar_id)->find();
            $aArticle['ar_content'] = htmlspecialchars_decode($aArticle['ar_content']);
            //dump($aArticle);die;

            $this->assign("aArticle",$aArticle);
            $this->display();
        }
    }
}