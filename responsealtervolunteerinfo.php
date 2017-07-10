<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">
	
<h1>更改志愿者信息</h1>
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
			echo "<td><a href='responsealtervolunteerinfo.php?mainid=$mainid&name=$name&term=$term'>{$row['name']}</a></td>";
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
			echo "<th>学号</th>";
			echo "<th>班级</th>";
			echo "<th>电话</th>";
			echo "<th>QQ</th>";
			echo "<th>组别</th>";
			echo "<th>次数</th>";
			echo "<th>选择</th>";
			$bianhao = 1;
			while($row = mysql_fetch_assoc($rst)){
				echo "<tr>";
				echo "<td>$bianhao</td>";
				echo "<td>{$row['name']}</td>";
				echo "<td>{$row['code']}</td>";
				echo "<td>{$row['classes']}</td>";
				echo "<td>{$row['tel']}</td>";
				echo "<td>{$row['QQ']}</td>";
				echo "<td>{$row['pjtgroup']}</td>";
				echo "<td>{$row['attendtime']}</td>";
				echo "<td><input type='radio' name='selectaltervolunteer' value='{$row['id']}'</td>";
				echo "</tr>";
				$bianhao++;
			}
			echo "</table>";
			echo "<p><input type='submit' class='button' name='selectaltervolun' value='更改'></p>";
			echo "</form>";
			echo "<hr />";
		}
		mysql_close();
	}
?>

<?php
	$selectaltervolun = $_GET['selectaltervolun'];
	if(!empty($selectaltervolun)){
		$selectaltervolunteer = $_GET['selectaltervolunteer'];
		if(!empty($selectaltervolunteer)){
			connectdb("volunteerdb");
			$sql = "select * from {$ses} where id='$selectaltervolunteer'";
			//echo "$sql";
			$rst = mysql_query($sql);
			$row = mysql_fetch_assoc($rst);
			$name = $row['name'];
			$code = $row['code'];
			$classes = $row['classes'];
			$tel = $row['tel'];
			$QQ = $row['QQ'];
			$pjtgroup = $row['pjtgroup'];
			$attendtime = $row['attendtime'];
			$id = $row['id'];
			echo "<h2>请重新填写志愿者信息：</h2>";
			echo "<form method='get' autocomplete='off' class='basic-grey'>";
			echo "<p>姓名 ：<input type='text' name='name' value='$name'>（必填）</p>";
			echo "<p>学号 ：<input type='text' name='code' value='$code'>（必填）</p>";
			echo "<p>班级 ：<input type='text' name='classes' value='$classes'>（必填：例如2013213047）</p>";
			echo "<p>电话 ：<input type='text' name='tel' value='$tel'>（必填）</p>";
			echo "<p>组别 ：<input type='text' name='pjtgroup' value='$pjtgroup'>（例如A组）</p>";
			echo "<p>企鹅 ：<input type='text' name='QQ' value='$QQ'></p>";
			echo "<p>次数 ：<input type='text' name='attendtime' value='$attendtime'>（已经参与本项目的次数）</p>";
			echo "<input type='hidden' name='id' value='$id'>";
			echo "<input type='submit' class='button' name='altervolunteerinformation' value='确认更改'>";
			echo "</form>";
			echo "<hr />";
		}
		else{
			echo "<script>alert('请选择一位志愿者(づ￣ 3￣)づ');</script>";
			echo "<script>history.back(-1);</script>";
		}
	}
?>

<?php
	$name = $_GET['name'];
	$code = $_GET['code'];
	$classes = $_GET['classes'];
	$tel = $_GET['tel'];
	$QQ = $_GET['QQ'];
	$pjtgroup = $_GET['pjtgroup'];
	$attendtime = $_GET['attendtime'];
	$id = $_GET['id'];
	$altervolunteerinformation = $_GET['altervolunteerinformation'];
	if(!empty($altervolunteerinformation)){
		connectdb("volunteerdb");
		$sql = "update {$ses} set name='$name', code='$code', classes='$classes', tel='$tel', QQ='$QQ', pjtgroup='$pjtgroup', attendtime='$attendtime' where id='$id'";
		//echo $sql;
		$rst = mysql_query($sql) or die("注入错误");
		echo "<script>alert('信息更改成功( •̀ ω •́ )y');</script>";
		echo "<script>history.back(-1);</script>";
		echo "<script>history.back(-1);</script>";
	}
?>
    
</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>