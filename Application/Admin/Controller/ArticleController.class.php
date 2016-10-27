<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 11:13
 */

namespace Admin\Controller;


use Admin\Model\ArticleIconModel;
use Admin\Model\ArticleModel;
use Admin\Model\CategoryModel;
use Admin\Third\myPage;
use Think\Controller;
use Think\Upload;

class ArticleController extends BaseController {

    public function index(){
        $article = D("Article");

        $count = $article->count();
        $page = new myPage($count,10);
        $show = $page->show();
        $list = $article
            ->order("ar_id asc")
            ->join("LEFT JOIN __CATEGORY__ on __ARTICLE__.ar_cateid=__CATEGORY__.cate_id")
            ->join("LEFT JOIN __ARTICLE_ICON__ on __ARTICLE__.ar_icon=__ARTICLE_ICON__.ari_id")
            ->limit($page->firstRow.",".$page->listRows)
            ->select();
        //dump($show);dump($list);die;
        $this->assign("show",$show);
        $this->assign("list",$list);


        $articles = $article->select();
        //dump($articles);die;
        $this->assign("articles",$articles);


        $cate = new CategoryModel();
        $cates = $cate->getCateNames_tree();
        $this->assign("cates",$cates);

        $articleIcon = new ArticleIconModel();
        $arIcons = $articleIcon->select();
        $this->assign("arIcons",$arIcons);

        $this->display();
    }

