<?php

namespace core;//创建了一个  全局空间  下的  core空间

class App{

    private static $obj=[];//存储实例化对象的属性

    //第一次                           \admin\controller\NewsController
    //第二次                           \admin\controller\UserController
    //第三次                           \admin\controller\NewsController
    //第四次                           \admin\controller\UserController
    public static function single($className){ //生产单例对象的方法

        //第一次     self::$obj['\admin\controller\NewsController']
        //第二次     self::$obj['\admin\controller\UserController']
        //第三次     self::$obj['\admin\controller\NewsController']
        //第四次     self::$obj['\admin\controller\UserController']
        if( empty(self::$obj[$className]) ){
         //第一次 self::$obj['\admin\controller\NewsController'] = new \admin\controller\NewsController
         //第二次 self::$obj['\admin\controller\UserController'] = new \admin\controller\UserController
            self::$obj[$className] = new $className;
        }

        //第一次   self::$obj['\admin\controller\NewsController']
        //第二次   self::$obj['\admin\controller\UserController']
        //第三次   self::$obj['\admin\controller\NewsController']
        //第四次   self::$obj['\admin\controller\UserController']
        return self::$obj[$className];
    }
    
    //自动加载的静态方法               \model\NewsModel
    //                                 \admin\controller\NewsController
    public static function autoload($className){ 

        //  NewsModel
        $oriClassName = basename($className);

        //if( substr($oriClassName, -5)=='Model' ){//针对模型类
            ////          mvc/app/model/NewsModel.class.php
            //include APP_MODEL_PATH . $oriClassName . '.class.php';
        //}

        if( $oriClassName=='Model' ){//整个完整的类名等于Model，说明这个类是父类模型
            //           mvc/core/    Model.class.php
            include CORE_PATH . 'Model.class.php';
        }elseif( substr($oriClassName, -5)=='Model' ){//针对模型类
            //          mvc/app/model/NewsModel.class.php
            include APP_MODEL_PATH . $oriClassName . '.class.php';
        }elseif( substr($oriClassName, -10)=='Controller' ){//针对控制器类的，只要末尾10个字符是Controller，则这个类一定是一个控制器类
        
            //            mvc/app/      admin                /controller/       NewsController .class.php
            $path = APP_PATH . $GLOBALS['plat'] . '/controller/' . $oriClassName . '.class.php';
            include $path;
        }elseif( substr($className, -4)=='Tool' ){
        
            $str = str_replace('\\', '/', $className);
            $filePath = ROOT . $str . '.class.php';
            include $filePath;
        }
    }

    //启动方法
    public static function run(){ 
        //构建动作参数    判断是否存在GET传递的a参数，如果存在则使用存在的，如果不存在则使用默认值
        //$action = isset($_GET['a']) ? $_GET['a'] : 'showList';
        //$action = isset($_GET['a']) ? $_GET['a'] : $config['web']['a'];
        $GLOBALS['action'] = $action = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['web']['a'];

        //构建模块参数   判断是否存在GET传递的m参数，如果存在则使用存在的，如果不存在则使用默认值
        //$module = isset($_GET['m']) ? ucfirst($_GET['m']) : 'News';
        //$module = isset($_GET['m']) ? ucfirst($_GET['m']) : $config['web']['m'];
        $GLOBALS['module'] = $module = isset($_GET['m']) ? ucfirst($_GET['m']) : $GLOBALS['config']['web']['m'];

        //构建平台参数   判断是否存在GET传递的m参数，如果存在则使用存在的，如果不存在则使用默认值
        //$plat = isset($_GET['p']) ? $_GET['p'] : 'admin';
        //$plat = isset($_GET['p']) ? $_GET['p'] : $config['web']['p'];
        $GLOBALS['plat'] = $plat = isset($_GET['p']) ? $_GET['p'] : $GLOBALS['config']['web']['p'];

        //实例化控制器类的对象
        //$obj = new NewsController;
        //$obj = new \admin\controller\NewsController;

        //$className = '\\admin\\controller\\' . $module . 'Controller';
        //                     \admin\controller\NewsController
        $className = '\\' . $plat . '\\controller\\' . $module . 'Controller';
        //$obj = App::single($className);
        $obj = \core\App::single($className);

        /* 测试代码
        $obj1 = App::single('\admin\controller\NewsController');
        //var_dump( $obj1 ); echo '<hr/>';
        $obj2 = App::single('\admin\controller\UserController');
        //var_dump( $obj2 ); echo '<hr/>';
        $obj3 = App::single('\admin\controller\NewsController');
        //var_dump( $obj3 ); echo '<hr/>';
        $obj4 = App::single('\admin\controller\UserController');
        //var_dump( $obj4 ); echo '<hr/>';
        exit;
        */

        //展示列表页
        //$obj->showList();
        //展示添加页
        //$obj->showAd();
        //展示编辑页
        //$obj->showUpd();

        $obj->$action();//$obj->showList();
    }
}