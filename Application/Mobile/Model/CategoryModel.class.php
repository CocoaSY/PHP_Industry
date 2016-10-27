<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/26/16
 * Time: 22:29
 */

namespace Mobile\Model;
use Think\Model;


class CategoryModel extends Model {

    public function mainNavs(){
        $navs = $this->join("LEFT JOIN __CATEGORY_TYPE__ ON __CATEGORY__.cate_type=__CATEGORY_TYPE__.catet_id")
            ->where("cate_nav=1")
            ->select();
        return $navs;
    }

    public function subCates($pid){
        $subNavs = $this->join("LEFT JOIN __CATEGORY_TYPE__ ON __CATEGORY__.cate_type=__CATEGORY_TYPE__.catet_id")
            ->where("cate_pid=".$pid)
            ->select();
        return $subNavs;
    }

    //面包屑导航
    public function getPid($cid){
        $res = array();
        while($cid){
            $cates = $this->where("cate_id=".$cid)->find();
            $res[]=array(
                "cate_id" => $cates['cate_id'],
                "cate_name" => $cates['cate_name'],
            );
            $cid = $cates['cate_pid'];
        }
        return array_reverse($res);
    }




}