<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/16
 * Time: 16:03
 */


namespace app\admin\controller;

/**
 * 管理员管理
 * Class admin
 * @package app\admin\controller
 */
class admin extends BaseController
{

    /**
     * @note: admin login
     * @author:{act2009}
     * @time:2020/1/16
     * @params:NULL
     */
    public function Login()
    {
        if(!IS_AJAX){
            return $this->error('非法访问');
        }

        //登录处理
        $params=input('post.');


    }

}