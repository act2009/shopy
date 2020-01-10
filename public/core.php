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
//define('__MY_HTTP__',((!empty($_SERVER['https'])&&))? 'https':'http');