<?php
//命名空间
namespace home\model;
use Core\model;

class usermodel extends model{
    protected $table = 'user';

	function index(){
		echo "cvbn";
	}
	function selsect_none_user(){
        //连认证
        //组织拼接sql语句
        //执行slq
        //获取数据解析结果
        //返回数据
        return array('id'=>1,'name'=>'张三','age'=>17);
    }
}


?>