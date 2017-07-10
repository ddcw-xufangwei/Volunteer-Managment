<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Waiting...</title>
</head>
<?php
	if(isset($_POST["registing"]) && $_POST["registing"] == "注册"){
		$usr = $_POST["username"];
		$psw = $_POST["password"];
		$pwsure = $_POST["pwsure"];
		
		include("condb.php");
		connectdb("groupdb");
		$sql = "select name from grouptb where name='{$usr}'";
		$rst = mysql_query($sql) or die("查询ysql指令失败");
		$row = mysql_num_rows($rst);
		//echo "$row";
		if($row != 0){
			echo "<script>alert('用户已经注册，请直接进行登陆（￣Ｑ￣）╯');</script>";
			echo "<meta http-equiv='refresh' content='0;url=group.html'>";
		}
		else{
			if($usr == "" || $psw == "" || $pwsure ==""){
				echo "<script>alert('请完整填写！ (╯°Д°)╯︵ ┻━┻');</script>";
				echo "<meta http-equiv='refresh' content='0;url=grouprg.php'>";	
			}
			else{
				if(strcmp($psw,$pwsure)==0){
					$sql = "insert into grouptb(name, password, author) values('$usr', '$psw', '1')";
					$rst = mysql_query($sql)or die("插入mysql指令失败");
					
					echo "<script>alert('注册成功！( •̀ ω •́ )y');</script>";
					echo "<meta http-equiv='refresh' content='0;url=group.html'>";	

				}
				else{
					echo "<script>alert('两次密码输入不一致(￣▽￣)\"！');</script>";
					echo "<script>history.go(-1);</script>";
				}
			}
		}
			
		mysql_close();
	}
	else{
		echo "<script>alert('提交失败！( •̀ ω •́ )y');</script>";
		echo "<meta http-equiv='refresh' content='0;url=grouprg.php'>";	
	}
?>
