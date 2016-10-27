<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/20/16
 * Time: 14:51
 */

namespace Mobile\Controller;


use Mobile\Model\ArticleModel;
use Think\Controller;

class ArticleController extends Controller{

    public function articles(){
        $articleM = new ArticleModel();

        if($_GET){
            $cate_id = I("cate_id");
            if($cate_id == 0){
                $res = $articleM->select();
            }else{
                $res = $articleM->where(array("ar_cateid"=>$cate_id))->select();
            }
            $this->ajaxReturn($res);
        }
    }

}