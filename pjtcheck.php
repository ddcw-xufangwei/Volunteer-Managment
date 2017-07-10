<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Waiting...</title>
</head>

<?php
	session_start();
	if(isset($_POST["projectsub"]) & $_POST["projectsub"] == "确认"){
		$name = $_POST["name"];
		$term = $_POST["term"];
		$pertime = $_POST["pertime"];
		$timetype = $_POST["timetype"];
		$score = $_POST["score"];
		$scoretype = $_POST["scoretype"];
		$member = $_POST["member"];
		$member2 = $_POST["member2"];
		$member3 = $_POST["member3"];
		$member4 = $_POST["member4"];
		$member5 = $_POST["member5"];
		$member6 = $_POST["member6"];
		$member7 = $_POST["member7"];
		$member8 = $_POST["member8"];
		$groupname = $_SESSION["groupname"];
		//echo "$timetype";
		//echo "$scoretype";
		
		if($name==""||$term==""||$pertime==""||$timetype==""||$score==""||$scoretype==""){
			echo "<script>alert('请正确填写必填项目( ▼-▼ )');</script>";
			echo "<script>history.go(-1);</script>";
		}
		else{
			include("condb.php");
			connectdb("projectdb");
			$sql = "select * from projecttb where name='{$name}' and term='{$term}'";
			$rst = mysql_query($sql) or die("寻找错误了。");
			$row = mysql_num_rows($rst);
			if($row != 0){
				echo "<script>alert('本学期已经存在本项目。');</script>";
				echo "<script>history.go(-1);</script>";
			}
			else{
				$sql = "insert into projecttb(name,term,pertime,timetype,score,scoretype,member,member2,member3,member4,member5,member6,member7,member8,groupname) values('{$name}','{$term}','{$pertime}','{$timetype}','{$score}','{$scoretype}','{$member}','{$member2}','{$member3}','{$member4}','{$member5}','{$member6}','{$member7}','{$member8}','{$groupname}')";
				//echo "$sql";
				$rst = mysql_query($sql) or die("输入不合法，请返回重新输入");
				echo "<script>alert('成功！（￣▽￣）～■□～（￣▽￣）');</script>";
				echo "<script>history.back(-1);</script>";
			}
		}
	}
?>

<body>
</body>
</html>