<?php

/**
 * 功能：获取对象函数
 * @param  $className  string   需要获取对象的类名，模型和工具类可以不携带命名空间，例子：$obj = M('NewsModel');
 */
function M($className){ 
    
    if( strpos($className, 'model')===false && substr($className, -5)=='Model' ){

        //                   \model\NewsModel
        $className = '\model\\' . $className;
        
    }elseif( strpos($className, 'plugins')===false && substr($className, -4)=='Tool' ){

        $className = '\plugins\\' . $className;

    }

    $obj = \core\App::single($className);
    return $obj;
}

/**
 *  功能：读取配置参数值函数
 * @param  $str  string    表示配置项的下标字符串，例：我需要读取配置项中的主域名参数的值，则使用C('domain.main')即可获得
 */
function C($str){ 
    
    $arr = explode('.', $str);
    $config = $GLOBALS['config'];
    
    foreach( $arr as $v ){ 
        
        $config = $config[$v];
    }

    return $config;
}

/**
 *  功能：文件上传功能函数
 * @param  $file                    array       包含五个部分信息的形参变量，
            $file['name']              string      上传文件的原文件名，例：$file['name']='a.jpg';
            $file['type']                string      上传文件的格式类型，例：$file['type']='image/jpeg';
            $file['tmp_name']      string      存储在临时目录下的文件全路径，例：$file['type']='C:/Windows/Temp/xx.tmp';
            $file['error']               int          上传时出现的错误码值，例：$file['error']=0;
                                错误码值：   
                                        0     表示没有错误
                                        1     文件上传的大小超出了系统配置文件的限制大小
                                        2     文件上传的大小超过了浏览器的限制
                                        3     文件没有完全上传完
                                        4     用户没有选择需要上传的文件
                                        6     找不到临时目录
                                        7     文件写入服务器失败
            $file['size']                 int           文件的大小，单位字节，例：$file['size']=1234567;
 */
function upFile($file){ 
    
    #检查系统错误
    switch ( $file['error'] ){
        case 1:
            echo '文件上传的大小超出了系统配置文件的限制大小～'; 
        return false;
        case 2:
            echo '文件上传的大小超过了浏览器的限制！'; 
        return false;
        case 3:
            echo '文件没有完全上传完！'; 
        return false;
        case 4:
            echo '用户没有选择需要上传的文件哟～'; 
        return false;
        case 6:
            case 7:
            echo '服务器繁忙，请客官稍候再试～'; 
        return false;
    }

    #检查逻辑错误
    //检查格式类型是否符合要求
    $limitType = ['image/jpeg', 'image/png'];//定义出允许的格式类型
    if( !in_array($file['type'], $limitType) ){//如果上传的文件格式类型不在允许的范围内，则给出提示信息，并且中止函数的执行
        echo '您上传的文件格式类型不符合要求，只能上传' . implode('或', $limitType) . '格式的文件'; 
        return false;
    }

    //检查文件的大小是否符合逻辑要求
    $limitSize = 250 * 1024;//限定的大小为250KB
    if( $file['size']>$limitSize ){//如果上传的文件大小超过了限定的大小，则给出提示，并且中止函数的执行
        echo '您上传的文件超过' . ($limitSize/1024) . 'KB的大小，请重新选择上传的文件！'; 
        return false;
    }

    #构建绝对不重复的文件名
    $fileName = uniqid('img_') . date('YmdHis') . '_' . mt_rand(0, 10000) . strstr($file['name'], '.');
    $path = 'public/admin/upload/';
    $wholeFileName = $path . $fileName;

    #转移文件到指定目录
    $re = move_uploaded_file($file['tmp_name'], $wholeFileName);

    if( $re ){//上传成功
        //echo '恭喜你，文件上传成功';
        return $wholeFileName;
    }else{//上传失败
        //echo '系统繁忙，请稍候再试！'; 
        return false;
    }
}


