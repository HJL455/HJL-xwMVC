<?php
//命名空间
namespace Core;

//权限判定，如果不是从index入口文件进入,让页面直接跳转到indexyemian
if(!defined('ACCESS'))header('Location:../index.php');

//定义一个初始化类文件
class app{
	
	
	//3.设置一个字符集
	private static function initCharset(){
		header("Content-type:text/html;Charset=utf-8");

	}

	//4.添加目录常量
	private static function initDirConst(){
		//1.定义目录常量  使用str_replace将\转换成/（两个\\有一个是转意）为了兼容linux操作系统
		//DIR_ROOT D:/git_repository/HJL-xwMVC/
		//__DIR__  D:/git_repository/HJL-xwMVC/core
		define('DIR_ROOT',str_replace('core/','',str_replace('\\','/',__DIR__).'/'));
		//2.定义配置文件目录常量
		define('DIR_CONFIG',DIR_ROOT.'config');
		//3.定义一个控制器文件目录
		define('DIR_APP',DIR_ROOT.'app');
		//4.定义一个核心文件
		define('DIR_CORE',DIR_ROOT.'core');
		//5.定义一个模型文件目录
		define('DIR_MODEL',DIR_ROOT.'model');
		//6.定义一个视图文件目录
		define('DIR_VENDOR',DIR_ROOT.'vendor');
		//7.定义一个公共文件目录
		define('DIR_PUBLIC','public');
	}

	//5.初始化系统设置
	private static function initSystem(){
		//错误输出
		ini_set('error_reporting', E_ALL);//错误控制级别
		ini_set('display_errors',1);//是否显示错误
	}

	//6.设定配置文件
	private static function initConfig(){
		//设置全局变量
		global $config;
		$config = include_once DIR_CONFIG.'/config.php';
		//echo $config;
	}

	//7.初始化url：我们需要通过url获取三个参数。平台，控制器，方法。
	//http://www.mvc.com/index.php?p=home&m=index&a=index 如果是表单post
	private static function initUrl(){
		//获取url里面的参数
		$plat   = isset($_REQUEST['p'])?$_REQUEST['p']:'home';
		$module = isset($_REQUEST['m'])?$_REQUEST['m']:'index';
		$action = isset($_REQUEST['a'])?$_REQUEST['a']:'index';
		//将这几个内容定义成一个常量，全局变量每一次都需要引入，比较麻烦。
		define('PLAT', $plat);
		define('MODULE', $module);
		define('ACTION', $action);
	}

	//8.设定自动加载机制
	private static function initAutoload(){
		//1.当实例化一个类的时候，找不到这个类文件，会自动触发这个函数。
		//2.只能传入一个参数。数组的第一个元素是类名，第二个元素是方法名
		//3.当没有这个类的时候会去触发initAutoConfig的方法
		//4.1加载spl_autoload_register函数的时候，应该按照调用次数最多的类放前面
		//4.2因为如果找到了类就不会继续往下面执行spl_autoload_register函数了
		spl_autoload_register(array(__CLASS__,'initAutoController'));
		spl_autoload_register(array(__CLASS__,'initAutoConfig'));
		spl_autoload_register(array(__CLASS__,'initAutoCore'));
		spl_autoload_register(array(__CLASS__,'initAutoModel'));
		spl_autoload_register(array(__CLASS__,'vendorVendor'));  
	}

	//加载config的某个类文件
	private static function initAutoConfig($classname){
		$file = DIR_CONFIG.'/'.basename($classname).'.class.php';
		if(is_file($file))include_once $file;
	}

	//加载controller的某个文件
	private static function initAutoController($classname){
		$file = DIR_APP.'/'.PLAT.'/controller/'.basename($classname).'.class.php';
		if(is_file($file))include_once $file;
	}

	//加载core的某个文件
	private static function initAutoCore($classname){
		$file = DIR_CORE.'/'.basename($classname).'.class.php';
		if(is_file($file))include_once $file;
	}

 	//加载model的某个类文件
    private static function initAutoModel($classname){
       $file=  DIR_APP.'/'.PLAT.'/model/'.basename($classname).'.class.php';
       if(is_file($file))include_once $file;
    }

    //加载vendor的某个类文件
    private static function vendorVendor($classname){
       $file= DIR_VENDOR.'/'.$classname.'/'.basename($classname).'.class.php';
       if(is_file($file))include_once $file;
    }

	//9.分发控制器
	private static function initDirPatch(){
		//获取控制器
		$module = MODULE;
		//获取方法
		$action = ACTION;
		//命名空间问题 使用完全访问模式
		$module = '\\'.PLAT.'\\controller\\'.$module;
		//实例化类
		$m = new $module();
		//调用方法
		$m->$action();
	}

	//run的方法来调用
	public static function run(){
	   self::initCharset(); 
       self::initDirConst();
       self::initSystem();
       self::initConfig();
       self::initUrl();
       self::initAutoload();
       self::initDirPatch();


	}

}
?>