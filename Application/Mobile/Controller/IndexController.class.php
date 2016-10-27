<?php
namespace Mobile\Controller;
use Mobile\Model\ArticleModel;
use Mobile\Model\BannerModel;
use Mobile\Model\CategoryModel;
use Think\Controller;

class IndexController extends Controller{

    public function index(){
        $this->home();
    }

    public function home(){
        $category = new CategoryModel();
        $cates = $category->mainNavs();
        //dump($cates);
        $this->ajaxReturn($cates);

    }

    public function banners(){
        $banner = new BannerModel();
        $banners = $banner->banners();
        //dump($banners);
        $this->ajaxReturn($banners);
    }

    public function category(){
        $category = new CategoryModel();
        $article = new ArticleModel();

        if($_GET['cate_id']){
            $cate_id = I("cate_id");
            $aCategory = $category->where(array("cate_id"=>$cate_id))->find();
            $aCategory['cate_content'] = htmlspecialchars_decode($aCategory['cate_content']);
            $subCates = $category->where(array("cate_pid"=>$cate_id))->select();
            $articles = $article->where(array("ar_cateid"=>$cate_id))->select();
            $aCategory['subs'] = $subCates;
            $aCategory['articles'] = $articles;
            //dump($aCategory);
            $this->ajaxReturn($aCategory);
        }
    }

}