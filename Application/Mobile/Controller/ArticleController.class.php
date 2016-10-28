<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/20/16
 * Time: 14:51
 */

namespace Mobile\Controller;


use Mobile\Model\ArticleModel;
use Mobile\Model\CategoryModel;
use Think\Controller;

class ArticleController extends Controller{

    private $categoryM;
    private $articleM;

    public function __construct(){
        parent::__construct();
        $this->categoryM = new CategoryModel();
        $this->articleM = new ArticleModel();
    }

    public function articles(){
        if($_GET){
            $cate_id = I("cate_id");
            if($cate_id == 0){
                $articles = $this->articleM->select();
                if($articles){
                    $res['rs'] = 1;
                    $res['msg'] = "文章获取成功";
                    $res['info'] = $articles;
                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "文章获取失败";
                    $res['info'] = 0;
                }
            }else{
                $articles = $this->articleM->where(array("ar_cateid"=>$cate_id))->select();
                if($articles){
                    $res['rs'] = 1;
                    $res['msg'] = "文章获取成功";
                    $res['info'] = $articles;
                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "文章获取失败";
                    $res['info'] = 0;
                }
            }
            $this->ajaxReturn($res);
        }
    }

}