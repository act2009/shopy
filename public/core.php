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

//root目录
$my_root=empty($_SERVER['SCRIPT_NAME'])?'':substr($_SERVER['SCRIPT_NAME'],1,strrpos($_SERVER['SCRIPT_NAME'],'/'));
define('__MY_ROOT__',defined('IS_ROOT_ACCESS')? $my_root:str_replace('public'.DS,'',$my_root));
define('__MY_ROOT_PUBLIC__',defined('IS_ROOT_ACCESS')? DS.$my_root.'public'.DS : DS.$my_root);

//项目host
define('__MY_HOST__',empty($_SERVER['HTTP_HOST'])? '': $_SERVER['HTTP_HOST']);

//项目url地址
define('__MY_URL__',  empty($_SERVER['HTTP_HOST'])?  '':__MY_HTTP__.'://'.__MY_HOST__.DS.$my_root);

// 项目public目录URL地址
define('__MY_PUBLIC_URL__',empty($_SERVER['HTTP_HOST'])? '': __MY_HTTP__.'://'.__MY_HOST__.__MY_ROOT_PUBLIC__);

// 当前页面url地址
$request_url=isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
define('__MY_VIEW_URL__',substr(__MY_URL__,0,-1).$request_url);

//系统root目录，强制转换windows系统反斜杠
define('ROOT_PATH',str_replace('\\',DS,dirname(__FILE__).DS));

// 系统root目录 去除public
define('ROOT',str_replace('public'.DS,'',ROOT_PATH));

//自定义应用目录
define('APP_PATH', ROOT.'application'.DS);

//请求应用[web app] 默认web（ios/android/小程序为app）
define('APPLICATION',empty($_REQUEST['application']) ? 'web':trim($_REQUEST['application']));

// 请求客户端 [pc, h5, ios, android, alipay, weixin, baidu] 默认pc(目前系统为自适应,h5需自行校验)
define('APPLICATION_CLIENT_TYPE',empty($_REQUEST['application_client_type']) ? 'pc' : $_REQUEST['application_client_type']);

// 是否ajax

define('IS_AJAX',((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'xmlhttpsrequest'==strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) || isset($_REQUEST['ajax']) && $_REQUEST['ajax']=='ajax'));

//是否显示安装界面
if(!(file_exists(ROOT.'config/database.php'))){
      if(empty($_GET['s'])|| stripos($_GET['s'],'install')===false){
          $url=__MY_URL__.'index.php?s=/install/index/index';
          exit(header('location:'.$url));
      }
}