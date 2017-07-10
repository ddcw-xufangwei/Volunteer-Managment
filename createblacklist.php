<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>

<div class="mainarea">

<h1>添加黑名单</h1>
<hr />
<span class='meminput'>
<?php
	if(isset($_POST['submittoblacklist'])){
		if(isset($_POST['selecttoblacklist'])){
			$id = $_POST['selecttoblacklist'];
			connectdb("volunteerdb");
			$sql = "select name, classes, code from {$ses} where id=$id";
			//echo $sql;
			$rst = mysql_query($sql);
			mysql_close();
			$row = mysql_fetch_assoc($rst);
			$name = $row['name'];
			$classes = $row['classes'];
			$code = $row['code'];
			echo "<form method='get' autocomplete='off' class='basic-grey'>";
				echo "<p>姓名	：<input type='text' name='name' value='$name' />(必填)<br /></p>";
				echo "<p>学号	：<input type='text' name='code' value='$code' />(必填)<br /></p>";
				echo "<p>班级	：<input type='text' name='classes' value='$classes' />(必填)<br /></p>";
				echo "<p>原因	：<input type='text' name='reasons' /><br /></p>";
				echo "<input type='submit' class='button' name='handoutblacklist' value='确认' />";
			echo "</form>";
		}
		else{
			echo "<script>alert('请至少选择一项q(≧▽≦q)');</script>";
			echo "<meta http-equiv='refresh' content='0;url=volunlist.php'>";
		}
	}
	else{
		echo "<form method='get' autocomplete='off' class='basic-grey'>";
			echo "<p>姓名	：<input type='text' name='name' />(必填)<br /></p>";
			echo "<p>学号	：<input type='text' name='code' />(必填)<br /></p>";
			echo "<p>班级	：<input type='text' name='classes' />(必填)<br /></p>";
			echo "<p>原因	：<input type='text' name='reasons' /><br /></p>";
			echo "<input type='submit' class='button' name='handoutblacklist' value='确认' />";
		echo "</form>";
	}
?>
</span>
<hr/>

<?php
	if(isset($_GET['handoutblacklist'])){
		if($_GET["name"] != "" & $_GET["code"] !="" & $_GET["classes"] != ""){
			connectdb("blacklistdb");
			$sql = "create table if not exists {$ses} like demo";
			$rst = mysql_query($sql);
			$sql = "select * from {$ses} where code='{$_GET['code']}'";
			//echo $sql;
			$rst = mysql_query($sql);
			$row = mysql_num_rows($rst);
			//print_r($row);
			if($row != "0"){
				echo "<script>alert('黑名单中已经存在该志愿者。');</script>";
				echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
			}
			else{
				if($auth[0] == 2){
					$reasons = $_SESSION['usrname'].": ".$_GET['reasons'];
					//echo $reasons;
				}
				else{
					$reasons = $_GET['reasons'];
				}
				$sql = "insert into {$ses}(name, code, classes, reasons) values('{$_GET['name']}','{$_GET['code']}','{$_GET['classes']}','$reasons')";
				//echo $sql;
				$rst = mysql_query($sql);
				echo "<script>alert('黑名单添加成功！( •̀ ω •́ )y');</script>";
				echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
			}
			mysql_close();
		}
		else{
			echo "<script>alert('写点儿什么哦！( •̀ ω •́ )y');</script>";
			echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
		}
	}
	
?>

<h1>删除黑名单</h1>
<hr />

<?
    connectdb("blacklistdb");
    $sql = "create table if not exists {$ses} like demo";
    $rst = mysql_query($sql);
    //echo $sql;
    $sql = "select * from {$ses}";
    $rst = mysql_query($sql);
	mysql_close();
    if(mysql_num_rows($rst) == 0){
        echo "目前黑名单中没有志愿者。";
    }
    else{
        echo "<form method='get' autocomplete='off'>";
		echo "<table width = '770px' class='zebra'>";
        echo "<th>编号</th>";
		echo "<th>姓名</th>";
		echo "<th>学号</th>";
        echo "<th>班级</th>";
		echo "<th>选择</th>";
		$bianhao = 1;
        while($row = mysql_fetch_assoc($rst)){
			$id = $row['id'];
            echo "<tr>";
			echo "<td>$bianhao</td>";
            echo "<td>{$row['name']}</td>";
			echo "<td>{$row['code']}</td>";
            echo "<td>{$row['classes']}</td>";
			echo "<td><input name='selectblacklist[]' type='checkbox' value='{$id}'></td>";
            echo "</tr>";
			$bianhao++;
        }
		echo "</table>";
		echo "<p><input type='submit' class='button' name='delselectblacklist' value='删除'>&emsp;&emsp;&emsp;&emsp;";
		echo "<b>（删除选中的黑名单成员）</b></p>";
		echo "<p><input type='submit' class='button' name='delallblacklist' value='全部删除'>&emsp;&emsp;";
		echo "<b>（删除全部黑名单，请谨慎操作）</b></p>";
		echo "</form>";
    }
?>

<?php
	if($_GET['delselectblacklist'] == "删除"){
		connectdb("blacklistdb");
		$selectblacklist = $_GET['selectblacklist'];
		if(count($selectblacklist) == 0){
			echo "<script>alert('请至少选择一项q(≧▽≦q)');</script>";
			echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
		}
		else{
			for($i=0;$i<=count($selectblacklist);$i++){
				if(!is_null($selectblacklist[$i])){
					$sql = "delete from {$ses} where id={$selectblacklist[$i]}";
					//echo "$sql";
					$rst = mysql_query($sql);
				}
			}
			echo "<script>alert('删除成功！o(*￣▽￣*)ブ');</script>";
			echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
		}
		mysql_close();
	}
	else if($_GET['delallblacklist'] == "全部删除"){
		connectdb("blacklistdb");
		$sql = "truncate table {$ses}";
		$rst = mysql_query($sql);
		echo "<script>alert('全部删除成功！o(*￣▽￣*)ブ');</script>";
		echo "<meta http-equiv='refresh' content='0;url=createblacklist.php'>";
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>
<?php
	endif;
?>