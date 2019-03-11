<?php

namespace home\controller;
use \core\Controller;

class TestController extends Controller{

    public function test(){ 
        
        $testModel = M('TestModel');
        echo '测试得到模型类的对象：<br/>'; 
        var_dump( $testModel ); 
        if( is_object($testModel) ){
            echo '<br/> ===> <span style="color:green;">获得测试模型类的对象成功！</span>'; 
        }
        echo '<hr/>';
        echo '测试获得完整验证码图片：<br/><img src="'.C('domain.main').'/index.php?p=home&m=test&a=getImg" /><br/>'; 
        echo '测试获得无干扰线验证码图片：<br/><img src="'.C('domain.main').'/index.php?p=home&m=test&a=getImg&type=1" /><br/>'; 
        echo '<hr/>';
        echo '以上效果无误，项目部署成功！'; 
    }

    public function getImg(){ 
        $catpchaTool = M('CaptchaTool');
        $catpchaTool->writeStr();
        $catpchaTool->setPoint();
        if( !isset($_GET['type']) ){
            $catpchaTool->setLine();
        }
        $catpchaTool->output();
    }
}