<?php
namespace Admin\Controller;
use Admin\Model\VideoModel;
use Think\Controller;
use Think\Upload;

class TestController extends Controller {
    public function index(){

        $this->display();
    }

    public function testCategory(){

        $cate = D("Category");
        $data = $cate->getSubids(33);
        dump($data);

    }

    public function testJson(){

        $data = array(
            "fjeo"=>array("as"=>"uuu","mm"=>"jiuu"),
            "sdf"=>array("23"=>"sfd","ew"=>"wer3"),
            "xvxc"=>array("34"=>"wr3","wed"=>"wrw3r"),
        );

        $this->ajaxReturn($data,"json");

    }

    public function testCateJson(){

        $cate = D("Category");
        $data = $cate->select();
        $this->ajaxReturn($data,"json");

    }

    public function testFilePath(){

        $path = __MODULE__."/Public/upload";
        echo $path;


    }

    public function icon(){
        $this->display();
    }

    public function testConfig(){
        echo C("upFace");
        echo C(INTEGRAL_LOGIN);
        $this->display();
    }

    public function testFile(){
        $filepath = CONF_PATH.'IndexConf.php';

        $key = "List1";
        $data['name'] = "列表12";
        $data['cid'] = "662";
        $data['aid'] = "02";

        $res = get_config($filepath,$key,"array");
        dump($res);


    }

    public function testConf(){
        $filepath = CONF_PATH.'TestConf.php';

        $key = "Test2";
        $value = array(
            'name'  => '列表123',
            'cid'   => '662',
            'aid'   => '02',
        );

        $arr = TestConfig();
        foreach($arr as $k=>$v){
            if($k = $key){
                $arr[$k]=$value;
            }
        }
        //dump($arr);
        file_put_contents($filepath,"<?php \n function TestConfig(){ return ".var_export($arr,true)."; }");


    }


    /** 视频上传 */
    public function testVideo(){

        $videoM = new VideoModel();
        $videos = $videoM->select();

        $this->assign("videos",$videos);
        $this->display();
    }

    public function addVideo(){

        $videoM = new VideoModel();

        if($_POST){

            $data['name'] = I("name");
            $data['ename'] = I("ename");

            //上传视频
            $upConfig = C("upVideo");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){

                $file = $info['video']['savename'];
                $ext = ".".$info['video']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));
                $oPath = $info['video']['savepath'].$file;
                $data['path'] = __ROOT__.substr($oPath,1);
                $data['type'] = $info['video']['type'];
                $data['size'] = $info['video']['size'];

            }
            $rs = $videoM->add($data);
            if($rs){
                $aVideo = $videoM->where(array("vid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "添加成功";
                $res['info'] = $aVideo;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "添加失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);

        }

    }

    public function video(){
        $videoM = new VideoModel();
        if($_POST){
            $vid = I("vid");
            $video = $videoM->where(array("vid"=>$vid))->find();
            $this->ajaxReturn($video);
        }
    }

    public function updateVideo(){
        $videoM = new VideoModel();
        if($_POST){

            $data['vid'] = I("vid");
            $data['name'] = I("name");
            $data['ename'] = I("ename");

            //上传视频
            $upConfig = C("upVideo");
            $upload = new Upload($upConfig);
            $info = $upload->upload();
            if($info){
                $file = $info['video']['savename'];
                $ext = ".".$info['video']['ext'];
                $filename = substr($file,0,strlen($file)-strlen($ext));
                $oPath = $info['video']['savepath'].$file;
                $data['path'] = __ROOT__.substr($oPath,1);
                $data['type'] = $info['video']['type'];
                $data['size'] = $info['video']['size'];

                // 删除原始视频
                $videoInfo = $videoM->where(array('vid'=>$data['vid']))->find();

                $delfile_o = ".".substr($videoInfo['path'],strlen(__ROOT__));
                unlink($delfile_o);
            }

            $rs = $videoM->where(array('vid'=>$data['vid']))->save($data);
            if($rs){
                $video = $videoM->where(array("vid"=>$rs))->find();
                $res['rs'] = 1;
                $res['msg'] = "修改成功";
                $res['info'] = $video;
            }else{
                $res['rs'] = 0;
                $res['msg'] = "修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }



    }

    public function delVideo(){
        $videoM = new VideoModel();

        if($_POST){
            $vid = I("vid");

            // 删除原始视频
            $videoInfo = $videoM->where(array('vid'=>$vid))->find();
            $delfile_o = ".".substr($videoInfo['path'],strlen(__ROOT__));
            unlink($delfile_o);

            $rs = $videoM->where(array("vid"=>$vid))->delete();
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

    public function chgVideoID(){
        $videoM = new VideoModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $videoM->where(array("vid"=>$oldid))->setField("vid",$newid);

            if($rs){
                $video = $videoM->where(array("vid"=>$newid))->find();
                $res['rs'] = $rs;
                $res['msg'] = "ID修改成功";
                $res['info'] = $video;
            }else{
                $res['rs'] = $rs;
                $res['msg'] = "ID修改失败";
                $res['info'] = 0;
            }

            $this->ajaxReturn($res);
        }
    }


    /** 上传文件 */
    public function uploadVideo(){

        $videoM = new VideoModel();

        //上传视频
        $upConfig = C("upVideo");
        $upload = new Upload($upConfig);
        $info = $upload->upload();
        if($info){
            $res['rs'] = 1;
            $res['msg'] = "上传成功";
            $res['info'] = $info;
        }else{
            $res['rs'] = 0;
            $res['msg'] = "上传失败";
            $res['info'] = $upload->getError();
        }

        $this->ajaxReturn($res);
    }


}