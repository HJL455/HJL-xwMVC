<?php
namespace Core;
//引入pdo
use PDO;
use PDOException;
use PDOStatement;

//使用pdo连接数据库 封装增删改查
class DBdao{

	//定义私有属性
	private $host;
	private $port;
	private $username;
	private $password;
	private $dbname;
	private $charset;
	private $dbtype;
	private $pdo;

	//定义构造函数自动加载配置文件
	function __construct(){
		//加载配置文件
		global $config;
		$db_config = $config['db'];
		//给属性赋值
		$this->dbtype = $db_config['db'];
		$this->host = $db_config['host'];
		$this->username = $db_config['username'];
		$this->password = $db_config['password'];
		$this->charset = $db_config['charset'];
		$this->port = $db_config['port'];
		$this->dbname = $db_config['dbname'];

		//pdo连接数据库
		$this->pdo = new PDO("$this->dbtype:host=$this->host;dbname=$this->dbname","$this->username","$this->password");
		//发送编码
       $this->pdo->query("set names {$this->charset}");

	}

	/**
     *   定义执行查询sql语句的方法
     *   参数：查询sql语句
     *   返回：二维关联数组
	 */
	public function query($sql){
		$res = $this->pdo->query($sql);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $res->fetchAll();
        return $arr;
	}



	/**
	 *	 查询一行记录的方法
	 *	 参数：表明  条件(不包含where)
	 *	 返回：一维关联数组
	 */
	public function getRow($tablename,$where){
        //组装sql语句
        $sql = "select * from $tablename where $where";
        //查询
        $res = $this->pdo->query($sql);
        $res->setFetchMode(PDO::FETCH_ASSOC);
        $arr = $res->fetch();
        return $arr;
    }

    /**
	 *	查询全部记录
	 *	参数：表名
	 *  返回：二维关联数组
     */
    public function getAll($tablename){
    	//echo $tablename;
    	$res = $this->pdo->query("select * from $tablename");
    	$res->setFetchMode(PDO::FETCH_ASSOC);
    	$arr = $res->fetchAll();
    	return $arr;
    }

    /**
	 *	查询某个字段
	 *	参数：字段名（多个的话用逗号隔开）表名 条件（不含where）
	 *	返回：二维关联数组
     */
    public function getOne($column,$tablename,$where='1'){
    	//拼接sql语句
    	$sql = "select $column from $tablename where $where";
    	$res = $this->pdo->query($sql);
    	$res->setFetchMode(PDO::FETCH_ASSOC);
    	//$col = $res->fetchColumn();
    	$col = $res->fetchAll();
    	return $col;
    }

    /**
	 *	查询最后一次插入的数据
	 *	参数：表名
	 *  返回：数组
     */
    public function getLastone($tablename){
    	$sql = "select * from $tablename where id=(select max(id) from $tablename)";
    	$res = $this->pdo->query($sql);
    	$res->setFetchMode(PDO::FETCH_ASSOC);
    	$arr = $res->fetch();
    	return $arr;
    }

    /**
	 *  向数据库中添加一条信息
	 *	参数：表名  一维关联数组
	 *	返回：布尔值
     */
    public function insert($tablename,$arr){
    	//拿到数组之后先处理数组   过滤字段
    	//取出表中的字段
    	$sql = "select COLUMN_NAME from information_schema.COLUMNS where table_name = '$tablename' and table_schema ='$this->dbname'";
    	//echo $sql
    	$columns = $this->pdo->query($sql);
    	$columns->setFetchMode(PDO::FETCH_ASSOC);
    	$columns = $columns->fetchAll();
    	$cols = array();//储存表中的全部字段
    	foreach ($columns as $key => $value) {
    		$cols[] = $value['COLUMN_NAME'];
    	}
    	//将要入库的数组进行键值分离
    	$keys = array();
    	$values = '';
    	foreach($arr as $k=>$v){
    		if (!in_array($k, $cols)) {
    			unset($arr[$k]);
    		}else{
    			$keys[] = $k;
    			$values .= "'".$v."',";
    		}
    	}
    	$column = implode(',', $keys);
    	$values = substr($values,0, -1);

    	//拼凑sql语句
    	$sql = "insert into $tablename($column) values ($values)";
    	$res = $this->pdo->exec($sql);
    	return $res;
    }
}


?>