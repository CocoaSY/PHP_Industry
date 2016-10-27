<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/28/16
 * Time: 11:16
 */

namespace Admin\Model;


use Think\Model;

class ArticleModel extends Model{

    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('ar_title','require','文章标题必填!',1,'regex',3),       // ar_title字段 存在性验证 必须验证  验证时间：新增、编辑
        array('ar_title','','文章标题不能重复!',1,'unique',1)  ,        // ar_title字段 唯一性验证 必须验证 验证时间：新增
        array('ar_cateid','require','文章所属栏目必填!',1,'regex',3),   // ar_cateid字段 存在性验证 必须验证  验证时间：新增、编辑

    );

    public function deleteArc($ar_id){
        $rs = $this->where("ar_id=".$ar_id)->delete();
        return $rs;
    }

    public function deleteArcM($ar_ids){
        //dump($ar_ids);echo $ar_ids;die;
        $ars = implode(",",$ar_ids);
        //echo "deleteArtile in".$ars;die;
        $rs = $this->where("ar_id in (".$ars.")")->delete();
        return $rs;
    }

    public function articleids($cid){
        $rs = $this->where(array("ar_cateid"=>$cid))->field(array("ar_id"))->select();
        return $rs;
    }

    public function chgArCateid($oldcid,$newcid){
        $ars = $this->articleids($oldcid);
        foreach($ars as $key=>$val){
            $this->where(array("ar_id"=>$val['ar_id']))->setField("ar_cateid",$newcid);
        }
        return $this->articleids($newcid);
    }

}