<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<div class="mainarea">
<?php
	$mainid = $_GET["mainid"];
	$pjtname = $_GET["name"];
	$term = $_GET["term"];
	$pertime = $_GET["pertime"];
	$timetype = $_GET["timetype"];
	$score = $_GET["score"];
	$scoretype = $_GET["scoretype"];
	$outputs = $_GET["outputs"];
	if(!empty($mainid) & !empty($pjtname) & !empty($term) & $outputs == 'outputs'){
		/*	connectdb("volunteerdb");
		$sql = "select * from {$ses} where project='$pjtname' and term='$term' order by pjtgroup";
		//echo $sql;
		$rst = mysql_query($sql);
		mysql_close();
		$pjtname = iconv('utf-8', 'gb2312', $pjtname);
		$str = "{$pjtname}\n编号\t姓名\t班级\t学号\t电话\tQQ\t组别\t次数\t本活动时长\t本活动学分";
		$str = iconv('utf-8', 'gb2312', $str);
		$bianhao = 1;
		while($row=mysql_fetch_assoc($rst)){
			$bianhao = iconv('utf-8', 'gb2312', $bianhao);
			$name = iconv('utf-8', 'gb2312', $row['name']);
			$classes = iconv('utf-8', 'gb2312', $row['classes']);
			$code = iconv('utf-8', 'gb2312', $row['code']);
			$tel = iconv('utf-8', 'gb2312', $row['tel']);
			$QQ = iconv('utf-8', 'gb2312', $row['QQ']);
			$pjtgroup = iconv('utf-8', 'gb2312', $row['pjtgroup']);
			$attendtime = iconv('utf-8', 'gb2312', $row['attendtime']);
			if($timetype == 1){
				$totaltime = iconv('utf-8', 'gb2312', $pertime);
			}
			else{
				$totaltime = $pertime * $row['attendtime'];
				$totaltime = iconv('utf-8', 'gb2312', $totaltime);
			}
			if($scoretype == 1){
				$totalscore = iconv('utf-8', 'gb2312', $score);
			}
			else{
				$totalscore = $score * $row['attendtime'];
				$totalscore = iconv('utf-8', 'gb2312', $totalscore);
			}
			$str .= $bianhao."\t".$name."\t".$classes."\t".$code."\t".$tel."\t".$QQ."\t".$pjtgroup."\t".$attendtime."\t".$totaltime."\t".$totalscore."\t\n";
			$bianhao++;
		}
		//echo $str;
		$filename = "{$pjtname}".'.xls';
		//echo $filename;
		
		function exportExcel($filename,$content){ 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Content-Type: application/vnd.ms-execl"); 
			header("Content-Type: application/force-download"); 
			header("Content-Type: application/download"); 
			header("Content-Disposition: attachment; filename={$filename}"); 
			header("Content-Transfer-Encoding: binary"); 
			header("Pragma: no-cache"); 
			header("Expires: 0"); 
		
			echo $content;
		} 
		exportExcel($filename, $str);
		require_once 'Classes/PHPExcel.php';  
		//require_once 'common/excel/phpExcel/Writer/Excel2007.php';  
		require_once 'Classes/phpExcel/Writer/Excel5.php';  
		include_once 'Classes/phpExcel/IOFactory.php';  
		$objExcel = new PHPExcel();
		$objExcel->setActiveSheetIndex(0); 
		
		$objExcel->getActiveSheet()->setCellValue('a1', "{$pjtname}");
		$objExcel->getActiveSheet()->setCellValue('a3', "编号");
		$objExcel->getActiveSheet()->setCellValue('b3', "姓名");
		$objExcel->getActiveSheet()->setCellValue('c3', "班级");
		$objExcel->getActiveSheet()->setCellValue('d3', "学号");
		$objExcel->getActiveSheet()->setCellValue('e3', "电话");
		$objExcel->getActiveSheet()->setCellValue('f3', "QQ");
		$objExcel->getActiveSheet()->setCellValue('g3', "组别");
		$objExcel->getActiveSheet()->setCellValue('h3', "次数");
		$objExcel->getActiveSheet()->setCellValue('i3', "本活动时长");
		$objExcel->getActiveSheet()->setCellValue('j3', "本活动学分");
		
		connectdb("volunteerdb");
		$sql = "select * from {$ses} where project='$pjtname' and term='$term' order by pjtgroup";
		//echo $sql;
		$rst = mysql_query($sql);
		mysql_close();
		$bianhao = 1;
		while($row = mysql_fetch_row($sql)){
			$ul = $bianhao + 3;
			$objExcel->getActiveSheet()->setCellValue('a'.$u1, $bianhao);
			$objExcel->getActiveSheet()->setCellValue('b'.$u1, $row["name"]);
			$objExcel->getActiveSheet()->setCellValue('c'.$u1, $row["classes"]);
			$objExcel->getActiveSheet()->setCellValue('d'.$u1, $row["code"]);
			$objExcel->getActiveSheet()->setCellValue('e'.$u1, $row["tel"]);
			$objExcel->getActiveSheet()->setCellValue('f'.$u1, $row["QQ"]);
			$objExcel->getActiveSheet()->setCellValue('g'.$u1, $row["pjtgroup"]);
			$objExcel->getActiveSheet()->setCellValue('h'.$u1, $row["attendtime"]);
			if($timtype == 1){
				$objExcel->getActiveSheet()->setCellValue('i'.$u1, $pertime);
			}
			else{
				$totaltime = $pertime * $row["attendtime"];
				$objExcel->getActiveSheet()->setCellValue('i'.$u1, $totaltime);
			}
			if($scoretype == 1){
				$objExcel->getActiveSheet()->setCellValue('f'.$u1, $score);
			}
			else{
				$totalscore = $score * $row["attendtime"];
				$objExcel->getActiveSheet()->setCellValue('i'.$u1, $totalscore);
			}
			$bianhao++;
		}
		
		header('Content-Type: application/vnd.ms-excel');  
		header('Content-Disposition: attachment;filename={$pjtname}.xls');  
		header('Cache-Control: max-age=0');  
		$objWriter = PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');  
		$objWriter->save('php://output');  
		exit;  */
		
		
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
				header("Content-Disposition:attachment;filename=$pjtname(需要另存为.xls文件后才可使用).xls");
			}
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
				echo "</tr>";
				$bianhao++;
			}
			echo "</table>";
		}
		mysql_close();
	}
?>
</div>

<?php
	endif;
?>