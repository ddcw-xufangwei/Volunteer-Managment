<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<sessionState cookieless="AutoDetect" mode="StateServer" stateConnectionString="tcpip=127.0.0.1:42424" stateNetworkTimeout="20" timeout="20"/>
<title>Waiting...</title>
</head>
<?php
	include("condb.php");
	if(isset($_POST["submit"]) && $_POST["submit"] == "登录"){
			$groupname = $_POST["groupname"];
			$psw = $_POST["password"];
			$authorize = $_POST["authorize"];
			$usrname = $_POST["usrname"];
			if($groupname == "" || $psw == ""){
				echo "<script>alert('请输入用户名和密码！ (╯°Д°)╯︵ ┻━┻');</script>";
				echo "<script>history.go(-1);</script>";
			}
			else{
				if($authorize == 1){
					connectdb("groupdb");
					$sql = "select name, password, author from grouptb where name='$groupname' and password='$psw'";
					$result = mysql_query($sql)or die("插入mysql指令失败");
					mysql_close();
					if($row = mysql_fetch_assoc($result)){
						session_start();
						$_SESSION['groupname'] = $row['name'];
						$_SESSION['author'] = $row['author'];
						//echo "{$row[0]} and {$row[1]}<br>";
						if($row['author'] == 1){
							print_r($_SESSION['groupname']);
							echo "团队登陆成功！";
							echo "<meta http-equiv='refresh' content='2;url=groupindex.php'>";
						}
						elseif($row['author'] == 3){
							echo "统计页面登陆成功！";
							echo "<meta http-equiv='refresh' content='2;url=supervolunlist.php'>";	
						}
					}
					else{
						echo "<script>alert('用户名或密码错误！');</script>";
						echo "<script>history.go(-1);</script>";
					}
				}
				elseif($authorize == 2){
					connectdb("memberdb");
					$sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='memberdb' and TABLE_NAME='$groupname'";
					$rst = mysql_query($sql);
					$row = mysql_fetch_row($rst);
					mysql_close();
					if($row[0] == 1){
						session_start();
						$_SESSION['groupname'] = $groupname;
						connectdb("memberdb");
						$sql = "select name, password, author from {$groupname} where name='$usrname' and password='{$psw}'";
						$result = mysql_query($sql)or die("插入mysql指令失败");
						mysql_close();
						if($row = mysql_fetch_assoc($result)){
							$_SESSION['usrname'] = $row['name'];
							$_SESSION['author'] = $row['author'];
							//print_r($row['author']);
							//echo "{$row[0]} and {$row[1]}<br>";
							print_r($_SESSION['usrname']);
							echo "个人登陆成功！";
							echo "<meta http-equiv='refresh' content='2;url=usrindex.php'>";
						}
						else{
							echo "<script>alert('用户名或密码错误！');</script>";
							echo "<script>history.go(-1);</script>";
						}
					}
					else{
						echo "<script>alert('团队名称输入错误！');</script>";
						echo "<script>history.go(-1);</script>";
					}
				}

			}
	}
	else{
		echo "<script>alert('提交失败！( •̀ ω •́ )y');</script>";
		echo "<script>history.go(-1);</script>";
	}
?>
