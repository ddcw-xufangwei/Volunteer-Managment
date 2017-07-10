<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 2):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">
	
<h1>删除志愿者</h1>
<hr />

<?php
	connectdb("projectdb");
	$sql = "SELECT name, term, member, member2, member3, pertime, timetype, score, scoretype, id FROM projecttb where groupname='{$ses}' and (member='{$_SESSION['usrname']}' or member2='{$_SESSION['usrname']}' or member3='{$_SESSION['usrname']}' or member4='{$_SESSION['usrname']}' or member5='{$_SESSION['usrname']}' or member6='{$_SESSION['usrname']}' or member7='{$_SESSION['usrname']}' or member8='{$_SESSION['usrname']}')";
	$rst = mysql_query($sql) or die("查询失败");
	$row = mysql_num_rows($rst);
	
	if($row == "0"){
		echo "<p>目前您没有正在负责的项目。</p>";	
	}
	else
	{
		echo "<h2>点击一项目名称来查看名单：</h2>";
		echo "<h3>只能选择您正在负责的项目</h3>";
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
		//$rst = mysql_query($sql) or die("查询失败");
		while($row = mysql_fetch_assoc($rst)){
			$mainid = $row["id"];
			$name = $row["name"];
			$term = $row["term"];
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td><a href='responsedeletevolunteer.php?mainid=$mainid&name=$name&term=$term'>{$row['name']}</a></td>";
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
			echo "</tr>";
			$i++;
			//print_r($rst);
		}
		echo "</table>";
		echo "<hr/>";
	}
	mysql_close();
?>

<?php
	$mainid = $_GET["mainid"];
	$pjtname = $_GET["name"];
	$term = $_GET["term"];
	if(!empty($mainid) & !empty($pjtname) & !empty($term)){
		//echo "<h1>志愿者名单</h1>";
		//echo "<hr />";
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
			echo "<form method='get' autocomplete='off'>";
			echo "<table width = '770px' class='zebra'>";
			echo "<th>编号</th>";
			echo "<th>姓名</th>";
			echo "<th>班级</th>";
			echo "<th>电话</th>";
			echo "<th>QQ</th>";
			echo "<th>组别</th>";
			echo "<th>选择</th>";
			$bianhao = 1;
			while($row = mysql_fetch_assoc($rst)){
				echo "<tr>";
				echo "<td>$bianhao</td>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['classes']}</td>";
				echo "<td>{$row['tel']}</td>";
				echo "<td>{$row['QQ']}</td>";
				echo "<td>{$row['pjtgroup']}</td>";
				echo "<td><input type='checkbox' name='selectvolunteer[]' value='{$row['id']}'></td>";
				echo "</tr>";
				$bianhao++;
			}
			echo "</table>";
			echo "<p><input type='submit' class='button' name='delselectvolunteer' value='删除'>&emsp;&emsp;&emsp;&emsp;";
			echo "<b>（删除选中的志愿者）</b></p>";
			echo "<p>为防止误删，故不设置全部删除选项。</p>";
			echo "</form>";
			echo "<hr />";
			
		}
		mysql_close();
	}
?>

<?php
	if($_GET['delselectvolunteer'] == '删除'){
		$selvon = $_GET['selectvolunteer'];
		//echo count($selvon);
		if(count($selvon) != 0){
			connectdb("volunteerdb");
			for($i=0;$i<count($selvon);$i++){
				$sql = "delete from {$ses} where id={$selvon[$i]}";
				//echo $sql;
				$rst = mysql_query($sql);
			}
			echo "<script>alert('删除成功！( •̀ ω •́ )y');</script>";
			echo "<script>history.back(-1);</script>";
		}
		else{
			echo "<script>alert('请至少选择一个项目( ▼-▼ )');</script>";
			echo "<script>history.back(-1);</script>";
		}
	}
	
?>
</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>