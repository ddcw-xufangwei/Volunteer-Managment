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
	if(isset($_POST["memberalter"]) && $_POST["memberalter"] == "确认更改"){
		connectdb("memberdb");
		$id = $_POST['id'];
		$name = $_POST["name"];
		$code = $_POST["code"];
		$classes = $_POST["classes"];
		$tel = $_POST["tel"];
		$QQ = $_POST["QQ"];
		$alterpw = $_POST["alterpw"];
		if($alterpw == 1){
			$sql = "update {$ses} set  name='$name',code='$code',classes='$classes',tel='$tel',QQ='$QQ',passqword='123456' where id='$id'" or die("写入错误");
			//echo "$sql";
		}
		else{
			$sql = "update {$ses} set  name='$name',code='$code',classes='$classes',tel='$tel',QQ='$QQ' where id='$id'" or die("写入错误");
			//echo "$sql";
		}
		//echo "$sql";
		$rst = mysql_query($sql)or die("cuowu");
		mysql_close();
		echo "<script>alert('组员更改成功！( •̀ ω •́ )y');</script>";
		echo "<meta http-equiv='refresh' content='0;url=altermemmain.php'>";
	}
?>

</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>