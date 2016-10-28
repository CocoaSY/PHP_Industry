<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/9/16
 * Time: 13:09
 */

namespace Mobile\Controller;


use Mobile\Model\ArticleModel;
use Mobile\Model\CategoryModel;
use Think\Controller;

class CategoryController extends Controller{

    private $categoryM;
    private $articleM;

    public function __construct(){
        parent::__construct();
        $this->categoryM = new CategoryModel();
        $this->articleM = new ArticleModel();
    }

    //获取所有栏目
    public function categorys(){
        $cates = $this->categoryM->select();
        if($cates){
            $res['rs'] = 1;
            $res['msg'] = "栏目获取成功";
            $res['info'] = $cates;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "栏目获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);
    }

    //获取主页的所有顶级栏目
    public function topCategorys(){
        $cates = $this->categoryM->mainNavs();
        if($cates){
            $res['rs'] = 1;
            $res['msg'] = "栏目获取成功";
            $res['info'] = $cates;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "栏目获取失败";
            $res['info'] = 0;
        }
        $this->ajaxReturn($res);

    }

    //当前栏目下所有文章和子栏目
    public function category(){
        if($_GET['cate_id']){
            $cate_id = I("cate_id");
            $aCategory = $this->categoryM->where(array("cate_id"=>$cate_id))->find();
            if($aCategory){

                $aCategory['cate_content'] = htmlspecialchars_decode($aCategory['cate_content']);
                $subCates = $this->categoryM->where(array("cate_pid"=>$cate_id))->select();
                $articles = $this->articleM->where(array("ar_cateid"=>$cate_id))->select();
                $aCategory['subs'] = $subCates;
                $aCategory['articles'] = $articles;

                $res['rs'] = 1;
                $res['msg'] = "获取成功";
                $res['info'] = $aCategory;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "获取失败";
                $res['info'] = 0;
            }


            $this->ajaxReturn($res);
        }
    }

}