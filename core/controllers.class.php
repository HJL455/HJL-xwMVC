<?php
//公共控制器
//命名空间
namespace Core;
if(!defined('ACCESS'))header('Location:../index.php');
//公共控制器
class controllers{
	//代码执行成功跳转
	function success($url='',$time='1'){
		header("Refresh:{$time};url=index.php?{$url}");//可进行页面跳转
		die("执行成功；等待{$time}秒自动跳转{$url}");//终止代码
	}

	//代码执行失败跳转
	function error($url='',$msg='',$time='4'){
		header("Refresh:{$time};url=index.php?{$url}");//可进行页面跳转
		if(!empty($msg))echo '提示信息：'.$msg;
		die("执行失败；等待{$time}秒自动跳转{$url}");//终止代码
	}
}



?>