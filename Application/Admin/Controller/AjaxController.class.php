<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/16/16
 * Time: 15:26
 */

namespace Admin\Controller;


use Admin\Model\ArticleModel;
use Think\Controller;

class AjaxController extends Controller{

    public function __construct(){
        if(!IS_AJAX) return ;
    }

    //获取栏目下所有文章
    public function articlesFromCategory(){
        $article = new ArticleModel();

        $cid = I("cid");
        $aArticles = $article
                    ->field(array("ar_id","ar_title"))
                    ->where(array("ar_cateid"=>$cid))
                    ->select();
        $this->ajaxReturn($aArticles);
    }

    //修改首页配置
    public function chgIndexConf(){
        $key = I("key");
        $conf = C($key);
        $newConf['name'] = $conf['name'];
        $newConf['cid'] = I("cid");
        $newConf['aid'] = I("aid");
        update_config_index($key,$newConf);

    }

    //修改积分配置
    public function chgIntegralConf(){
        $key = I("key");
        $nintegral = I("value");
        update_config_integral($key,$nintegral);

    }

}