<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">
	
<h1>新建志愿者</h1>
<hr />

<?php
	connectdb("projectdb");
	$sql = "SELECT name, term, member, member2, member3, pertime, timetype, score, scoretype, id FROM projecttb where groupname='{$ses}'";
	$rst = mysql_query($sql) or die("查询失败");
	mysql_close();
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
		//$rst = mysql_query($sql) or die("查询失败");
		while($row = mysql_fetch_assoc($rst)){
			$mainid = $row["id"];
			$name = $row["name"];
			$term = $row["term"];
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td><a href='creatvolunteer.php?mainid=$mainid&name=$name&term=$term'>{$row['name']}</a></td>";
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
?>

<?php
	$mainid = $_GET["mainid"];
	$pjtname = $_GET["name"];
	$term = $_GET["term"];
	if(!empty($mainid) & !empty($pjtname) & !empty($term)){
		echo "<h2>填写志愿者信息</h2>";
		echo "<hr />";
		echo "<h2>新建{$pjtname}项目志愿者：</h2>";
		
		connectdb("volunteerdb");
		$sql = "create table if not exists {$ses} like demo";
		$rst = mysql_query($sql);
		mysql_close();
		//echo $sql;
		echo "<span class='meminput'>";
		echo "<form method='get' autocomplete='off' class='basic-grey'>";
		echo "<p>姓名 ：<input type='text' name='volname'>（必填）</p>";
		echo "<p>学号 ：<input type='text' name='code'>（必填）</p>";
		echo "<p>班级 ：<input type='text' name='classes'>（必填：例如2013213047）</p>";
		echo "<p>电话 ：<input type='text' name='tel'>（必填）</p>";
		echo "<p>组别 ：<input type='text' name='pjtgroup'>（例如A组）</p>";
		echo "<p>企鹅 ：<input type='text' name='QQ'></p>";
		echo "<input type='hidden' name='groupname' value='{$ses}'>";
		echo "<input type='hidden' name='project' value='{$pjtname}'>";
		echo "<input type='hidden' name='pjtterm' value='{$term}'>";
		echo "<input type='submit' name='createvolun' class='button' value='新建志愿者'>";
		echo "</form>";
		echo "</span>";
		echo "<hr />";
		
		echo "<h2>批量导入志愿者（测试中）</h2>";
		echo "<form class='basic-grey' id='addform' action='importcsv.php?action=import' method='post' enctype='multipart/form-data'>";
        echo "<p><b>请严格使用模板导入，不然可能出现数据损坏。</b></p>";
		echo "<p><b>也不要对模板进行美化，改造等。。。</b></p>";
		echo "<p><a href='demo.csv'>点击这里下载模板！</a></p>";
		echo "<p>请选择要导入的CSV文件：<input type='file' name='file'></p>";
		echo "<p><input type='hidden' name='pjtname' value='$pjtname'></p>";
		echo "<p><input type='hidden' name='term' value='$term'></p>";
		echo "<p><input type='submit' name='importcsv' class='button' value='导入CSV文件'></p>";
     	echo "</form>";

	}
?>

<?php
	$volname= $_GET['volname'];
	$code = $_GET['code'];
	$classes = $_GET['classes'];
	$tel = $_GET['tel'];
	$pjtgroup = $_GET['pjtgroup'];
	$QQ = $GET['QQ'];
	$groupname = $_GET['groupname'];
	$project = $_GET['project'];
	$pjtterm = $_GET['pjtterm'];
	$createvolun = $_GET['createvolun'];
	if(isset($createvolun)){
		if(!empty($volname) & !empty($code) & !empty($classes) & !empty($tel)){
			connectdb("volunteerdb");
			$sql = "select * from {$ses} where project='$project' and code='$code' and term='$pjtterm'";
			$rst = mysql_query($sql);
			mysql_close();
			if(mysql_num_rows($rst) == 0){
				connectdb("blacklistdb");
				$sql = "create table if not exists {$ses} like demo";
				$rst = mysql_query($sql);
				$sql = "select code from {$ses} where code='$code'";
				$rst = mysql_query($sql);
				mysql_close();
				if(mysql_num_rows($rst) == 0){
					$sql = "insert into {$ses}(name, code, classes, groupname, tel, QQ, project, term, pjtgroup, attendtime) values('$volname', '$code', '$classes', '{$ses}', '$tel', '$QQ', '$project', '$pjtterm', '$pjtgroup', '0')";
					//echo "$sql";
					connectdb("volunteerdb");
					$rst = mysql_query($sql);
					mysql_close();
					echo "<script>alert('新建志愿者成功( •̀ ω •́ )y');</script>";
					echo "<script>history.back(-1);</script>";
				}
				else{
					echo "<script>alert('您添加的志愿者在黑名单中，已禁止添加。。。(-｡-;)');</script>";
					echo "<script>history.back(-1);</script>";
				}
				
			}
			else{
				echo "<script>alert('已存在该志愿者(￣▽￣)\"');</script>";
				echo "<script>history.back(-1);</script>";
			}
		}
		else{
			echo "<script>alert('请将必要信息填写完整！q(≧▽≦q)');</script>";
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