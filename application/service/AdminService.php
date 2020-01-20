<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/16
 * Time: 16:09
 */


namespace app\service;

use think\Db;

/**
 * 管理员服务层
 * Class AdminService
 * @package app\service
 */
class AdminService
{
    /**
     * @note: admin login service
     * @author:{act2009}
     * @time:2020/1/16
     * @params:NULL
     */
    public static function Login($params=[])
    {
        //请求参数
        $p = [
            [
                'checked_type'      => 'empty',
                'key_name'          => 'username',
                'error_msg'         => '用户名不能为空',
            ],
            [
                'checked_type'      => 'empty',
                'key_name'          => 'login_pwd',
                'error_msg'         => '密码不能为空',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'username',
                'checked_data'      => 'CheckUserName',
                'error_msg'         => '用户名格式 5~18 个字符（可以是字母数字下划线）',
            ],
            [
                'checked_type'      => 'fun',
                'key_name'          => 'login_pwd',
                'checked_data'      => 'CheckLoginPwd',
                'error_msg'         => '密码格式 6~18 个字符',
            ],
        ];
        //参数校验
        $ret=ParamsChecked($params,$p);
        if($ret!==true){
            return DataReturn($ret,-1);
        }

        //获取管理员
        $admin=Db::name('Admin')->
        field('id,username,login_pwd,login_salt,mobile,login_total,role_id')->
        where(['username'=>$params['username']])->find();
        if(empty($admin)){
            return DataReturn('管理员不存在',-2);
        }
        //密码校验
        $login_pwd=LoginPwdEncryption($params['login_pwd'],$admin['login_salt']);
        if($login_pwd !==$admin['login_pwd']){
            return DataReturn('密码错误',-3);
        }

        //校验成功,保存session
        session('admin',$admin);
        //返回数据,更新数据库
        if(session('admin') !=null){
            $login_salt=GetNumberCode(6);
            $data=array(
                'login_salt'=>$login_salt,
                'login_pwd'=>LoginPwdEncryption($params['login_pwd'],$login_salt),
                'login_total'=>$admin['login_total']+1,
                'login_time'=>time()
            );

            if(Db::name('Admin')->where(['id'=>$admin['id']])->update($data)){
                //清空权限缓存数据
                cache(config('cache_admin_left_menu_key').$admin['id'],null);
                cache(config('cache_admin_power_key'),null);
                return DataReturn('登录成功');
            }
        }

        //失败,清除session
        session('admin',null);
        return DataReturn('登录失败,请稍后再试',-100);

    }

}