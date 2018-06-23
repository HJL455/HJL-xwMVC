<?php
#功能模型类
//命名空间
namespace Core;
use \Core\DBdao;
//权限判定，如果不是从index入口,让页面直接跳转到index页面
if(!defined('ACCESS'))header('Location:../index.php');

//公共模型类
class model{
	//protected $link;
	public $dao;
	//连接数据库操作，使用构造方法解决
	function __construct(){
		$this->dao = new DBdao();
		//$link = mysqli_connect('localhost','root','root','mysql') or die('连接失败');
		//$this->link=$link;
		//echo "数据库连接成功<br/>";
	}


	//通过一个id获得一张表的数据
	function getTableIdData($id){
		//连接认证
		$sql = "select * from {$this->table} where id={$id}";
		echo $sql;
		//执行sql
		//获取数据解析结果
		//返回数据
		return array('id'=>1,'name'=>'张三','age'=>19);
	}
}


?>