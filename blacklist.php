<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">

<h1>黑名单</h1>
<hr />
<h2>黑名单中的志愿者不能参加团队中的任何活动。</h2>

<?
    connectdb("blacklistdb");
    $sql = "create table if not exists {$ses} like demo";
    $rst = mysql_query($sql);
    //echo $sql;
    $sql = "select * from {$ses}";
    $rst = mysql_query($sql);
	mysql_close();
    if(mysql_num_rows($rst) == 0){
        echo "目前黑名单中没有志愿者。";
    }
    else{
        echo "<table width = '770px' class='zebra'>";
        echo "<th>编号</th>";
		echo "<th>姓名</th>";
		echo "<th>学号</th>";
        echo "<th>班级</th>";
		echo "<th>原因</th>";
		$bianhao = 1;
        while($row = mysql_fetch_assoc($rst)){
            echo "<tr>";
			echo "<td>$bianhao</td>";
            echo "<td>{$row['name']}</td>";
			echo "<td>{$row['code']}</td>";
            echo "<td>{$row['classes']}</td>";
			echo "<td>{$row['reasons']}</td>";
            echo "</tr>";
			$bianhao++;
        }
		echo "</table>";
		echo "<hr />";
    }
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>