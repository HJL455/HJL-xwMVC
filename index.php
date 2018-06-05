<?php
//定义一个安全常量
define('ACCESS',TRUE);

//引入一个初始化类文件
include_once 'core\app.class.php';

//触发初始化类方法：通常定义静态资源
\Core\app::run();

?>