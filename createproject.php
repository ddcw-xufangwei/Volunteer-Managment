<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>

<div class="mainarea">
	<h1>新建项目</h1>
	<hr/>
	<span class='meminput'>
    
		<form action="pjtcheck.php" method="post" autocomplete="off">
        	<p>名称	：<input type="text" name="name" />(必填)<br /></p>
            <p>学年	：<input type="text" name="term" />(必填)（建议格式:如20151601、20151602分别代表2015-16学年上学期和下学期）<br /></p>
            <p>时长	：<input type="text" name="pertime" />(必填)&nbsp;
            时长类型:<label><input type="radio" name="timetype" value="1"/>学期总时长</label>
            <label><input type="radio" name="timetype" value="2"/>单次时长</label></p>
            <p>学分	：<input type="text" name="score" />(必填)&nbsp;
            学分类型:<label><input type="radio" name="scoretype" value="1"/>学期总学分</label>
            <label><input type="radio" name="scoretype" value="2"/>单次学分</label></p>
            <p>领队	：1：<input type="text" name="member" />&nbsp;2：<input type="text" name="member2" />&nbsp;3：<input type="text" name="member3" />&nbsp;4：<input type="text" name="member4" /><br /></p>
            <p>领队	：5：<input type="text" name="member5" />&nbsp;6：<input type="text" name="member6" />&nbsp;7：<input type="text" name="member7" />&nbsp;8：<input type="text" name="member8" /><br /></p>
            <p>提交后项目名称，学年将不可更改，请一再确认！！</p>
            <p>组员只能改动所负责的志愿者，故请正确填写领队名字。</p>
            <p>由于篇幅限制查询项目只能显示前3名领队，其余领队可在<b>更改项目</b>中查看到。</p>
            <input type="submit" name="projectsub"  class="button" value="确认" /></p>
        </form>
	</span>
	<hr/>
    
    <h1>删除项目</h1>
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
		//$sql = "select id from {$ses}";
		//$rst = mysql_query($sql);
		$i = 1;
		echo "<form action='delproject.php' method='post' name='delproject' autocomplete='off'>";
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
		echo "<th>选择</th>";
		//$rst = mysql_query($sql) or die("查询失败");
		while($row = mysql_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td>{$row['name']}</td>";
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
			echo "<td><input name='delpjt[]' type='checkbox' value='$row[id]'></td>";
			echo "</tr>";
			$i++;
			//print_r($rst);
		}
		echo "</table>";
		echo "<p><input type='submit' name='delselectpjt'  class='button' value='删除'>&emsp;&emsp;&emsp;&emsp;";
		echo "<b>（删除选中的项目，并将本项目的志愿者一并删除）</b></p>";
		echo "<p><input type='submit' name='delallpjt' class='button' value='全部删除'>&emsp;&emsp;";
		echo "<b>（删除全部项目，并删除所有志愿者，请谨慎操作！！！）</b></p>";
		echo "</form>";
		echo "<hr/>";
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>
<?php
	endif;
?>