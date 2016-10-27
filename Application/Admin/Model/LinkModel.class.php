<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 13:20
 */

namespace Admin\Model;


use Think\Model;

class LinkModel extends Model{

    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('li_title','require','超链接标题必填!',1,'regex',3),       // li_title字段 存在性验证 必须验证  验证时间：新增、编辑
        array('li_title','','超链接标题不能重复!',1,'unique',1)  ,        // li_title字段 唯一性验证 必须验证 验证时间：新增

    );

    public function deleteLink($li_id){
        $rs = $this->where("li_id=".$li_id)->delete();
        return $rs;
    }

    public function deleteLinkM($li_ids){
        $ars = implode(",",$li_ids);
        $rs = $this->where("li_id in (".$ars.")")->delete();
        return $rs;
    }

}