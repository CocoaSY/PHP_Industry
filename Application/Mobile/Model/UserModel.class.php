<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/11/16
 * Time: 15:33
 */

namespace Mobile\Model;


use Think\Model;

class UserModel extends Model\RelationModel{

    protected $_link = array(

        "UserInfo"=>array(
            'mapping_type'  =>self::HAS_ONE,
            'class_name'    =>'UserInfo',
            'mapping_name'  =>'userinfo',
            'foreign_key'   =>'uid',     //主表外键
        ),

    );

}