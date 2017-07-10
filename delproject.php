<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Waiting...</title>
</head>
<?php
	include_once("condb.php");
	if($_POST['delallpjt']=="全部删除"){
		connectdb("projectdb");
		$sql = "delete from projecttb where groupname='{$ses}'";
		mysql_query($sql) or die("删除失败");
		mysql_close();
		connectdb("volunteerdb");
		$sql = "truncate table {$ses}";
		$rst = mysql_query($sql);
		mysql_close();
		echo "<script>alert('全部删除成功！o(*￣▽￣*)ブ');</script>";
		echo "<script>history.go(-1);</script>";
	}
	else{
		$checkbox = $_POST['delpjt'];
		connectdb("projectdb");
		for($i=0;$i<=count($checkbox);$i++){
			if(!is_null($checkbox[$i])){
				$checkvalue=$checkbox[$i];
				$sql = "select name, term from projecttb where id='{$checkvalue}'";
				$rst = mysql_query($sql);
				while($row = mysql_fetch_assoc($rst)){
					$name[$i] = $row["name"];
					$term[$i] = $row["term"];
				}
				//echo "$checkvalue";
				//echo i."$i";
				$sql = "delete from projecttb where id='{$checkbox[$i]}'";
				//echo "$sql";
				mysql_query($sql);
			}
			else{
				mysql_close();
				break;
			}
		}
		
		if($i==0){
			echo "<script>alert('请至少选择一项！');</script>";
			echo "<script>history.go(-1);</script>";
		}
		else{
			connectdb("volunteerdb");
			$sql = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='volunteerdb' and TABLE_NAME='$ses'";
			$rst = mysql_query($sql) or die("查询失败");
			$row = mysql_fetch_row($rst) or die("buzhidao");
			if($row[0] == "0"){
				echo "<script>alert('删除成功！o(*￣▽￣*)ブ');</script>";
				echo "<script>history.go(-1);</script>";	
			}
			else{
				for($j=0;$j<$i;$j++){
				$sql = "delete from {$ses} where project='$name[$j]' and term='$term[$j]'";
				//echo $sql;
				$rst = mysql_query($sql);
				}
				echo "<script>alert('删除成功！o(*￣▽￣*)ブ');</script>";
				echo "<script>history.go(-1);</script>";
			}
			
		}
		
	}
	
	
?>
<body>
</body>
</html>
<?php
	endif
?>