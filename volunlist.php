<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">
	
<h1>项目名单</h1>
<hr />

<?php
	connectdb("projectdb");
	$sql = "SELECT name, term, member, member2, member3, pertime, timetype, score, scoretype, id FROM projecttb where groupname='{$ses}'";
	$rst = mysql_query($sql) or die("查询失败");
	$row = mysql_num_rows($rst);
	
	if($row == "0"){
		echo "<p>目前没有项目。</p>";	
	}
	else
	{
		echo "<h2>点击项目名称查看名单：</h2>";
		//$sql = "select id from {$ses}";
		//$rst = mysql_query($sql);
		$i = 1;
		echo "<table width = '770px' class='zebra'>";
		echo "<th>编号</th>";
		echo "<th>名称</th>";
		echo "<th>学期</th>";
		echo "<th>领队1</th>";
		echo "<th>领队2</th>";
		echo "<th>领队3</th>";
		echo "<th>时长</th>";
		echo "<th>时长类型</th>";
		echo "<th>学分</th>";
		echo "<th>学分类型</th>";
		echo "<th>信用</th>";
		//$rst = mysql_query($sql) or die("查询失败");
		while($row = mysql_fetch_assoc($rst)){
			$mainid = $row["id"];
			$name = $row["name"];
			$term = $row["term"];
			$pertime = $row["pertime"];
			$timetype = $row["timetype"];
			$score = $row["score"];
			$scoretype = $row["scoretype"];
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td><a href='volunlist.php?mainid=$mainid&name=$name&term=$term&pertime=$pertime&timetype=$timetype&score=$score&scoretype=$scoretype'>{$row['name']}</a></td>";
			echo "<td>{$row['term']}</td>";
			echo "<td>{$row['member']}</td>";
			echo "<td>{$row['member2']}</td>";
			echo "<td>{$row['member3']}</td>";
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
			echo "<td><a href='volunlistoutput.php?mainid=$mainid&name=$name&term=$term&pertime=$pertime&timetype=$timetype&score=$score&scoretype=$scoretype&outputs=outputs'>输出为excel</a></td>";
			echo "</tr>";
			$i++;
			//print_r($rst);
		}
		echo "</table>";
		echo "<p><b>由于一些原因目前的excel输出后请另存为一个xls文件才可正常使用。</b><br /></p>";
		echo "<hr/>";
	}
	mysql_close();
?>

<?php
	$mainid = $_GET["mainid"];
	$pjtname = $_GET["name"];
	$term = $_GET["term"];
	$pertime = $_GET["pertime"];
	$timetype = $_GET["timetype"];
	$score = $_GET["score"];
	$scoretype = $_GET["scoretype"];
	if(!empty($mainid) & !empty($pjtname) & !empty($term)){
		echo "<h2>{$pjtname}&nbsp;项目名单：</h2>";
		
		connectdb("volunteerdb");
		$sql = "create table if not exists {$ses} like demo";
		$rst = mysql_query($sql);
		//echo $sql;
		$sql = "select * from {$ses} where project='$pjtname' and term='$term' order by pjtgroup";
		$rst = mysql_query($sql);
		
		if(mysql_num_rows($rst) == 0){
			echo "目前本项目没有志愿者。";
		}
		else{
			if($_GET['outputs'] == 'outputs'){
				header("Content-type:application/xls");
				header("Content-Disposition:attachment;filename=$pjtname.xls");
			}
			echo "<form action='createblacklist.php' method='post' autocomplete='off'>";
			echo "<table width = '770px' class='zebra'>";
			echo "<th>编号</th>";
			echo "<th>姓名</th>";
			echo "<th>班级</th>";
			echo "<th>学号</th>";
			echo "<th>电话</th>";
			echo "<th>QQ</th>";
			echo "<th>组别</th>";
			echo "<th>次数</th>";
			echo "<th>本活动时长</th>";
			echo "<th>本活动学分</th>";
			echo "<th>信用</th>";
			echo "<th>选择拉黑</th>";
			$bianhao = 1;
			while($row = mysql_fetch_assoc($rst)){
				echo "<tr>";
				echo "<td>$bianhao</td>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['classes']}</td>";
				echo "<td>{$row['code']}</td>";
				echo "<td>{$row['tel']}</td>";
				echo "<td>{$row['QQ']}</td>";
				echo "<td>{$row['pjtgroup']}</td>";
				echo "<td>{$row['attendtime']}</td>";
				if($timetype == 1){
					echo "<td>$pertime</td>";
				}
				else{
					$totaltime = $pertime * $row['attendtime'];
					echo "<td>$totaltime</td>";
				}
				if($scoretype == 1){
					echo "<td>$score</td>";
				}
				else{
					$totalscore = $score * $row['attendtime'];
					echo "<td>$totalscore</td>";
				}
				echo "<td>{$row['credit']}</td>";
				echo "<td><input type='radio' name='selecttoblacklist' value='{$row['id']}'</td>";
				echo "</tr>";
				$bianhao++;
			}
			echo "</table>";
			echo "<input type='submit' class='button' name='submittoblacklist' value='添加到黑名单' />";
			echo "</form>";
		}
		mysql_close();
		echo "<hr />";
	}
?>
    
</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>