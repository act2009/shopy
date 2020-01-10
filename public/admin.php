<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/10
 * Time: 16:55
 */

/**
 * 后台入口文件
 */

namespace think;

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';
// 支持事先使用静态方法设置Request对象和Config对象

//引用公共入口文件
require __DIR__.'/core.php';

// 执行应用并响应
Container::get('app')->bind('admin')->run()->send();
 