<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/13
 * Time: 14:57
 */

/**
 * admin config
 */
 return [
     // 默认输出类型
     'default_return_type'    => 'html',
     // 默认AJAX 数据返回格式,可选json xml ...
     'default_ajax_return'    => 'json',
     //缓存key列表
     //权限缓存储存key
     'cache_admin_power_key'=>'cache_admin_power_',
     //菜单列表
     'cache_admin_left_menu_key'=>'cache_admin_left_menu_',

     // URL模式
     'URL_MODEL'                     =>  0,

     //设置默认的模版主题
     'DEFAULT_THEME'             => 'Default',
 ];