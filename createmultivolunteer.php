<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1 || $auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<div class="mainarea">

<?php
	// 1.引用ExcelReader类文件
	require_once 'Excel/reader.php';
	// 2.实例化读取Excel的类
	$data = new Spreadsheet_Excel_Reader();
	// 3.设置输出编码
	$data->setOutputEncoding('utf-8');
	// 4.读取指定的excel
	$data->read('32readwriteAreaChart2.xls');
	
	
	// 5.循环输出每一行数据，这里读取的是Excel的第一个Sheet表格
	// sheets[0]['numRows']代表行数
	// sheets[0]['numCols']代表列数
	for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) { // 遍历行
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) { // 遍历列
			echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
		}
		echo "\n";
	}
?>

</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>