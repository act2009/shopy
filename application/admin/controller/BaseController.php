<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/14
 * Time: 15:33
 */


namespace app\admin\controller;

use think\App;
use think\Controller;

/**
 * Class Base
 * @package app\admin\controller
 * 公用基类
 */
class BaseController extends Controller
{
    /**
     * @note:构造方法
     * @author:{act2009}
     * @time:2020/1/15 11:14
     * @params:NULL
     */
    public function __construct()
    {
        parent::__construct();

        //视图初始化
        $this->ViewInit();
    }


    /**
     * @note:视图初始化
     * @author:{act2009}
     * @time:2020/1/15 11:15
     * @params:NULL
     */
    public function ViewInit(){
        $default_theme='default';
        $this->assign('default_theme',$default_theme);


        //图片host地址
        $this->assign('attachment_host',config('shopy.attachment_host'));
    }

}