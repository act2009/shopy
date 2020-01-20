<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/16
 * Time: 16:03
 */


namespace app\admin\controller;

use app\service\AdminService;
use think\facade\Hook;

/**
 * 管理员管理
 * Class admin
 * @package app\admin\controller
 */
class Admin extends BaseController
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
        return AdminService::Login($params);
    }

    /**
     * @note:退出登录
     * @author:{act2009}
     * @time:2020/1/20
     * @params:NULL
     * @return:NULL
     */
    public function Logout(){
        session_destroy();
        return redirect(MyUrl('admin/admin/logininfo'));
    }

    /**
     * @note: 登录页面
     * @author:{act2009}
     * @time:2020/1/20
     * @params:NULL
     * @return:NULL
     */
    public function LoginInfo(){
        //是否已经登录
        if(session('admin')!==null){
            return redirect(MyUrl('admin/index/index'));
        }
        // 管理员登录页面钩子
        $hook_name = 'plugins_view_admin_login_info';
        $this->assign(
            $hook_name.'_data',
            Hook::listen($hook_name,[
                'hook_name'=>$hook_name,
                'is_backend'=>true
            ])
        );
        return $this->fetch();
    }

}