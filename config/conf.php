<?php

$config = [

    #网站域名配置
    'domain' => [
        'main' => 'http://www.home.com/class/day25/code/mvc'//网站主域名
    ],
    
    #网站默认访问的页面
    'web' => [
        'p' => 'home',//平台参数
        'm' => 'Test',//模块参数
        'a' => 'test'//动作参数
    ],

    #PDO操作MYSQL数据库相关参数
    'pdo_mysql' => [
        'type' => 'mysql',//数据库类型
        'host' => 'localhost',//IP地址
        'port' => '3306',//端口号
        'char' => 'utf8',//字符集
        'dbname' => 'db7',//数据库名
        'acc' => 'root',//帐号
        'pwd' => '123abc'//密码
    ]
];