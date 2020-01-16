<?php
/**
 * Created by PhpStorm.
 * User: act2009
 * Date: 2020/1/15
 * Time: 11:19
 */
/**
 * 配置文件
 */

return [

    //附件host, 数据库图片地址以/static/...开头
    'attachment_host'=> defined('__MY_PUBLIC_URL__')? substr(__MY_PUBLIC_URL__,'0','-1') : '' ,
];