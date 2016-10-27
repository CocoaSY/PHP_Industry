<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/6/16
 * Time: 20:30
 */

namespace Home\Model;


use Think\Model;

class ContactModel extends Model{
    protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),

        array('ct_username','require','名称不能未空!',1,'regex',1),   // ct_username字段 存在性验证 必须验证  验证时间：新增
        array('ct_email','require','邮箱不能未空!',1,'regex',1),      // ct_email字段 存在性验证 必须验证  验证时间：新增
        array('ct_email','email','请输入正确的邮箱!',1,'regex',1),      // ct_email字段 存在性验证 必须验证  验证时间：新增
        array('ct_message','require','信息不能未空!',1,'regex',1),    // ct_message字段 存在性验证 必须验证  验证时间：新增

    );

}