<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/23/16
 * Time: 13:50
 */

namespace Admin\Controller;


use Admin\Model\FilmCateModel;
use Admin\Model\FilmModel;
use Admin\Model\VideoModel;
use Think\Image;
use Think\Upload;

class FilmController extends BaseController{

    public function index(){

        $videoM = new VideoModel();
        $filmCateM = new FilmCateModel();
        $filmM = new FilmModel();

        $videos = $videoM->select();
        $cates = $filmCateM->select();
        $films = $filmM->select();

        $this->assign("cates",$cates);
        $this->assign("videos",$videos);
        $this->assign("films",$films);
        $this->display();
    }

    public function addFilm(){

        $filmM = new FilmModel();

        if($_POST){
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $data['cid'] = I("type");
            $data['description'] = I("desc");
            if(I("video")!=0) $data['video'] = I("video");

            // 上传图片
            $upConfig = C("upFilm");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){
                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic80 = $info['pic']['savepath'].$filename."X80".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(80,80)->save($pic80);
                $img->thumb(200,200)->save($pic200);

                $data['pic'] = __ROOT__.substr($oPath,1);
                $data['pic50'] = __ROOT__.substr($pic50,1);
                $data['pic80'] = __ROOT__.substr($pic80,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);

            }

            $rs = $filmM->add($data);
            if($rs){
                $film = $filmM->where(array("cid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "添加成功";
                $res['info'] = $film;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "添加失败";
                $res['info'] = 0;
            }
            $this->ajaxReturn($res);
        }



    }

    public function film(){
        $filmM = new FilmModel();
        if($_POST){
            $fid = I("fid");
            $film = $filmM->where(array("fid"=>$fid))->find();
            $this->ajaxReturn($film);
        }
    }

    public function updateFilm(){
        $filmM = new FilmModel();

        if($_POST){
            $data['fid'] = I("fid");
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $data['description'] = I("desc");
            $data['cid'] = I("type");
            if(I("video")!=0) $data['video'] = I("video");

            // 上传图片
            $upConfig = C("upFilm");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){

                // 获取图片信息
                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic80 = $info['pic']['savepath'].$filename."X80".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(80,80)->save($pic80);
                $img->thumb(200,200)->save($pic200);

                $data['pic'] = __ROOT__.substr($oPath,1);
                $data['pic50'] = __ROOT__.substr($pic50,1);
                $data['pic80'] = __ROOT__.substr($pic80,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);

                // 删除原始图片
                $cateInfo = $filmM->where(array('fid'=>$data['fid']))->find();

                $delfile_o = ".".substr($cateInfo['pic'],strlen(__ROOT__));
                $delfile_50 = ".".substr($cateInfo['pic50'],strlen(__ROOT__));
                $delfile_80 = ".".substr($cateInfo['pic80'],strlen(__ROOT__));
                $delfile_200 = ".".substr($cateInfo['pic200'],strlen(__ROOT__));
                unlink($delfile_o);
                unlink($delfile_50);
                unlink($delfile_80);
                unlink($delfile_200);

            }

            $rs = $filmM->where(array('fid'=>$data['fid']))->save($data);
            if($rs){
                $film = $filmM->where(array("fid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "修改成功";
                $res['info'] = $film;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }
    }

    public function delFilm(){
        $filmM = new FilmModel();

        if($_POST){
            $fid = I("fid");
            $rs = $filmM->where(array('fid'=>$fid))->delete();
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

    /** 异步请求 */
    public function chgFilmID(){
        $filmM = new FilmModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $filmM->where(array("fid"=>$oldid))->setField("fid",$newid);

            if($rs){
                $aFilm = $filmM->where(array("fid"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $aFilm;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }

    }


    /** 电影分类 *******************************************************************/
    public function category(){
        $filmCateM = new FilmCateModel();
        $filmcates = $filmCateM->select();
        //dump($filmcates);die;

        $this->assign("filmcates",$filmcates);
        $this->display();
    }

    // 添加电影分类
    public function addFilmCate(){

        $filmCateM = new FilmCateModel();

        if($_POST){
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $data['description'] = I("desc");

            // 上传图片
            $upConfig = C("upFilmCate");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){

                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic80 = $info['pic']['savepath'].$filename."X80".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(80,80)->save($pic80);
                $img->thumb(200,200)->save($pic200);

                $data['pic'] = __ROOT__.substr($oPath,1);
                $data['pic50'] = __ROOT__.substr($pic50,1);
                $data['pic80'] = __ROOT__.substr($pic80,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);

            }

            $rs = $filmCateM->add($data);
            if($rs){
                $filmcategory = $filmCateM->where(array("cid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "添加成功";
                $res['info'] = $filmcategory;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "添加失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);

        }
    }

    // 获取分类信息
    public function filmCate(){
        $filmCateM = new FilmCateModel();
        if($_POST){
            $cid = I("cid");
            $filmCate = $filmCateM->where(array("cid"=>$cid))->find();
            $this->ajaxReturn($filmCate);
        }
    }

    // 更新分类信息
    public function updateFilmCate(){
        $filmCateM = new FilmCateModel();

        if($_POST){
            $data['cid'] = I("cid");
            $data['name'] = I("name");
            $data['ename'] = I("ename");
            $data['description'] = I("desc");

            // 上传图片
            $upConfig = C("upFilmCate");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){

                // 获取图片信息
                $file = $info['pic']['savename'];
                $ext = ".".$info['pic']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));

                $oPath = $info['pic']['savepath'].$file;
                $pic50 = $info['pic']['savepath'].$filename."X50".$ext;
                $pic80 = $info['pic']['savepath'].$filename."X80".$ext;
                $pic200 = $info['pic']['savepath'].$filename."X200".$ext;

                $img = new Image();
                $img->open($oPath);
                $img->thumb(50,50)->save($pic50);
                $img->thumb(80,80)->save($pic80);
                $img->thumb(200,200)->save($pic200);

                $data['pic'] = __ROOT__.substr($oPath,1);
                $data['pic50'] = __ROOT__.substr($pic50,1);
                $data['pic80'] = __ROOT__.substr($pic80,1);
                $data['pic200'] = __ROOT__.substr($pic200,1);

                // 删除原始图片
                $cateInfo = $filmCateM->where(array('cid'=>$data['cid']))->find();

                $delfile_o = ".".substr($cateInfo['pic'],strlen(__ROOT__));
                $delfile_50 = ".".substr($cateInfo['pic50'],strlen(__ROOT__));
                $delfile_80 = ".".substr($cateInfo['pic80'],strlen(__ROOT__));
                $delfile_200 = ".".substr($cateInfo['pic200'],strlen(__ROOT__));
                unlink($delfile_o);
                unlink($delfile_50);
                unlink($delfile_80);
                unlink($delfile_200);

            }

            $rs = $filmCateM->where(array('cid'=>$data['cid']))->save($data);
            if($rs){
                $filmcategory = $filmCateM->where(array("cid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "修改成功";
                $res['info'] = $filmcategory;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);

        }
    }

    // 删除分类信息
    public function delFilmCate(){
        $filmCateM = new FilmCateModel();

        if($_POST){
            $cid = I("cid");
            $rs = $filmCateM->where(array('cid'=>$cid))->delete();
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

    /** 异步请求 */
    public function chgFilmCateID(){
        $filmCateM = new FilmCateModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $filmCateM->where(array("cid"=>$oldid))->setField("cid",$newid);

            if($rs){
                $aFilmCate = $filmCateM->where(array("cid"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $aFilmCate;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }

    }



}