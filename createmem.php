<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>

<div class="mainarea">

<?php
	connectdb("memberdb");
	$sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='memberdb' and TABLE_NAME='$ses'";
	$rst = mysql_query($sql) or die("查询失败");
	$row = mysql_fetch_row($rst) or die("buzhidao");
?>
	<h1>添加组员</h1>
	<hr />
	<span class='meminput'>
    
		<form action="memcheck.php" method="post" autocomplete="off" class="basic-grey">
        	<p>姓名	：<input type="text" name="name" />(必填)<br /></p>
            <p>学号	：<input type="text" name="code" />(必填)<br /></p>
            <p>班级	：<input type="text" name="classes" />(必填)<br /></p>
            <p>电话	：<input type="text" name="tel" /><br /></p>
            <p>企鹅	：<input type="text" name="QQ" /> 密码默认为 123456
            <p><input type="submit" class="button" name="memsub" value="确认" /></p>
            <b>组员（干事）不设置年级区分，每年清空即可。</b>
        </form>
    
	</span>
	<hr/>
    <h1>删除组员</h1>
    <hr />
<?php
	if($row[0] == "0"){
		echo "<p>目前没有组员。</p>";
		mysql_close();
	}
	else
	{
		//var_dump($id);
		$sql = "select name, code, classes, tel, QQ, id from {$ses}";
		$rst = mysql_query($sql) or die("shit!!!!");
		if($num = mysql_num_rows($rst)){
			$i = 1;
			echo "<form action='delmem.php' method='post' name='delmem' autocomplete='off'>";
			echo "<table width = '770px' class='zebra'>";
			echo "<th>编号</th>";
			echo "<th>姓名</th>";
			echo "<th>学号</th>";
			echo "<th>班级</th>";
			echo "<th>电话</th>";
			echo "<th>QQ</th>";
			echo "<th>选择</th>";
			while($row = mysql_fetch_assoc($rst)){
				$id = $row['id'];
				echo "<tr>";
				echo "<td>{$i}</td>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['code']}</td>";
				echo "<td>{$row['classes']}</td>";
				echo "<td>{$row['tel']}</td>";
				echo "<td>{$row['QQ']}</td>";
				echo "<td><input name='checkbox[]' type='checkbox' value='{$id}'></td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
			echo "<p><input type='submit' class='button' name='delselect' value='删除'>&emsp;&emsp;&emsp;&emsp;";
			echo "<b>（删除选中的组员）</b></p>";
			echo "<p><input type='submit' class='button' name='delall' value='全部删除'>&emsp;&emsp;";
			echo "<b>（删除全部组员，请谨慎操作）</b></p>";
			echo "</form>";
		}
		else{
			echo "<p>目前没有组员。</p>";	
		}
	
		echo "<hr/>";
		mysql_close();
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>
<?php
	endif;
?>