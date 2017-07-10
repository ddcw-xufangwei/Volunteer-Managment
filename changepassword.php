<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">

<h1>修改密码</h1>
<hr />

<span class='meminput'>
<form method="post" autocomplete="off" class="basic-grey">
	<p>原始密码 ：<input type="password" name="oldpassword" /><br /></p>
    <p>新建密码 ：<input type="password" name="newpassword" /><br /></p>
    <p>再次确认 ：<input type="password" name="newpasswordsure" /><br /></p>
    <p><input type="submit" class="button" name="changepassword" value="确认修改" /><br /></p>
</form>
</span>
<hr />

<?php
	if($_POST['changepassword'] == "确认修改"){
		$oldpassword = $_POST['oldpassword'];
		$newpassword = $_POST['newpassword'];
		$newpasswordsure = $_POST['newpasswordsure'];
		
		if($auth[0] == 1){
			connectdb("groupdb");
			$sql = "select password from grouptb where name='{$ses}'";
			$rst = mysql_query($sql);
			mysql_close();
			$row = mysql_fetch_assoc($rst);
			if($row['password'] == $oldpassword && $newpassword != NULL){
				if($newpassword == $newpasswordsure){
					connectdb("groupdb");
					$sql = "update grouptb set password='{$newpassword}' where name='{$ses}'";
					$rst = mysql_query($sql);
					mysql_close();
					echo "<script>alert('密码修改成功( •̀ ω •́ )y');</script>";
					echo "<meta http-equiv='refresh' content='0;url=group.html'>";
				}
				else{
					echo "<script>alert('两次密码输入不一致。( ▼-▼ )');</script>";
					echo "<meta http-equiv='refresh' content='0;url=changepassword.php'>";
				}
			}
			else{
				echo "<script>alert('密码输入错误，请重新输入。( ▼-▼ )');</script>";
				echo "<meta http-equiv='refresh' content='0;url=changepassword.php'>";
			}
		}
		
		if($auth[0] == 2){
			connectdb("memberdb");
			$sql = "select password from {$ses} where name='{$_SESSION['usrname']}'";
			$rst = mysql_query($sql);
			mysql_close();
			$row = mysql_fetch_assoc($rst);
			if($row['password'] == $oldpassword && $newpassword != NULL){
				if($newpassword == $newpasswordsure){
					connectdb("memberdb");
					$usrname = $_SESSION['usrname'];
					$sql = "update {$ses} set password='{$newpassword}' where name='{$usrname}'";
					//echo $sql;
					$rst = mysql_query($sql);
					mysql_close();
					echo "<script>alert('密码修改成功( •̀ ω •́ )y');</script>";
					echo "<meta http-equiv='refresh' content='0;url=changepassword.php'>";
				}
				else{
					echo "<script>alert('两次密码输入不一致。( ▼-▼ )');</script>";
					echo "<meta http-equiv='refresh' content='0;url=changepassword.php'>";
				}
			}
			else{
				echo "<script>alert('密码输入错误，请重新输入。( ▼-▼ )');</script>";
				echo "<meta http-equiv='refresh' content='0;url=changepassword.php'>";
			}
		}
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>