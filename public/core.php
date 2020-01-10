<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/10
 * Time: 17:05
 */

/**
 * 公共入口文件
 */

//检测php环境
if(version_compare(PHP_VERSION,'5.6.0','<')) die('php version must be >5.6.0');

//定义系统版本
define('app_version','v0.0.1');

//定义系统目录分隔符
define('DS','/');

//http类型
define('__MY_HTTP__',((!empty($_SERVER['https']) && strtolower($_SERVER['https'])!=='off') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO']==='https') || (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS'])!=='off') || (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT']=='443') || (!empty($_SERVER['HTTP_FROM_HTTPS']) && strtolower($_SERVER['HTTP_FROM_HTTPS'])!=='off') || (!empty($_SERVER['HTTP_X_CLIENT_SCHEME']) && $_SERVER['HTTP_X_CLIENT_SCHEME']=='https'))? 'https':'http');