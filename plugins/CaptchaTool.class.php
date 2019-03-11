<?php

namespace plugins;

/**
 * 功能：验证码操作类
 * 操作说明：
    $obj = new CaptchaTool; ===》必须首先实例化工具类的对象
    $obj->writeStr();            ===》调用该方法可以实现向画布写字，调用完成将返回写在画布上的字符串
    $obj->setPoint();            ===》调用该方法可以设置干扰点
    $obj->setLine();              ===》调用该方法可以设置干扰线
    $obj->output();               ===》调用该方法可以输出图像到浏览器
 */
class CaptchaTool{

    private $_img;//保存画布资源的非静态属性
    private $_w;//画布的宽度
    private $_h;//画布的高度

    #构造方法   初始化画布资源操作
    public function __construct($w=200, $h=80){ 
        
        //创建画布
        $this->_w = $w;
        $this->_h = $h;
        $this->_img = imagecreatetruecolor($w, $h);

        //填充背景色
        $color = $this->getColor();//调用getColor方法获得随机颜色
        imagefill($this->_img, 0, 0, $color);
    }

    #分配颜色的方法
    private function getColor($r='', $g='', $b=''){ 
        
        //  如果$r为空字符串，则说明没有传递参数，那么我们就给随机值；如果不全等于空字符串，则表示用户在调用时传递了指定的色值，那么就直接使用用户传递的色值即可
        $r = ($r==='') ? mt_rand(0, 255) : $r;
        $g = ($g==='') ? mt_rand(0, 255) : $g;
        $b = ($b==='') ? mt_rand(0, 255) : $b;

        //分配颜色
        return imagecolorallocate($this->_img, $r, $g, $b);
    }

    #构建随机字符写入画布
    public function writeStr($num=4){ 
        
        $strArr = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9));//构建随机字库

        //生成指定个数的随机字符串
        $str = '';
        for($i=0; $i<$num; $i++ ){ 
            
            $key = mt_rand(0, count($strArr)-1);
            $str .= $strArr[$key];
        }

        //往画布上写字
        $x = $this->_w/5;//文字起始点的x坐标
        $y = $this->_h*2/3;//文字起始点的y坐标
        $color = $this->getColor();//分配一个随机色
        $size = $this->_w*3/20;//字体的大小为宽度的3/20
        $fontPath = PUBLIC_PATH . 'font/font1.ttf';
        imagettftext($this->_img, $size, 0, $x, $y, $color, 'F:/home/class/day25/source/font1.ttf', $str);

        return $str;
    }

    #设置干扰点
    public function setPoint($num=300){ 
        
        for($i=0; $i<$num; $i++ ){ 
            $bx = mt_rand(0, $this->_w);//起点的x坐标
            $by = mt_rand(0, $this->_h);//起点的y坐标
            $ex = mt_rand($bx-2, $bx+2);//终点的x坐标
            $ey = mt_rand($by-2, $by+2);//终点的y坐标

            $color = $this->getColor();//分配随机色

            imageline($this->_img, $bx, $by, $ex, $ey, $color);
        }
    }

    #设置干扰线
    public function setLine($num=10){ 
        
        for($i=0; $i<$num; $i++ ){ 
            $bx = mt_rand(0, $this->_w/2);//起点的x坐标
            $by = mt_rand(0, $this->_h);//起点的y坐标
            $ex = mt_rand($this->_w/2, $this->_w);//终点的x坐标
            $ey = mt_rand(0, $this->_h);//终点的y坐标

            $color = $this->getColor();//分配随机色

            imageline($this->_img, $bx, $by, $ex, $ey, $color);
        }
    }

    #输出图像到浏览器
    public function output(){ 

        header('Content-type:image/jpeg');
        imagejpeg($this->_img);
    }
}













