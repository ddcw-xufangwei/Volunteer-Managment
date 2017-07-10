<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<?php
	session_start();
	$ses = $_SESSION['groupname'];
	//print_r ($_SESSION['author']);
	if($_SESSION['groupname'] == NULL){
		echo "请先登录，即将返回登录页面";
		echo "<meta http-equiv='refresh' content='2;url=welcome.html'>";
	}
	else{
		include("condb.php");
		if($_SESSION['author'] == 1){
			connectdb("groupdb");
			$sql = "select author from grouptb where name = '$ses'";
			//echo "$sql";
			$result = mysql_query($sql)or die("插入mysql指令失败");
			$auth = mysql_fetch_row($result);
			//echo "auth is $auth[0]";
			mysql_close();
		}
		elseif($_SESSION['author'] == 2){
			connectdb("memberdb");
			$sql = "select author from $ses where name='{$_SESSION['usrname']}'";
			//echo "$sql";
			$result = mysql_query($sql) or die("cuowu");
			$auth = mysql_fetch_row($result);
			//print_r ($auth);
			mysql_close();
		}
		elseif($_SESSION['author'] == 3){
			connectdb("groupdb");
			$sql = "select author from grouptb where name = '$ses'";
			//echo "$sql";
			$result = mysql_query($sql)or die("插入mysql指令失败");
			$auth = mysql_fetch_row($result);
			//echo "auth is $auth[0]";
			mysql_close();
		}
	}

?>