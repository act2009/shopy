<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * @note:生成当前脚本
 * @author:{act2009}
 * @time:2020/1/15
 * @params:NULL
 */
function CurrentScriptName(){
    $name='';
    if(empty($_SERVER['SCRIPT_NAME'])){
        if(empty($_SERVER['PHP_SELF'])){
            if(!empty($_SERVER['SCRIPT_FILENAME'])){
                $name=$_SERVER['SCRIPT_FILENAME'];
            }

        }else{
            $name=$_SERVER['PHP_SELF'];
        }

    }else{
        $name=$_SERVER['SCRIPT_NAME'];
    }

    if(!empty($name)){
        $loc=strripos($name,'/');
        if($loc !==false){
            $name=substr($name,$loc+1);
        }
    }
    return $name;
}







/**
 * @note:生成自定义url
 * @author:{act2009}
 * @time:2020/1/15
 * @params:string path 路径地址
 * @params:array params 参数
 */
function MyUrl($path,$parmas=[]){

    $url=url($path,$parmas,true,true);
    //是否根目录访问
    if (defined('IS_ROOT_ACCESS')){
       $url=str_replace('public/','',$url);
    }
    //是否存在https
    if(__MY_HTTP__=='https' && substr($url,0,5)!=='https'){
        $url=mb_substr($url,4,null,'utf-8');
    }

    //避免从后台生成url错误
    $script_name=CurrentScriptName();
    if($script_name!=='index.php' &&substr($script_name,0,6)!=='admin/'){
        $url=str_replace($script_name,'index.php',$url);
    }


}

/**
 * @note:参数校验
 * @author:{act2009}
 * @time:2020/1/16
 * @params:$data  原始数据
 * @params:$params 校验数据
 */
function ParamsChecked($data,$params){

    if(empty($data) ||!is_array($data) || !is_array($params)){
        return '内部调用参数配置有误';
    }
    foreach ($params as $v){
        if(empty($v['key_name']) || empty($v['error_msg'])){
            return '内部调用参数配置有误';
        }
        //是否需要验证
        $is_checked=true;
        //数字或字段需要验证


    }


    return true;

}