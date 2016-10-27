<?php
namespace Admin\Controller;
use Think\Controller;

class IndexController extends BaseController {
    public function index(){
        $this->display();
    }

    public function content(){
        $this->display();
    }

    public function left(){
        $this->display();
    }

    public function right(){
        $contact = D("Contact");
        $messages = $contact->select();
        //dump($messages);die;

        $this->assign("messages",$messages);
        $this->display();
    }

    public function conf(){
        $cate = D("Category");
        $article = D("Article");

        $confs['Company']   = C("Company");
        $confs['List1']     = C("List1");
        $confs['List2']     = C("List2");
        $confs['List3']     = C("List3");

        foreach($confs as $key=>$value){
            $category = $cate->where(array("cate_id"=>$value['cid']))->find();
            $confs[$key]['Category'] = $category;
            if($value['aid']==0){
                $aArticles = $article->where(array("ar_cateid"=>$value['cid']))->select();
                $confs[$key]['article'] = $aArticles;
            }else{
                $aArticle = $article->where(array("ar_id"=>$value['aid']))->select();
                $confs[$key]['article'] = $aArticle;
            }
        }

        //dump($confs);die;

        $cates = $cate->select();
        $articles = $article->select();
        //$confs = $indexConf->select();

        $this->assign("confs",$confs);
        $this->assign("cates",$cates);
        $this->assign("articles",$articles);
        $this->display();
    }



}