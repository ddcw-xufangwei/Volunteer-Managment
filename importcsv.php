<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && $auth[0] == 1):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">



<?php

function input_csv($handle) {
	$out = array ();
	$n = 0;
	while ($data = fgetcsv($handle, 10000)) {
		$num = count($data);
		for ($i = 0; $i < $num; $i++) {
			$out[$n][$i] = $data[$i];
		}
		$n++;
	}
	return $out;
}

/**
 * @
 * @Description:
 * @Copyright (C) 2011 helloweba.com,All Rights Reserved.
 * -----------------------------------------------------------------------------
 * @author: Liurenfei (lrfbeyond@163.com)
 * @Create: 2012-5-1
 * @Modify:
*/
include_once ("condb.php");
$pjtname = $_POST['pjtname'];
$term = $_POST['term'];
$action = $_GET['action'];
if ($action == 'import') { //导入CSV
	$filename = $_FILES['file']['tmp_name'];
	if (empty ($filename)) {
		echo "<script>alert('请选择要导入的CSV文件！');</script>";
		echo "<meta http-equiv='refresh' content='0;url=creatvolunteer.php'>";
		exit;
	}
	
	/*$sql = "select code from {$ses} where code='$code'";
	$rst = mysql_query($sql);
	mysql_close();
	if(mysql_num_rows($rst) == 0){*/
	
	$handle = fopen($filename, 'r');
	$result = input_csv($handle); //解析csv
	$len_result = count($result);
	if($len_result==0){
		echo "<script>alert('没有任何数据！');</script>";
		echo "<meta http-equiv='refresh' content='0;url=creatvolunteer.php'>";
		exit;
	}
	
	for ($i = 3; $i < $len_result; $i++) { //循环获取各字段值
		$name = iconv('gb2312', 'utf-8', $result[$i][1]); //中文转码
		$classes = iconv('gb2312', 'utf-8', $result[$i][2]);
		$code = $result[$i][3];
		$tel = $result[$i][4];
		$QQ = iconv('gb2312', 'utf-8', $result[$i][5]);
		$pjtgroup = iconv('gb2312', 'utf-8', $result[$i][6]);
		$sql = "select count(code) from {$ses} where code='$code'";
		connectdb("blacklistdb");
		$rst = mysql_query($sql);
		mysql_close();
		$row = mysql_fetch_row($rst);
		//print_r($row);
		if($row['0'] == '0'){
			
			connectdb("volunteerdb");
			$sql = "select count(code) from {$ses} where code = $code and project = '$pjtname' and term = '$term'";
			$rst = mysql_query($sql);
			mysql_close();
			$row = mysql_fetch_row($rst);
			if($row['0'] == '0'){
				//echo (mysql_fetch_assoc($rst));
				$data_values .= "('$name','$classes','$code','$ses','$tel','$QQ','$pjtname','$term','$pjtgroup'),";
			}
			else{
				$data_values_dup .= "('$name','$classes','$code','$ses','$tel','$QQ','$pjtname','$term','$pjtgroup')<br />";
			}
		}else{
			$data_values_black .="('$name','$classes','$code','$ses','$tel','$QQ','$pjtname','$term','$pjtgroup')<br />";
		}
		//echo "name = $name, class = $classes, code = $code, tel = $tel, QQ = $QQ, term = $term<br>";
	}
	
	$data_values = substr($data_values,0,-1); //去掉最后一个逗号
	//echo $data_values;
	echo "<hr />";
	echo "<h2>黑名单排除人员（已排除添加）</h2>";
	echo $data_values_black;
	echo "<hr />";
	echo "<h2>数据库重复人员（已排除添加）</h2>";
	echo $data_values_dup;
	echo "<hr />";
	fclose($handle); //关闭指针
	
	connectdb("volunteerdb");
	
	$sql = "insert into {$ses}(name,classes,code,groupname,tel,QQ,project,term,pjtgroup) values $data_values";
	$rst = mysql_query($sql);
	
	mysql_close();
	
	echo "<script>alert('批量导入成功！( •̀ ω •́ )y');</script>";
	echo "<meta http-equiv='refresh' content='0;url=creatvolunteer.php'>";
	
	/*$query = mysql_query("insert into student (name,sex,age) values $data_values");//批量插入数据表中
	if($query){
		echo '导入成功！';
	}else{
		echo '导入失败！';
	}*/
} 
/*elseif ($action=='export') { //导出CSV
    $result = mysql_query("select * from student");
    $str = "姓名,性别,年龄\n";
    $str = iconv('utf-8','gb2312',$str);
    while($row=mysql_fetch_array($result)){
        $name = iconv('utf-8','gb2312',$row['name']);
        $sex = iconv('utf-8','gb2312',$row['sex']);
    	$str .= $name.",".$sex.",".$row['age']."\n";
    }
    $filename = date('Ymd').'.csv';
    export_csv($filename,$str);
}*/


/*function export_csv($filename,$data) {
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=".$filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}*/
?>





</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>