<?php

//定义路径常量
//define('ROOT', dirname(__FILE__) . '/');//根目录    mvc/config
define('ROOT', dirname(dirname(__FILE__)) . '/');//根目录    mvc/

define('APP_PATH', ROOT . 'app/');// mvc/app/

define('APP_ADMIN_PATH', APP_PATH . 'admin/');//   mvc/app/admin/
define('APP_MODEL_PATH', APP_PATH . 'model/');//   mvc/app/model/
define('APP_HOME_PATH', APP_PATH . 'home/');//   mvc/app/home/

define('APP_ADMIN_CONTR_PATH', APP_ADMIN_PATH . 'controller/');//   mvc/app/admin/controller/
define('APP_ADMIN_VIEW_PATH', APP_ADMIN_PATH . 'view/');//   mvc/app/admin/view/

define('APP_HOME_VIEW_PATH', APP_HOME_PATH . 'view/');//   mvc/app/home/view/

define('CONFIG_PATH', ROOT . 'config/');// mvc/config/
define('CORE_PATH', ROOT . 'core/');// mvc/core/
define('PLUGINS_PATH', ROOT . 'plugins/');// mvc/plugins/
define('PUBLIC_PATH', ROOT . 'public/');// mvc/public/