    public function add(){

        $article = D("Article");

        if($_POST['sub']){
            $data['ar_title']       = I("ar_title");        //文章标题
            $data['ar_author']      = I("ar_author");       //文章作者
            $data['ar_rem']         = I("ar_rem");          //是否推荐
            $data['ar_keywords']    = I("ar_keywords");     //关键词
            $data['ar_desc']        = I("ar_desc");         //文章描述
            $data['ar_cateid']      = I("ar_cateid");       //所属栏目
            $data['ar_content']     = I("ar_content");      //文章内容
            $data['ar_time']        = Date("Y-m-d H:i:s");  //创建时间
            $data['ar_icon']        = I("ar_icon");         //文章图标

            //图片上传
            if($_FILES['ar_pic']['tmp_name']!=''){
                //图片上传
                $upConfig = C("artImg");
                $upload = new Upload($upConfig);

                //上传单个文件
                $info = $upload->uploadOne($_FILES['ar_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['ar_pic'] = $pic_path;    //缩略图地址
                }
            }

            if($article->create($data)){
                $rs = $article->add($data);
                if($rs){
                    $this->success("文章新增成功",U('index'));
                }else{
                    $this->error("文章新增失败");
                }
            }else{
                $this->error($article->getError());
            }

            return ;
        }


        $cate = D("Category");
        $cates = $cate->getCateNames_tree();
        $this->assign("cates",$cates);

        $articleIcon = D("ArticleIcon");
        $arIcons = $articleIcon->select();
        $this->assign("arIcons",$arIcons);

        $this->display();
    }

    public function edit($ar_id){
        $article = D("Article");

        if($_POST["sub"]){

            $data['ar_id']          = I("ar_id");           //文章ID
            $data['ar_title']       = I("ar_title");        //文章标题
            $data['ar_author']      = I("ar_author");       //文章作者
            $data['ar_rem']         = I("ar_rem");          //是否推荐
            $data['ar_keywords']    = I("ar_keywords");     //关键词
            $data['ar_desc']        = I("ar_desc");         //文章描述
            $data['ar_cateid']      = I("ar_cateid");       //所属栏目
            $data['ar_content']     = I("ar_content");      //文章内容
            $data['ar_time']        = Date("Y-m-d H:i:s");  //创建时间
            $data['ar_icon']        = I("ar_icon");         //文章图标

            //图片上传
            if($_FILES['ar_pic']['tmp_name']!=''){
                //图片上传
                $upConfig = C("artImg");
                $upload = new Upload($upConfig);

                //上传单个文件
                $info = $upload->uploadOne($_FILES['ar_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['ar_pic'] = $pic_path;    //缩略图地址
                }
            }

            if($article->create($data)){
                $rs = $article->where("ar_id=".$data['ar_id'])->save($data);
                if($rs){
                    $this->success("文章修改成功",U('index'));
                }else{
                    $this->error("文章修改失败");
                }
            }else{
                $this->error($article->getError());
            }

            return ;
        }

        if($_GET["ar_id"]){
            $art = $article
                ->order("ar_id asc")
                ->join("LEFT JOIN __CATEGORY__ on __ARTICLE__.ar_cateid=__CATEGORY__.cate_id")
                ->join("LEFT JOIN __ARTICLE_ICON__ on __ARTICLE__.ar_icon=__ARTICLE_ICON__.ari_id")
                ->where("ar_id=".$_GET["ar_id"])
                ->find();
            //dump($art);die;
            $this->assign("article",$art);

            $cate = D("Category");
            $cates = $cate->getCateNames_tree();
            $this->assign("cates",$cates);

            $articleIcon = D("ArticleIcon");
            $arIcons = $articleIcon->select();
            $this->assign("arIcons",$arIcons);

            $this->display();
        }

    }

    public function deleteArc($ar_id){
        $article = D("Article");
        if($_GET['ar_id']){
            $rs = $article->deleteArc($ar_id);
            if($rs){
                $this->success("文章删除成功！",U("index"));
            }else{
                $this->error("文章删除失败");
            }
        }
    }

    public function deleteArcM(){
        $article = D("Article");
        if($_POST['sub']){
            $ar_ids = I("dels");
            //dump($ar_ids);
            $rs = $article->deleteArcM($ar_ids);
            if($rs){
                $this->success("文章批量删除成功！",U("index"));
            }else{
                $this->error("文章批量删除失败");
            }
        }
    }

    /** 文章图标管理  */
    public function iconlist(){

        $iconM = new ArticleIconModel();
        $icons = $iconM->select();
        $this->assign("icons",$icons);
        $this->display();
    }

    public function addIcon(){
        $iconM = new ArticleIconModel();

        if(IS_AJAX){
            $data['ari_name'] = I("name");
            $data['ari_ename'] = I("ename");
            $data['ari_cname'] = I("cname");

            $rs = $iconM->add($data);
            if($rs){
                $aIcon = $iconM->where(array("ari_id"=>$rs))->find();
                $res['rs'] = $rs;
                $res['msg'] = "图标插入成功";
                $res['info'] = $aIcon;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "图标插入失败";
                $res['info'] = 0;
            }
            $this->ajaxReturn($res);
        }
    }

    public function chgID(){

    }

    /** 异步请求 文章管理 */
    public function addArticle(){

        $articleM = new ArticleModel();

        if(IS_AJAX){

            $data['ar_title']       = I("ar_title");        //文章标题
            $data['ar_author']      = I("ar_author");       //文章作者
            $data['ar_rem']         = I("ar_rem");          //是否推荐
            $data['ar_keywords']    = I("ar_keywords");     //关键词
            $data['ar_desc']        = I("ar_desc");         //文章描述
            $data['ar_cateid']      = I("ar_cateid");       //所属栏目
            $data['ar_content']     = I("ar_content");      //文章内容
            $data['ar_time']        = Date("Y-m-d H:i:s");  //创建时间
            $data['ar_icon']        = I("ar_icon");         //文章图标

            //图片上传
            $upConfig = C("artImg");
            $upload = new Upload($upConfig);

            //上传单个文件
            $info = $upload->uploadOne($_FILES['ar_pic']);
            if($info){
                $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                $data['ar_pic'] = $pic_path;    //缩略图地址
            }

            if($articleM->create($data)){
                $rs = $articleM->add($data);
                if($rs){

                    $article = $articleM->where(array("ar_id"=>$rs))->find();
                    $res['rs'] = 1;
                    $res['msg'] = "文章新增成功";
                    $res['info'] = $article;

                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "文章新增失败";
                    $res['info'] = 0;

                }
            }else{
                $res['rs'] = 0;
                $res['msg'] = "文章资料有冲突";
                $res['info'] = 0;

            }

            $this->ajaxReturn($res);
        }

    }









}