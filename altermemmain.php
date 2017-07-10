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
    <h1>更改组员</h1>
    <hr />
<?php
	if($row[0] == "0"){
		echo "<p>目前没有组员。</p>";	
	}
	else
	{
		//var_dump($id);
		echo "<h2>选择一位要更改的组员：</h2>";
		$sql = "select name, code, classes, tel, QQ, id from {$ses}";
		$rst = mysql_query($sql) or die("shit!!!!");
		if($num = mysql_num_rows($rst)){
			$i = 1;
			echo "<form action='altermemsub.php' method='post' name='altermember' autocomplete='off'>";
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
				echo "<td><input name='altermem' type='radio' value='{$id}'></td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
			echo "<p><input type='submit' name='alterselectmem' class='button' value='更改'>";
			echo "</form>";
		}
		else{
			echo "<p>目前没有组员。</p>";	
		}
	
		echo "<hr/>";
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>
<?php
	endif;
?>