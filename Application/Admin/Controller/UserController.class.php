<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 13:19
 */

namespace Admin\Controller;


use Admin\Model\Location\LocationCityModel;
use Admin\Model\Location\LocationDistrictModel;
use Admin\Model\Location\LocationProvinceModel;
use Admin\Model\TopicCateModel;
use Admin\Model\UserInfoModel;
use Admin\Model\UserModel;
use Think\Image;
use Think\Upload;

class UserController extends BaseController{
    public function index(){

        $userM = D("User");
        $userinfoM = D("UserInfo");
        $users = $userM
                ->join("LEFT JOIN __USER_INFO__ ON __USER_INFO__.uid=__USER__.u_id")
                ->select();
        foreach($users as $key=>$val){
            $time = $val['regtime'];
            $date = date("Y-m-d H:i:s",$time);
            $users[$key]['regtime'] = $date;
        }
        //dump($users);die;
        $this->assign("users",$users);
        $this->display();
    }

    public function add(){

        $userM = new UserModel();
        $userinfoM = new UserInfoModel();

        if(IS_POST){

            $udata['username'] = I("username");
            $udata['regtime'] = time();
            $udata['email'] = I("email");
            $udata['password'] = encodePass($udata['regtime'],I("password"));

            $rs = $userM->add($udata);
            if($rs){
                $uidata['uid'] = $rs;
                $uidata['nickname'] = I("nickname");
                $uidata['job'] = I("job");
                $uidata['email'] = I("email");
                $uidata['provinceid'] = I("province");
                $uidata['cityid'] = I("city");
                $uidata['districtid'] = I("district");
                $uidata['sex'] = I("sex");
                $uidata['sex'] = I("sex");

                $rsi = $userinfoM->add($uidata);

                if($rsi){
                    $this->success("用户添加成功",U("User/index"));
                }else{
                    $this->error("用户添加失败");
                }
            }else{
                $this->error("用户添加失败");
            }
            return;
        }

        $province = new LocationProvinceModel();
        $provinces = $province->provinces();
        $this->assign("provinces",$provinces);
        $this->display();
    }

    public function edit(){

        $userM = new UserModel();
        $userinfoM = new UserInfoModel();
        $topiccateM = new TopicCateModel();

        if($_GET['u_id']){

            $userID = I("u_id");
            $user = $userM
                    ->join("LEFT JOIN __USER_INFO__ ON __USER_INFO__.uid=__USER__.u_id")
                    ->where(array("u_id"=>$userID))
                    ->find();

            //dump($user);die;

            if($_POST['sub']==1){   //修改资料

                //dump($_POST);die;

                $uiData['uid'] = I('uid');
                $uiData['nickname'] = I('nickname');
                $uiData['job'] = I('job');
                $uiData['provinceid'] = I('province');
                $uiData['cityid'] = I('city');
                $uiData['districtid'] = I('district');
                $uiData['sex'] = I('sex');
                $uiData['intro'] = I('intro');

                $rsi = $userinfoM->where(array("uid"=>$uiData['uid']))->save($uiData);
                if($rsi){
                    $this->success("用户修改成功");
                }else{
                    $this->error("用户修改失败:".$userinfoM->getError());
                }
                return;
            }

            if($_POST['sub']==2){   //修改密码
                //dump($_POST);die;
                $uData['u_id'] = I("uid");
                $regtime = $userM->where(array("u_id"=>$uData['u_id']))->getField("regtime");
                //echo $regtime;die;
                $uData['password'] = encodePass($regtime,I("password"));

                $rs = $userM->where(array("u_id"=>$uData['u_id']))->save($uData);
                if($rs){
                    $this->success("密码修改成功");
                }else{
                    $this->error("密码修改失败:".$userinfoM->getError());
                }
                return;
            }

            if($_POST['sub']==3){   //上传头像
                $faceData['uid'] = I("uid");
                $upConfig = C("upFace");
                $upload = new Upload($upConfig);
                $info = $upload->upload();
                //dump($info);die;
                if($info){
                    $file = $info['face']['savename'];
                    $ext = ".".$info['face']['ext'];
                    $filename = substr($file,0,strlen($file)-strlen($ext));

                    $oPath = $info['face']['savepath'].$file;
                    $face50 = $info['face']['savepath'].$filename."X50".$ext;
                    $face80 = $info['face']['savepath'].$filename."X80".$ext;
                    $face180 = $info['face']['savepath'].$filename."X180".$ext;

                    $img = new Image();
                    $img->open($oPath);
                    $img->thumb(50,50)->save($face50);
                    $img->thumb(80,80)->save($face80);
                    $img->thumb(180,180)->save($face180);

                    $faceData['face'] = __ROOT__.substr($oPath,1);
                    $faceData['face50'] = __ROOT__.substr($face50,1);
                    $faceData['face80'] = __ROOT__.substr($face80,1);
                    $faceData['face180'] = __ROOT__.substr($face180,1);
                    //dump($faceData);die;
                    $userinfo = $userinfoM->where(array('uid'=>$faceData['uid']))->find();
                    if(empty($userinfo['face'])){
                        //首次上传头像
                        $faceData['integral'] = $userinfo['integral']+C("FACE");
                    }else{
                        $delfile_o = ".".substr($userinfo['face'],strlen(__ROOT__));
                        $delfile_50 = ".".substr($userinfo['face50'],strlen(__ROOT__));
                        $delfile_80 = ".".substr($userinfo['face80'],strlen(__ROOT__));
                        $delfile_180 = ".".substr($userinfo['face180'],strlen(__ROOT__));
                        unlink($delfile_o);
                        unlink($delfile_50);
                        unlink($delfile_80);
                        unlink($delfile_180);
                    }
                    $userinfoM->where(array('uid'=>$faceData['uid']))->save($faceData);

                    $this->success("头像修改成功");
                }else{
                    $this->error($upload->getError());
                }



                return;
            }

            $province = new LocationProvinceModel();
            $city = new LocationCityModel();
            $district = new LocationDistrictModel();
            $provinces = $province->provinces();
            $citys = $city->citys($user['provinceid']);
            $districts = $district->districts($user['cityid']);
            $topiccates = $topiccateM->select();

            $this->assign("user",$user);
            $this->assign("provinces",$provinces);
            $this->assign("citys",$citys);
            $this->assign("districts",$districts);
            $this->assign("topiccates",$topiccates);
            $this->display();
        }

    }

}