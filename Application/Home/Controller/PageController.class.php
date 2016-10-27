<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/4/16
 * Time: 15:49
 */

namespace Home\Controller;


use Home\Model\CategoryModel;

class PageController extends BaseController{
    public function index(){
        $cate = new CategoryModel();
        if($_GET['cate_id']){
            $cate_id = I("cate_id");
            $aCate = $cate->where("cate_id=".$cate_id)->find();
            //dump($aCate);die;

            $aCate['cate_content'] = htmlspecialchars_decode($aCate['cate_content']);
            $this->assign("aCate",$aCate);
            $this->display();
        }
    }
}