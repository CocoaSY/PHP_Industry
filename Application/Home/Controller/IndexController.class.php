<?php
namespace Home\Controller;
use Home\Model\ArticleModel;
use Home\Model\BannerModel;
use Home\Model\CategoryModel;
use Home\Model\IndexConfModel;
use Think\Controller;
class IndexController extends BaseController {

    public function index(){

        $this->banners();       //网站横幅
        $this->content();
        $this->display();
    }

    public function banners(){
        $banner = new BannerModel();
        $banners = $banner->banners();
        $this->assign("banners",$banners);
    }

    public function content(){
        $this->company();
        $this->list1();
        $this->list2();
        $this->list3();
    }

    public function company(){

        $category = new CategoryModel();
        $article = new ArticleModel();

        $conf = C("Company");
        //dump($conf);die;
        $c_id = $conf['cid'];
        $a_id = $conf['aid'];

        $aCate = $category->where(array("cate_id"=>$c_id))->find();
        $aArti = $article->where(array("ar_id"=>$a_id))->find();

        $this->assign("aArticle",$aArti);
    }

    public function list1(){
        $category = new CategoryModel();
        $article = new ArticleModel();

        $conf = C("List1");
        //dump($conf);die;
        $c_id = $conf['cid'];
        $a_id = $conf['aid'];

        $aCate = $category->where(array("cate_id"=>$c_id))->find();
        $aArtis = $article
                ->join("LEFT JOIN __ARTICLE_ICON__ ON __ARTICLE__.ar_icon=__ARTICLE_ICON__.ari_id")
                ->where(array("ar_cateid"=>$c_id))
                ->select();
        //dump($aCate);dump($aArtis);die;

        $this->assign("list1_category",$aCate);
        $this->assign("list1_articles",$aArtis);
    }

    public function list2(){
        $category = new CategoryModel();
        $article = new ArticleModel();

        $conf = C("List2");
        $c_id = $conf['cid'];
        $a_id = $conf['aid'];

        $aCategory = $category->where(array("cate_id"=>$c_id))->find();
        $aArticle = $article
                    ->join("RIGHT JOIN __CATEGORY__ on __ARTICLE__.ar_cateid=__CATEGORY__.cate_id")
                    ->where(array("ar_id"=>$a_id))
                    ->find();
        //dump($aArticle);die;

        $aArticle['cate_desc'] = htmlspecialchars_decode($aArticle['cate_desc']);
        $aArticle['ar_desc'] = htmlspecialchars_decode($aArticle['ar_desc']);
        $aArticle['ar_content'] = htmlspecialchars_decode($aArticle['ar_content']);
        //dump($ca);die;

        $this->assign("list2_article",$aArticle);
    }

    public function list3(){
        $category = new CategoryModel();
        $article = new ArticleModel();

        $conf = C("List3");
        $c_id = $conf['cid'];
        $a_id = $conf['aid'];

        $cates = $category->where(array("cate_pid"=>$c_id))->limit(3)->select();
        foreach($cates as $key=>$value){
            $cates[$key]['cate_content'] = htmlspecialchars_decode($cates[$key]['cate_content']);
            $articles = $article->where(array("ar_cateid"=>$value['cate_id']))->order("ar_id ASC")->limit(4)->select();
            foreach($articles as $ak=>$av){
                $articles[$ak]['ar_content'] = htmlspecialchars_decode($articles[$ak]['ar_content']);
            }
            $cates[$key]['articles']=$articles;
        }
        $this->assign("list3_cates",$cates);
    }

    public function categoryShow(){
        $IndexConf = new IndexConfModel();
        $cate = new CategoryModel();
        $article = new ArticleModel();

        $cateShow = $IndexConf
            ->where(array("icf_ename"=>"CategoryShow"))
            ->find();

        $cates = $cate
            ->order("cate_id ASC")
            ->where(array("cate_pid"=>$cateShow['icf_cid']))
            ->limit(3)
            ->select();
        //dump($cates);die;
        foreach($cates as $key=>$value){
            $cates[$key]['cate_content'] = htmlspecialchars_decode($cates[$key]['cate_content']);
            $articles = $article->where(array("ar_cateid"=>$value['cate_id']))->order("ar_id ASC")->limit(4)->select();
            foreach($articles as $ak=>$av){
                $articles[$ak]['ar_content'] = htmlspecialchars_decode($articles[$ak]['ar_content']);
            }
            $cates[$key]['articles']=$articles;
        }
        //dump($cates);die;
        $this->assign("cateshows",$cates);
    }

}