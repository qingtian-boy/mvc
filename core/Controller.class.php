<?php

namespace core;//创建了一个  全局空间  下的  core空间

class Controller extends \Smarty{

    //protected $smarty;

    public function __construct(){ 
        //解决父类构造方法被重写问题
        parent::__construct();

        //$this->smarty = new \Smarty;
        //$newPath = APP_ADMIN_PATH . 'view';//   mvc/app/admin/view
        $newPath = APP_PATH . $GLOBALS['plat'] . '/view';
        $this->setTemplateDir($newPath);//   设置查找后台模板文件的文件夹路径

        $newCompilePath = APP_PATH . $GLOBALS['plat'] . '/view_c';
        $this->setCompileDir($newCompilePath);//   设置存放编译缓存文件的目录路径
    }
}