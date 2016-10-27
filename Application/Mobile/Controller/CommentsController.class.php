<?php
/**
 * Created by PhpStorm.
 * User: cocoa
 * Date: 10/12/16
 * Time: 09:18
 *
 * 评论
 *
 */

namespace Mobile\Controller;


use Think\Controller;

class CommentsController extends Controller{

    /*** 读取接口 */

    /**
     * 获取某条微博的评论列表
     */
    public function show(){

    }

    /**
     * 我发出的评论列表
     */
    public function by_me(){

    }

    /**
     * 我收到的评论列表
     */
    public function to_me(){

    }

    /**
     * 获取用户发送及收到的评论列表
     */
    public function timeline(){

    }

    /**
     * 获取@到我的评论
     */
    public function mentions(){

    }

    /**
     * 批量获取评论内容
     */
    public function show_batch(){

    }

    /*** 写入接口 */

    /**
     * 评论一条微博
     */
    public function create(){

    }

    /**
     * 删除一条评论
     */
    public function destory(){

    }

    /**
     * 批量删除评论
     */
    public function destory_batch(){

    }

    /**
     * 回复一条评论
     */
    public function reply(){

    }

}