<?php

namespace core;//创建了一个  全局空间  下的  core空间

class Model{

    protected $pdo;

    //构造方法
    public function __construct(){ 

        //接收配置项各项的值
        $type = $GLOBALS['config']['pdo_mysql']['type'];//数据库类型
        $host = $GLOBALS['config']['pdo_mysql']['host'];//数据库IP地址
        $port = $GLOBALS['config']['pdo_mysql']['port'];//端口号
        $char = $GLOBALS['config']['pdo_mysql']['char'];//字符集
        $dbname = $GLOBALS['config']['pdo_mysql']['dbname'];//数据库名
        $acc = $GLOBALS['config']['pdo_mysql']['acc'];//帐号
        $pwd = $GLOBALS['config']['pdo_mysql']['pwd'];//密码
       

        //连库基本操作
        //$dsn = 'mysql:host=localhost;port=3306;charset=utf8;dbname=db7';
        $dsn = "{$type}:host={$host};port={$port};charset={$char};dbname={$dbname}";
        $this->pdo = new \PDO($dsn, $acc, $pwd);

        //开启PDO异常错误处理模式
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    //设置操作（增删改）
    public function setData($sql){ 
        
        try{
            $this->pdo->exec($sql);//执行SQL语句
        }catch(\PDOException $err){
            $this->record($err);
            return false;
        }
        return true;
    }

    //查询单条数据的操作
    public function getRow($sql){ 
        
        try{//监听执行SQL语句的代码
            $pdostatement = $this->pdo->query($sql);//执行查询SQL语句
        }catch(\PDOException $err){//捕获出现的错误（异常）
            $this->record($err);//记录出错的信息到日志文件中
            return false;//返回false值
        }

        return $pdostatement->fetch(\PDO::FETCH_ASSOC);//解析得到一条数据，并将其返回
    }

    //查询多条数据的操作
    public function getRows($sql){ 
        
        try{
            $pdostatement = $this->pdo->query($sql);//执行查询SQL语句
        }catch(\PDOException $err){
            $this->record($err);
            return false;
        }

        return $pdostatement->fetchAll(\PDO::FETCH_ASSOC);//解析得到所有数据，并将其返回
    }

    //记录错误信息的方法
    protected function record($err){ 
        $str = '';
            $str .= "begin==========".date('Y-m-d H:i:s')."==========\r\n";
            $str .= "错误的编码是：" . $err->getCode() . "\r\n";
            $str .= "出错的行号：" . $err->getLine() . "行\r\n";
            $str .= "出错的文件路径：" . $err->getFile() ."\r\n";
            $str .= "错误的信息是：" . $err->getMessage() . "\r\n";
            $str .= "end===================================\r\n";
            file_put_contents('./err.log', $str, FILE_APPEND);
    }
}