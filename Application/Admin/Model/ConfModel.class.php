<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 15:04
 */

namespace Admin\Model;


use Think\Model;

class ConfModel extends Model{

    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('cf_name','require','配置名称不能为空!',1,'regex',3),         // cf_name字段 存在性验证 必须验证  验证时间：新增、编辑
        array('cf_name','','配置名称不能重复!',1,'unique',1)  ,             // cf_name字段 唯一性验证 必须验证 验证时间：新增

        array('cf_ename','require','配置英文名称不能为空!',1,'regex',3),    // cf_ename字段 存在性验证 必须验证  验证时间：新增、编辑
        array('cf_ename','','配置英文名称不能重复!',1,'unique',1)  ,        // cf_ename字段 唯一性验证 必须验证 验证时间：新增


    );

    public function deleteConf($cf_id){
        $rs = $this->where("cf_id=".$cf_id)->delete();
        return $rs;
    }

    public function deleteConfM($cf_ids){
        $cf_idss = implode(",",$cf_ids);
        $rs = $this->where("cf_id in (".$cf_idss.")")->delete();
        return $rs;
    }

    public function modify($info){
        //dump($info);die;
        foreach($info as $key=>$val){
            $this->execute("UPDATE z_conf SET cf_value = '$val' WHERE cf_ename = '$key'");
        }
    }

}