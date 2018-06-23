<?php
//命名空间
namespace home\controller;
use Core\model;
use Core\controllers;

//use home\model\usermodel;
//权限判定，如果不是从index入口文件进入，让页面直接跳转到index页面
if(!defined('ACCESS'))header('Location:../index.php');

//index就是一个控制器
class index extends controllers{
	//就是一个方法
	function index(){
		$error = new \Core\controllers();
		//var_dump($error);die;
		//$error->error();
		//执行成功
		//$this->success('p=home&m=index&a=getuser');
		//执行失败
		 $this->error('p=home&m=index&a=getuser','id不能为空');
        echo '<br/>执行代码';
	}

	//获取用户信息
	function getUser(){

		$usermodel = new \home\model\usermodel();
		$userinfo = $usermodel->selsect_none_user();
		$insert=array('id'=>3,'name'=>'王五','age'=>30);
		var_dump($usermodel->dao->insert('user',array('id'=>3,'name'=>'王五','age'=>30)));
		echo "<br/>";
		//实例化视图类
		//$view = new \Core\view();
		$view = new \Smarty();
		$view->assign('id', $userinfo['id']);
		$view->assign('name', $userinfo['name']);
		$view->assign('age', $userinfo['age']);

		//显示数据
		$view->display('./app/home/view/index.html');//smarty方式
		//$view->display('index.html');
		//通过视图去显示数据
		//include_once 'app/home/view/index.html';
		
	}
} 


?>