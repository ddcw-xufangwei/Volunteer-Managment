<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">

<?php
	if(is_null($select)){
		echo "<script>alert('请选择一项哦( ▼-▼ )');</script>";
		echo "<script>history.back(-1);</script>";
	}
	else{
		$id = $_POST['selecttoblacklist'];
		connectdb("volunteerdb");
		$sql = "select name, code, classes from {$ses} where id={$id}";
		//echo $sql;
		$rst = mysql_query($sql);
		mysql_close();
		$row = mysql_fetch_assoc($rst);
		$name = $row['name'];
		$code = $row['code'];
		$classes = $row['classes'];
	}
?>
<h1>添加黑名单</h1>
<hr />
<?php
	echo "<p>姓名： $name</p>";
	echo "<p>班级： $classes</p>";
	echo "<p>学号： $code</p>";
	echo "<form action='toblacklist.php' method='get' class='basic-grey'>";
	echo "<p><textarea cols='60' rows='10' name='reasons'></textarea><br /></p>";
	echo "<input type='hidden' name='name' value='$name'";
	echo "<input type='hidden' name='code' value='$code'";
	echo "<input type='hidden' name='classes' value='$classes'";
	echo "<p><input type='submit' class='button' name='blacklistsub' value='提交' /><br /></p>";
	echo "</form>";
?>
<?php
	if(!is_null($_GET['blacklistsub'])){
		$name = $_GET['name'];
		$classes = $_GET['calsses'];
		$code = $_GET['code'];
		$reasons = $_SESSION['usrname'].$_GET['reasons'];
		echo $reasons;
		if(is_null($name) || is_null($classes) || is_null($code)){
			echo "<script>alert('貌似出现了一个错误( ▼-▼ )');</script>";
			echo "<meta http-equiv='refresh' content='0;url=volunlist.php'>";
		}
		else{
			connectdb("blacklistdb");
			$sql = "create table if not exists {$ses} like demo";
			$rst = mysql_query($sql);
			$sql = "insert";
		}
	}
	
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>