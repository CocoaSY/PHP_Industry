<?php
namespace Admin\Controller;
use Admin\Model\ArticleModel;
use Admin\Model\CategoryModel;
use Think\Controller;
use Think\Upload;

class CategoryController extends BaseController {



    public function index(){

        $cate = D("Category");
        $cateType = D("CategoryType");

        $catetree = $cate->getCates_tree();
        $this->assign('cates',$catetree);

        $cate_pids = $cate->getCateNames_tree();
        $this->assign("cate_pids",$cate_pids);

        $cateTypes = $cateType->select();
        $this->assign("catetypes",$cateTypes);

        $this->display();
    }

    public function add(){

        $cate = D("Category");
        $cateType = D("CategoryType");

        if($_POST['sub']){

            //dump($_FILES);die;

            $data['cate_name']      = I("cate_name");       //栏目名称
            $data['cate_ename']     = I("cate_ename");      //栏目名称(英文)
            $data['cate_type']      = I("cate_type");       //栏目类型
            $data['cate_keywords']  = I("cate_keywords");   //关键字
            $data['cate_desc']      = I("cate_desc");       //栏目描述
            $data['cate_nav']       = I("cate_nav")=="on"?1:0;       //栏目作为导航
            $data['cate_pid']       = I("cate_pid");        //上级栏目
            $data['cate_content']   = I("cate_content");   //栏目内容

            //图片上传
            if($_FILES['cate_pic']['tmp_name']!=''){
                //图片上传
                $upConfig = C("cateImg");
                $upload = new Upload($upConfig);
                //上传单个文件
                $info = $upload->uploadOne($_FILES['cate_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['cate_pic'] = $pic_path;    //缩略图地址
                }
            }

            if($cate->create($data)){
                $rs = $cate->add($data);
                if($rs){
                    $this->success("栏目新增成功",U('index'));
                }else{
                    $this->error("栏目新增失败");
                }
            }else{
                $this->error($cate->getError());
            }

            return;
        }

        $cate_pids = $cate->getCateNames_tree();
        $this->assign("cate_pids",$cate_pids);
        //dump($cate_pids);

        $cateTypes = $cateType->select();
        $this->assign("catetypes",$cateTypes);

        $this->display();
    }

    public function edit($cate_id){

        $cate = D("Category");
        $cateType = D("CategoryType");

        if($_POST['sub']){
            $data['cate_id']        = I("cate_id");         //栏目ID
            $data['cate_name']      = I("cate_name");       //栏目名称
            $data['cate_ename']     = I("cate_ename");      //栏目名称(英文)
            $data['cate_type']      = I("cate_type");       //栏目类型
            $data['cate_keywords']  = I("cate_keywords");   //关键字
            $data['cate_desc']      = I("cate_desc");       //栏目描述
            $data['cate_nav']       = I("cate_nav")=="on"?1:0;       //栏目作为导航
            $data['cate_pid']       = I("cate_pid");        //上级栏目
            $data['cate_content']    = I("cate_content");   //栏目内容

            //图片上传
            if($_FILES['cate_pic']['tmp_name']!=''){
                //echo $_FILES['cate_pic']['tmp_name'];die;
                //图片上传
                //图片上传
                $upConfig = C("cateImg");
                $upload = new Upload($upConfig);

                //上传单个文件
                $info = $upload->uploadOne($_FILES['cate_pic']);
                if(!$info){
                    $this->error($upload->getError());
                }else{
                    $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                    $data['cate_pic'] = $pic_path;    //缩略图地址
                }
            }

            //dump($data);die;
            if($cate->create($data)){
                $rs = $cate->where("cate_id=".$data['cate_id'])->save($data);
                if($rs){
                    $this->success("栏目修改成功",U('index'));
                }else{
                    $this->error("栏目修改失败");
                }
            }else{
                $this->error($cate->getError());
            }

            return;
        }

        if($_GET['cate_id']){
            $aCate = $cate->find($cate_id);
            $this->assign("aCate",$aCate);
        }




        $cate_pids = $cate->getCateNames_tree();
        $this->assign("cate_pids",$cate_pids);
        //dump($cate_pids);

        $cateTypes = $cateType->select();
        $this->assign("catetypes",$cateTypes);


        $this->display();

    }

    public function deleteCate($cate_id){
        $cate = D("Category");
        $rs = $cate->deleteCate($cate_id);
        if($rs){
            $this->success("栏目删除成功",U("index"));
        }else{
            $this->error("栏目删除失败",U("index"));
        }
    }

    public function deleteCateM(){

        $cate = D("Category");

        if($_POST['sub']){
            $dels = I('dels');

            if(!empty($dels)){
                $rs = $cate->deleteCateM($dels);
                if($rs){
                    $this->success("批量删除成功",U("index"));
                }else{
                    $this->error("批量删除失败",U("index"));
                }
            }else{
                $this->error("未选择删除栏目",U("index"));
            }

        }

    }

    /** 异步请求 */
    public function chgID(){
        $cateM = new CategoryModel();
        $artiM = new ArticleModel();

        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");

            $cateM->chgCatepid($oldid,$newid);
            $artiM->chgArCateid($oldid,$newid);

            $rs = $cateM->where(array("cate_id"=>$oldid))->setField("cate_id",$newid);

            if($rs){
                $aConf = $cateM->where(array("cf_id"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $aConf;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }
    }

    public function addCategory(){
        $cate = new CategoryModel();
        $cateType = D("CategoryType");

        if(IS_AJAX){

            $data['cate_name']      = I("cate_name");           //栏目名称
            $data['cate_ename']     = I("cate_ename");          //栏目名称(英文)
            $data['cate_type']      = I("cate_type");           //栏目类型
            $data['cate_keywords']  = I("cate_keywords");       //关键字
            $data['cate_desc']      = I("cate_desc");           //栏目描述
            $data['cate_nav']       = I("cate_nav")=="on"?1:0;       //栏目作为导航
            $data['cate_pid']       = I("cate_pid");            //上级栏目
            $data['cate_content']   = I("cate_content");        //栏目内容

            //图片上传
            $upConfig = C("cateImg");
            $upload = new Upload($upConfig);
            //上传单个文件
            $info = $upload->uploadOne($_FILES['cate_pic']);
            if(!$info){
                $this->error($upload->getError());
            }else{
                $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                $data['cate_pic'] = $pic_path;    //缩略图地址
            }

            if($cate->create($data)){
                $rs = $cate->add($data);
                if($rs){
                    $category = $cate->where(array("cate_id"=>$rs))->find();
                    $res['rs'] = 1;
                    $res['msg'] = "栏目新增成功";
                    $res['info'] = $category;

                }else{
                    $res['rs'] = 0;
                    $res['msg'] = "栏目新增失败";
                    $res['info'] = 0;

                }
            }else{
                $res['rs'] = 0;
                $res['msg'] = "上传数据有冲突";
                $res['info'] = $cate->getError();
            }
            $this->ajaxReturn($res);
        }
    }

    public function getCategory(){
        $categoryM = new CategoryModel();
        $cid = I("cid");
        $category = $categoryM->where(array("cate_id"=>$cid))->find();
        $this->ajaxReturn($category);
    }

    public function updateCategory(){
        $cate = new CategoryModel();
        $cateType = D("CategoryType");

        if(IS_AJAX){
            $data['cate_id']        = I("cate_id");         //栏目ID
            $data['cate_name']      = I("cate_name");       //栏目名称
            $data['cate_ename']     = I("cate_ename");      //栏目名称(英文)
            $data['cate_type']      = I("cate_type");       //栏目类型
            $data['cate_keywords']  = I("cate_keywords");   //关键字
            $data['cate_desc']      = I("cate_desc");       //栏目描述
            $data['cate_nav']       = I("cate_nav")=="on"?1:0;       //栏目作为导航
            $data['cate_pid']       = I("cate_pid");        //上级栏目
            $data['cate_content']    = I("cate_content");   //栏目内容

            //图片上传
            $upConfig = C("cateImg");
            $upload = new Upload($upConfig);

            //上传单个文件
            $info = $upload->uploadOne($_FILES['cate_pic']);
            if($info){
                // 删除原始图片
                $categoryInfo = $cate->where(array('cate_id'=>$data['cate_id']))->find();
                $delfile_o = ".".substr($categoryInfo['cate_pic'],strlen(__ROOT__));
                unlink($delfile_o);

                //添加新图片
                $pic_path = __ROOT__.substr($info['savepath'].$info['savename'],1);
                $data['cate_pic'] = $pic_path;    //缩略图地址
            }

            if($cate->create($data)){
                $rs = $cate->where("cate_id=".$data['cate_id'])->save($data);
                if($rs){
                    $category = $cate->where(array("cate_id"=>$rs))->find();
                    $res['rs'] = 1;
                    $res['msg'] = "栏目修改成功";
                    $res['info'] = $category;

                }else{
                    $res['rs'] = 1;
                    $res['msg'] = "栏目修改失败";
                    $res['info'] = 0;
                }
            }else{
                $res['rs'] = 1;
                $res['msg'] = "栏目修改数据冲突";
                $res['info'] = 0;
            }
            $this->ajaxReturn($res);
        }
    }

    public function delCategory(){
        $categoryM = new CategoryModel();

        if($_POST){
            $cid = I("cid");

            // 删除原始图片
            $categoryInfo = $categoryM->where(array('cate_id'=>$cid))->find();
            $delfile_o = ".".substr($categoryInfo['cate_pic'],strlen(__ROOT__));
            unlink($delfile_o);

            $rs = $categoryM->where(array('cate_id'=>$cid))->delete();
            if($rs){
                $res['rs'] = 1;
                $res['msg'] = "删除成功";
                $res['info'] = 1;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "删除失败";
                $res['info'] = 0;
            }
            $this->ajaxReturn($res);
        }
    }

}