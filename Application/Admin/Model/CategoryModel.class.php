<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 9/26/16
 * Time: 22:29
 */

namespace Admin\Model;
use Think\Model;

//enum Delete_Model
define("Delete_Model_One",1);
define("Delete_Model_Multi",2);

class CategoryModel extends Model {

    private $delete_model = Delete_Model_One;

    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('cate_name','require','栏目名称必填!',1,'regex',3),     // cate_name字段 存在性验证 必须验证  验证时间：新增、编辑
        array('cate_name','','栏目名称不能重复!',1,'unique',1)  ,      // cate_name字段 唯一性验证 必须验证 验证时间：新增

        //array('cate_ename','require','栏目英文名称必填!',1,'regex',3),     // cate_ename字段 存在性验证 必须验证  验证时间：新增、编辑
        //array('cate_ename','','栏目英文名称不能重复!',1,'unique',1),        // cate_ename字段 唯一性验证 必须验证 验证时间：新增

    );

    protected $_auto = array(
        //array(完成字段1,完成规则,[完成条件,附加规则]),

        //array(完成字段1,完成规则,[完成条件,附加规则]),



    );



    // 分类树
    public function getCates_tree(){
        $data = $this->select();
        return $this->_resort($data);
    }

    public function getCateNames_tree(){
        $data = $this->field(array('cate_id','cate_name','cate_pid'))->select();
        return $this->_resort($data);
    }

    //获取 $cate_id 栏目下的所有子栏目
    public function getSubids($cate_id){
        $cates = $this->field(array("cate_id","cate_pid"))->select();
        return $this->_subids($cates,$cate_id);
    }

    // 递归对所有的分类重新排序
    private function _resort($data,$pid=0,$level=0){

        static $ret = array();

        foreach($data as $k=>$v){
            if($v['cate_pid']==$pid){
                $v['level'] = $level;
                $v['pre'] = str_repeat('--',$level);
                array_push($ret,$v);
                $this->_resort($data,$v['cate_id'],$level+1);
            }
        }
        return $ret;

    }

    // 递归当前栏目下的所有子栏目
    private function _subids($cates,$cate_id){

        static $data = array();

        foreach($cates as $key=>$cate){
            if($cate['cate_pid']==$cate_id){
                array_push($data,$cate);
                $this->_subids($cates,$cate['cate_id']);
            }
        }
        return $data;

    }

    public function _before_delete($options){ // 勾子函数

        $soncates = array();
        if($this->delete_model == Delete_Model_One){
            $whe = $options['where']['_string'];
            $whearr = explode("=",$whe);
            $cate_id = $whearr[1];
            $soncates = $this->getSubids($cate_id);
            //dump($soncates);
        }elseif($this->delete_model == Delete_Model_Multi){
            $arr = explode("in",$options['where']['_string']);
            $str = $arr[1];
            $sustr = substr($str,1,strlen($str)-2);//dump($sustr);
            $arrs = explode(",",$sustr);//dump($arrs);
            foreach($arrs as $k=>$v){
                $_soncates = $this->getSubids($v);//dump($_soncates);
                $soncates = array_merge($soncates,$_soncates);
            }

            $temp = array();
            foreach($soncates as $k=>$v){
                array_push($temp,$v['cate_id']);
            }
            $soncates = $temp;
            $soncates = array_unique($soncates);
        }

        if(!empty($soncates)){
            //dump($soncates);
            $soncates = implode(",",$soncates);//dump($soncates);die;
            $this->execute("DELETE FROM z_category WHERE cate_id IN ($soncates)");
        }
        //dump($options);die;
    }


    public function deleteCate($cate_id){
        $this->delete_model = Delete_Model_One;
        $rs = $this->where("cate_id=".$cate_id)->delete();
        return $rs;
    }

    public function deleteCateM($cate_ids){
        $this->delete_model = Delete_Model_Multi;
        $delsstr = implode(',',$cate_ids);
        //dump($delsstr);die;
        $rs = $this->where("cate_id in(".$delsstr.")")->delete();
        return $rs;
    }

    public function chgCatepid($oldpid,$newpid){
        $cates = $this->where(array("cate_pid"=>$oldpid))->field(array("cate_id"))->select();
        foreach($cates as $key=>$val){
            $this->where(array("cate_id"=>$val['cate_id']))->setField("cate_pid",$newpid);
        }
        return $this->where(array("cate_pid"=>$newpid))->field(array("cate_id"))->select();
    }




}