<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 15:03
 */

namespace Admin\Controller;


use Admin\Model\ConfModel;
use Admin\Model\ConfTypeModel;
use Think\Controller;

class ConfController extends BaseController{

    public function index(){
        $conf = new ConfModel();
        $conf_type = new ConfTypeModel();

        $confs = $conf->join("z_conf_type on cf_type=cft_id")->select();
        //dump($confs);die;

        $conf_types = $conf_type->select();
        $this->assign("conftypes",$conf_types);
        $this->assign("confs",$confs);
        $this->display();
    }

    public function add(){

        $conf = D("Conf");
        $conf_type = D("ConfType");

        if($_POST){

            $data["cf_name"]    = I("cf_name");     //配置名称
            $data["cf_ename"]   = I("cf_ename");    //配置英文名称
            $data["cf_type"]    = I("cf_type");     //配置类型
            $data["cf_values"]  = I("cf_values");   //配置可选值
            $data["cf_value"]   = I("cf_value");    //配置默认值

            if($conf->create()){
                if($conf->add($data)){
                    $this->success("配置项添加成功",U("index"));
                }else{
                    $this->error("配置项添加失败");
                }
            }else{
                $this->error($conf->getError());
            }

            return;
        }

        $conf_types = $conf_type->select();
        $this->assign("conftypes",$conf_types);
        $this->display();
    }

    public function edit(){

        $conf = D("Conf");
        $conf_type = D("ConfType");

        if($_POST['sub']){

            $data["cf_id"]      = I("cf_id");       //配置ID
            $data["cf_name"]    = I("cf_name");     //配置名称
            $data["cf_ename"]   = I("cf_ename");    //配置英文名称
            $data["cf_type"]    = I("cf_type");     //配置类型
            $data["cf_values"]  = I("cf_values");   //配置可选值
            $data["cf_value"]   = I("cf_value");    //配置默认值

            if($conf->create()){
                $rs = $conf->where("cf_id=".$data["cf_id"])->save($data);
                if($rs){
                    $this->success("配置项保存成功",U("index"));
                }else{
                    $this->error("配置项保存失败");
                }
            }else{
                $this->error($conf->getError());
            }

            return ;
        }

        if($_GET["cf_id"]){
            $cf_id = I("cf_id");

            $cf = $conf->join("z_conf_type on cf_type=cft_id")->where("cf_id=".$cf_id)->find();
            //dump($cf);

            $this->assign("conf",$cf);
            $conf_types = $conf_type->select();
            $this->assign("conftypes",$conf_types);
            $this->display();
        }
    }

    public function deleteConf(){
        $conf = D("Conf");

        if($_GET["cf_id"]){
            $cf_id = I("cf_id");
            $rs = $conf->deleteConf($cf_id);
            if($rs){
                $this->success("配置项删除成功!",U("index"));
            }else{
                $this->error("配置项删除失败!");
            }
        }

    }

    public function deleteConfM(){
        $conf = D("Conf");

        if($_POST["dels"]){
            $cf_ids = I("dels");
            $rs = $conf->deleteConfM($cf_ids);
            if($rs){
                $this->success("配置项批量删除成功!",U("index"));
            }else{
                $this->error("配置项批量删除失败!");
            }
        }
    }

    public function webinfo(){

        $conf = D("Conf");

        if($_POST['sub']){
            $confs = $conf->field(array("cf_id,cf_ename"))->select();
            $data = array();
            foreach($confs as $key=>$value){
                $data[$value['cf_ename']] = I($value['cf_ename']);
            }
            //dump($data);
            $rs = $conf->modify($data);
            //if($rs){
            //    $this->success("配置修改成功",U("webinfo"));
            //}else{
            //    $this->error("配置修改失败");
            //}
        }


        $conf_type = D("ConfType");
        $cf = $conf->join("z_conf_type on cf_type=cft_id")->order("cf_id asc")->select();
        $cfs = array();
        foreach($cf as $key=>$va){
            $values = explode(",",$va['cf_values']);
            $va['values'] = $values;
            //dump($va);
            array_push($cfs,$va);
        }
        //dump($cfs);die;

        $this->assign("confs",$cfs);
        $this->display();
    }

    public function integral(){

        $this->display();
    }

    /** 异步请求 */
    public function chgID(){
        $confM = new ConfModel();
        if(IS_AJAX){
            $oldid = I("oldid");
            $newid = I("newid");


            $rs = $confM->where(array("cf_id"=>$oldid))->setField("cf_id",$newid);

            if($rs){
                $aConf = $confM->where(array("cf_id"=>$newid))->find();
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


}