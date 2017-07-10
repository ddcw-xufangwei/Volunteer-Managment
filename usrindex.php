<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 2):
?>

<?php
	include("mainframe.php");
?>

<div class="mainarea">
<?php
	include_once("condb.php");
	connectdb("projectdb");
	//$sql = "select name,member,member2,member3,pertime from projecttb group by name having groupname='$ses'";
	$sql = "select name, term, member, pertime, timetype, score, scoretype, id from projecttb where groupname = '$ses'";
	//echo "$sql";
	$rst = mysql_query($sql) or die("查询失败");
	//var_dump($rst);
	$num = mysql_num_rows($rst);
	echo "<h1>项目总览</h1>";
	echo "<hr/>";
	if($num){
		$i = 1;
		echo "<table width = '770px' class='zebra'>";
		echo "<th>编号</th>";
		echo "<th>名称</th>";
		echo "<th>学期</th>";
		echo "<th>领队</th>";
		echo "<th>时长</th>";
		echo "<th>市场类型</th>";
		echo "<th>学分</th>";
		echo "<th>学分类型</th>";
		while($row = mysql_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td><a href='volunlist.php?mainid={$row['id']}&name={$row['name']}&term={$row['term']}'>{$row['name']}</a></td>";
			echo "<td>{$row['term']}</td>";
			echo "<td>{$row['member']}</td>";
			echo "<td>{$row['pertime']}</td>";
			if($row['timetype'] == "1"){
				echo "<td>学期总时长</td>";
			}
			else{
				echo "<td>单次时长</td>";
			}
			echo "<td>{$row['score']}</td>";
			if($row['scoretype'] == "1"){
				echo "<td>学期总学分</td>";
			}
			else{
				echo "<td>单次学分</td>";
			}
			echo "</tr>";
			$i++;
		}
		echo "</table>";
	}
	else{
		echo "<p>目前没有项目。</p>";
	}
	echo "<hr/>";
	mysql_close();
	
	echo "<h1>组员名单</h1>";
	echo "<hr/>";
	connectdb("memberdb");
	
	$sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='memberdb' and TABLE_NAME='$ses'";
	$rst = mysql_query($sql) or die("查询失败");
	$row = mysql_fetch_row($rst) or die("buzhidao");
	//print_r ($row[0]);
	//var_dump($row[0]);
	if($row[0] == "0"){
		echo "<p>目前没有组员。</p>";	
	}
	else
	{
		$sql = "select name, code, classes, tel, QQ from {$ses}";
		$rst = mysql_query($sql) or die("shit!!!!");
		if($num = mysql_num_rows($rst)){
			$i = 1;
			echo "<table width = '770px' class='zebra'>";
			echo "<th>编号</th>";
			echo "<th>姓名</th>";
			echo "<th>学号</th>";
			echo "<th>班级</th>";
			echo "<th>电话</th>";
			echo "<th>QQ</th>";
			while($row = mysql_fetch_assoc($rst)){
				echo "<tr>";
				echo "<td>{$i}</td>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['code']}</td>";
				echo "<td>{$row['classes']}</td>";
				echo "<td>{$row['tel']}</td>";
				echo "<td>{$row['QQ']}</td>";
				echo "</tr>";
				$i++;
			}
			echo "</table>";
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