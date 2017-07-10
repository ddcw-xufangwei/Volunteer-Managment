<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>

<div class="mainarea">
    <h1>更改项目</h1>
	<hr/>
	<span class='meminput'>
    	
        <?php
			if(isset($_POST["alterselectpjt"]) && $_POST["alterselectpjt"] == "更改"){
				connectdb("projectdb");
				
				$sql = "select * from projecttb where id='{$_POST['alterpjt']}'";
				$rst = mysql_query($sql);
				$row = mysql_fetch_assoc($rst);
				$sqlname = $row['name'];
				$sqlterm = $row['term'];
				$sqlmember = $row['member'];
				$sqlmember2 = $row['member2'];
				$sqlmember3 = $row['member3'];
				$sqlmember4 = $row['member4'];
				$sqlmember5 = $row['member5'];
				$sqlmember6 = $row['member6'];
				$sqlmember7 = $row['member7'];
				$sqlmember8 = $row['member8'];
				$sqlpertime = $row['pertime'];
				$sqltimetype = $row['timetype'];
				$sqlscore = $row['score'];
				$sqlscoretype = $row['scoretype'];
				$sqlid = $row['id'];
				if($sqlid == $_POST['alterpjt'] && $sqlid != NULL){
					echo "<form action='alterpjtcheck.php' method='post' autocomplete='off'>";
					echo "<p>名称	：$sqlname &nbsp;(不可更改)<br /></p>";
					echo "<p>学年	：$sqlterm &nbsp;(不可更改)<br /></p>";
					echo "<p><input type='text' hidden='hidden' name='id' value='$sqlid'></p>";
					echo "<p>时长	：<input type='text' name='pertime' value='$sqlpertime'/>(必填)&nbsp;";
					if($sqltimetype == 1){
						echo "时长类型:<label><input type='radio' name='timetype' value='1' checked='true' />学期总时长</label>";
						echo "<label><input type='radio' name='timetype' value='2'/>单次时长</label></p>";
					}
					else{
						echo "时长类型:<label><input type='radio' name='timetype' value='1'/>学期总时长</label>";
						echo "<label><input type='radio' name='timetype' value='2' checked='true' />单次时长</label></p>";
					}
					echo "<p>学分	：<input type='text' name='score' value='$sqlscore' />(必填)&nbsp;";
					if($sqlscoretype == 1){
						echo "学分类型:<label><input type='radio' name='scoretype' value='1' checked='true' />学期总学分</label>";
						echo "<label><input type='radio' name='scoretype' value='2'/>单次学分</label></p>";
					}
					else{
						echo "学分类型:<label><input type='radio' name='scoretype' value='1' />学期总学分</label>";
						echo "<label><input type='radio' name='scoretype' value='2' checked='true' />单次学分</label></p>";
					}
					echo "<p>领队	：1：<input type='text' name='member' value='$sqlmember' />&nbsp;2：<input type='text' name='member2' value='$sqlmember2' />&nbsp;3：<input type='text' name='member3' value='$sqlmember3' />&nbsp;4：<input type='text' name='member4' value='$sqlmember4' /><br /></p>";
					echo "<p>领队	：5：<input type='text' name='member5' value='$sqlmember5' />&nbsp;6：<input type='text' name='member6' value='$sqlmember6' />&nbsp;7：<input type='text' name='member7' value='$sqlmember7' />&nbsp;8：<input type='text' name='member8' value='$sqlmember8' /><br /></p>";
					echo "<p><b>表单内的值是更改前所保存的项目信息。</b></p>";
					echo "<input type='submit' class='button' name='projectalter' value='确认更改' /></p>";
					echo "</form>";
				}
				else{
					echo "<script>alert('请选择一项进行更改！( •̀ ω •́ )y');</script>";
					echo "<script>history.back(-1);</script>";
				}
			}
			else{
				echo "<script>alert('出现错误，请返回。');</script>";
				echo "<script>history.go(-1);</script>";
			}
       ?>
	</span>
	<hr/>
    
    <h1>项目名单参考</h1>
<?php
	connectdb("projectdb");
	$sql = "SELECT name, term, member, member2, member3, pertime, score, id FROM projecttb where groupname='{$ses}'";
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
		echo "<th>领队1</th>";
		echo "<th>领队2</th>";
		echo "<th>领队3</th>";
		echo "<th>时长</th>";
		echo "<th>学分</th>";
		//$rst = mysql_query($sql) or die("查询失败");
		while($row = mysql_fetch_assoc($rst)){
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td>{$row['name']}</td>";
			echo "<td>{$row['member']}</td>";
			echo "<td>{$row['member2']}</td>";
			echo "<td>{$row['member3']}</td>";
			echo "<td>{$row['pertime']}</td>";
			echo "<td>{$row['score']}</td>";
			echo "</tr>";
			$i++;
			//print_r($rst);
		}
		echo "</table>";
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