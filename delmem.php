<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	if(empty($_SESSION['groupname'])){
		echo "请先登录，即将返回登录页面";
		echo "<meta http-equiv='refresh' content='2;url=group.html'>";
	}
	include("condb.php");
	connectdb("groupdb");
	$ses = $_SESSION['groupname'];
	$sql = "select author from grouptb where name = '$ses'";
	//echo "$sql";
	$result = mysql_query($sql)or die("插入mysql指令失败");
	$auth = mysql_fetch_row($result);
	//echo "auth is $auth[0]";
	mysql_close();
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Waiting...</title>
</head>
<?php
	include_once("condb.php");
	connectdb("memberdb");
	if($_POST['delall']=="全部删除"){
		$delall = $_POST['delall'];
		$sql = "truncate table {$ses}";
		mysql_query($sql) or die("删除失败");
		mysql_close();
		echo "<script>alert('全部删除成功！o(*￣▽￣*)ブ');</script>";
		echo "<script>history.go(-1);</script>";
		
	}
	else{
		$checkbox = $_POST['checkbox'];
		for($i=0;$i<=count($checkbox);$i++){
			if(!is_null($checkbox[$i])){
				$chechvalue=$checkbox[$i];
				//print_r($checkbox[$i]);
				$sql = "delete from {$ses} where id={$checkbox[$i]}";
				//echo "$sql";
				mysql_query($sql);
			}
			else{
				mysql_close();
				break;
			}
		}
		if($i==0){
			echo "<script>alert('请至少选择一项！');</script>";
			echo "<script>history.go(-1);</script>";
		}
		else{
			echo "<script>alert('删除成功！o(*￣▽￣*)ブ');</script>";
			echo "<script>history.go(-1);</script>";
		}
	}
	
	
?>
<body>
</body>
</html>
<?php
	endif
?>