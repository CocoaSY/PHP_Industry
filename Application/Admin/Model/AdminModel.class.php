<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/1/16
 * Time: 13:06
 */

namespace Admin\Model;


use Think\Model;

class AdminModel extends Model{

    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('ad_name','require','管理员名称不能为空!',1,'regex',3),     // ad_name字段 存在性验证 必须验证  验证时间：新增、编辑
        array('ad_name','','管理员名称不能重复!',1,'unique',1)  ,      // ad_name字段 唯一性验证 必须验证 验证时间：新增

        array('ad_password','require','管理员密码不能为空!',1,'regex',3),     // ad_password字段 存在性验证 必须验证  验证时间：新增、编辑

    );


    public function getAllAdmins(){
        $data = $this->select();
        return $data;
    }

    //管理员密码加密
    public function encodepass($regtime,$originPass){
        $new = $regtime.$originPass;
        return md5($new);
    }

    //管理员密码验证
    public function checkPass($adminid,$pass){
        $where = array("ad_id"=>$adminid);
        $regtime = $this->where($where)->getField("regtime");
        $userpass = $this->where($where)->getField("ad_password");
        if($userpass == $this->encodePass($regtime,$pass)){
            return true;
        }else{
            return false;
        }
    }





}