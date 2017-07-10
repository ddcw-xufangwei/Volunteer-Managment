<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>

<div class="mainarea">
    <h1>更改组员</h1>
	<hr/>
	<span class='meminput'>
    	
        <?php
			if(isset($_POST["alterselectmem"]) && $_POST["alterselectmem"] == "更改"){
				connectdb("memberdb");
				
				$sql = "select * from ${ses} where id='{$_POST['altermem']}'";
				$rst = mysql_query($sql);
				mysql_close();
				$row = mysql_fetch_assoc($rst);
				$sqlname = $row['name'];
				$sqlcode = $row['code'];
				$sqlclasses = $row['classes'];
				//echo "sub $sqlclasses";
				$sqltel = $row['tel'];
				$sqlQQ = $row['QQ'];
				$sqlpertime = $row['pertime'];
				$sqlid = $row['id'];
				if($sqlid == $_POST['altermem'] && $sqlid != NULL){
					echo "<form action='altermemcheck.php' method='post' autocomplete='off' class='basic-grey'>";
					echo "<p>姓名	：<input type='text' name='name' value='$sqlname' /><br /></p>";
					echo "<p>学号	：<input type='text' name='code' value='$sqlcode' /><br /></p>";
					echo "<p><input type='text' hidden='hidden' name='id' value='$sqlid'></p>";
					echo "<p>班级	：<input type='text' name='classes' value='$sqlclasses'/></p>";
					echo "<p>电话	：<input type='text' name='tel' value='$sqltel' /></p>";
					echo "<p>企鹅	：<input type='text' name='QQ' value='$sqlQQ' /></p>";
					echo "<p>重置密码	：<label><input type='radio' name='alterpw' value=1 />是</label>&nbsp";
					echo "<label><input type='radio' name='alterpw' value=2 checked='true' />否</label></p>";
					echo "<p><b>表单内的值是更改前所保存的组员信息。</b></p>";
					echo "<input type='submit' name='memberalter' class='button' value='确认更改' /></p>";
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
    
    <h1>组员名单参考</h1>
<?php
	connectdb("memberdb");
	if($row[0] == "0"){
		echo "<p>目前没有组员。</p>";	
	}
	else
	{
		//var_dump($id);
		$sql = "select name, code, classes, tel, QQ, id from {$ses}";
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