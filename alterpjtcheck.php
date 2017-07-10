<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
	if(isset($_POST["projectalter"]) && $_POST["projectalter"] == "确认更改"){
		connectdb("projectdb");
		$id = $_POST['id'];
		$member = $_POST["member"];
		$member2 = $_POST["member2"];
		$member3 = $_POST["member3"];
		$pertime = $_POST["pertime"];
		$timetype = $_POST["timetype"];
		$score = $_POST["score"];
		$scoretype = $_POST["scoretype"];
		
		$sql = "update projecttb set  member='$member',member2='$member2',member3='$member3',pertime='$pertime',timetype='$timetype',score='$score',scoretype='$scoretype' where id='$id'";
		//echo "$sql";
		$rst = mysql_query($sql)or die("cuowu");
		echo "<script>alert('项目更改成功！( •̀ ω •́ )y');</script>";
		mysql_close();
		echo "<meta http-equiv='refresh' content='0;url=alterpjtmain.php'>";
	}
?>

</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>