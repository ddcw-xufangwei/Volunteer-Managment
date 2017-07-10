<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1 || $auth[0] == 2):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">

<h1>八阿哥反馈23333</h1>
<hr />
<h3>发什么都可以哦！功能、实用性...我会看到的~</h3>

<form method="post" class="basic-grey">
<p><textarea cols="60" rows="10" name="bugcontent"></textarea><br /></p>
<p><input type="submit" class="button" name="bugsubmit" value="提交" /><br /></p>
</form>
<p>也可以直接联系我:534131954@qq.com</p>
<hr />

<?php
	if($_POST['bugsubmit'] == "提交"){
		$bugcontent = $_POST['bugcontent'];
		if($bugcontent != ""){
			//echo $bugcontent;
			connectdb("bugdb");
			$sql = "insert into bugtb (groupname, content) values('{$ses}', '{$bugcontent}')";
			//echo $sql;
			$rst = mysql_query($sql);
			echo "<script>alert('提交成功！( •̀ ω •́ )y');</script>";
			echo "<meta http-equiv='refresh' content='0;url=BUG.php'>";
		}
		else{
			echo "<script>alert('要写点儿什么哦！( •̀ ω •́ )y');</script>";
		}
	}
	

?>
</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>