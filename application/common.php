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
        //数字存在即验证
        //字符存在即验证

        if(isset($v['is_checked'])){
            if($v['is_checked']==1){
                if(empty($data[$v['key_name']])){
                    $is_checked=false;
                }
            }elseif ($v['is_checked']==2){
                if(!isset($data[$v['key_name']])){
                    $is_checked=false;
                }
            }
        }
        // 是否需要验证
        if($v['is_checked']===false){
            continue;
        }

        // 数据类型,默认字符串类型
        $data_type=empty($v['data_type'])? 'string': $v['data_type'];
        // 验证规则，默认isset
        $checked_type=isset($v['checked_type'])? $v['checked_type'] : 'isset';

        switch ($checked_type){
            //是否存在
            case 'isset':
                if(!isset($data[$v['key_name']])){
                    return $v['error_msg'];
                }
                break;
               //是否为空
            case 'empty':
                if(empty($data[$v['key_name']])){
                    return $v['error_msg'];
                }
                break;
            // 是否存在于验证数组中
            case 'in' :
                if(empty($v['checked_data']) || !is_array($v['checked_data']))
                {
                    return '内部调用参数配置有误';
                }
                if(!isset($data[$v['key_name']]) || !in_array($data[$v['key_name']], $v['checked_data']))
                {
                    return $v['error_msg'];
                }
                break;

            // 是否为数组
            case 'is_array' :
                if(!isset($data[$v['key_name']]) || !is_array($data[$v['key_name']]))
                {
                    return $v['error_msg'];
                }
                break;

            // 长度
            case 'length' :
                if(!isset($v['checked_data']))
                {
                    return '长度规则值未定义';
                }
                if(!is_string($v['checked_data']))
                {
                    return '内部调用参数配置有误';
                }
                if(!isset($data[$v['key_name']]))
                {
                    return $v['error_msg'];
                }
                if($data_type == 'array')
                {
                    $length = count($data[$v['key_name']]);
                } else {
                    $length = mb_strlen($data[$v['key_name']], 'utf-8');
                }
                $rule = explode(',', $v['checked_data']);
                if(count($rule) == 1)
                {
                    if($length > intval($rule[0]))
                    {
                        return $v['error_msg'];
                    }
                } else {
                    if($length < intval($rule[0]) || $length > intval($rule[1]))
                    {
                        return $v['error_msg'];
                    }
                }
                break;

            // 自定义函数
            case 'fun' :
                if(empty($v['checked_data']) || !function_exists($v['checked_data']))
                {
                    return '验证函数为空或函数未定义';
                }
                $fun = $v['checked_data'];
                if(!isset($data[$v['key_name']]) || !$fun($data[$v['key_name']]))
                {
                    return $v['error_msg'];
                }
                break;

            // 最小
            case 'min' :
                if(!isset($v['checked_data']))
                {
                    return '验证最小值未定义';
                }
                if(!isset($data[$v['key_name']]) || $data[$v['key_name']] < $v['checked_data'])
                {
                    return $v['error_msg'];
                }
                break;

            // 最大
            case 'max' :
                if(!isset($v['checked_data']))
                {
                    return '验证最大值未定义';
                }
                if(!isset($data[$v['key_name']]) || $data[$v['key_name']] > $v['checked_data'])
                {
                    return $v['error_msg'];
                }
                break;

            // 相等
            case 'eq' :
                if(!isset($v['checked_data']))
                {
                    return '验证相等未定义';
                }
                if(!isset($data[$v['key_name']]) || $data[$v['key_name']] == $v['checked_data'])
                {
                    return $v['error_msg'];
                }
                break;

            // 数据库唯一
            case 'unique' :
                if(!isset($v['checked_data']))
                {
                    return '验证唯一表参数未定义';
                }
                if(empty($data[$v['key_name']]))
                {
                    return $v['error_msg'];
                }
                $temp = db($v['checked_data'])->where([$v['key_name']=>$data[$v['key_name']]])->find();
                if(!empty($temp))
                {
                    return $v['error_msg'];
                }
                break;


        }


    }


    return true;

}