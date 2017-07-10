<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">
<h1>信用排行</h1>
<hr />

<?php
	connectdb("volunteerdb");
	$sql = "select * from {$ses} group by code order by credit desc";
	$rst = mysql_query($sql) or die("wrong!!");
	
	echo "<table width = '770px' class='zebra'>";
	echo "<th>编号</th>";
	echo "<th>姓名</th>";
	echo "<th>班级</th>";
	echo "<th>学号</th>";
	echo "<th>信用</th>";
	$bianhao = 1;
	while($row = mysql_fetch_assoc($rst)){
		echo "<tr>";
		echo "<td>$bianhao</td>";
		echo "<td>{$row['name']}</td>";
		echo "<td>{$row['classes']}</td>";
		echo "<td>{$row['code']}</td>";
		echo "<td>{$row['credit']}</td>";
		echo "</tr>";
		$bianhao++;
	}
	
	echo "</table>";
?>

<hr />
</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>