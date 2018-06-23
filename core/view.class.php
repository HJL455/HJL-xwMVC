<?php
//公共视图类
namespace Core;
if(!defined('ACCESS'))header('Location:../index.php');

//视图类
class view{
	protected $data=array();
	//公共的方法赋值保存数据
	function assign($name,$value){
		$this->data[$name]=$value;
	}

	//替换显示数据
	function display($tpl){
		//$tpl代表视图的文件名称
		//取出对应的html代码
		$string = file_get_contents(DIR_APP.'/'.PLAT.'/view/'.$tpl);
		//var_dump($this->data);
		//var_dump($string);
		foreach ($this->data as $key => $value) {
			//替换函数
			$string = str_replace('{$'.$key.'}', $value, $string);
			//echo $value;
		}
		echo $string;
	}


}

?>