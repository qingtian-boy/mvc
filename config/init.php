<?php

//引入定义常量的文件
include './config/define.php';

//引入项目主配置文件
include CONFIG_PATH . 'conf.php';

//引入项目主配置文件
include CONFIG_PATH . 'func.php';

//引入SMARTY3.0核心类文件
include PLUGINS_PATH . 'smarty/Smarty.class.php';

//引入 核心框架类
include CORE_PATH . 'App.class.php';
//注册自动加载
//spl_autoload_register('App::autoload');
spl_autoload_register('\core\App::autoload');
//引入父类模型（基础模型类）文件
//include CORE_PATH . 'Model.class.php';
//引入模型类文件
//include APP_MODEL_PATH . 'NewsModel.class.php';
//引入父类控制器（基础控制器类）文件
include CORE_PATH . 'Controller.class.php';
//引入控制器类文件
//include './app/admin/controller/NewsController.class.php';
//include APP_ADMIN_CONTR_PATH . 'NewsController.class.php';
//include './app/home/controller/IndexController.class.php';