<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Waiting...</title>
</head>

<?php
	session_start();
	if(isset($_POST["memsub"]) & $_POST["memsub"] == "确认"){
		$name = $_POST["name"];
		$code = $_POST["code"];
		$classes = $_POST["classes"];
		$tel = $_POST["tel"]?$_POST["tel"]:"NULL";
		$QQ = $_POST["QQ"]?$_POST["QQ"]:"NULL";
		$password = "123456";
		$author = 2;
		$groupname = $_SESSION["groupname"];
		if($name==NULL||$code==""||$classes==""){
			echo "<script>alert('请正确填写必填项目( ▼-▼ )');</script>";
			echo "<script>history.go(-1);</script>";
		}
		else{
			include("condb.php");
			connectdb("memberdb");
			$sql = "create table if not exists {$groupname} like demo";
			$rst = mysql_query($sql);
			$sql = "select code from $groupname where code={$code}";
			//echo $sql;
			$rst = mysql_query($sql);
			if(mysql_num_rows($rst) == 0){
				$sql = "insert into {$groupname}(name,code,classes,groupname,author,tel,password,QQ) values('{$name}',{$code},{$classes},'{$groupname}',{$author},{$tel},'{$password}',{$QQ})";
				//echo "$sql";
				$rst = mysql_query($sql) or die("输入不合法，请返回重新输入");
				echo "<script>alert('成功！（￣▽￣）～■□～（￣▽￣）');</script>";
				echo "<script>history.back(-1);</script>";
			}
			else{
				echo "<script>alert('已经存在该名组员( ▼-▼ )');</script>";
				echo "<script>history.back(-1);</script>";
			}
		}
	}
?>

<body>
</body>
</html>