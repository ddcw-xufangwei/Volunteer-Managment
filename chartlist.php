<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<script src="SpryAssets/echarts.js"></script>
<?php
	include("safecheck.php");
	if($_SESSION['groupname'] && ($auth[0] == 1) || ($auth[0] == 2)):
?>
<?php
	include("mainframe.php");
?>
<?php
	connectdb("volunteerdb");
	$sql = "select credit, count(name) from {$ses} group by code, credit order by credit asc" or die("dd");
	$rst = mysql_query($sql);
	mysql_close();
	$v1 = $v2 = $v3 = $v4 = $v5 = $v6 = $v7 = 0;
	while($row = mysql_fetch_assoc($rst)){
		if($row['credit'] <= 2){
			$v1++;
		}
		elseif($row['credit'] >= 3 & $row['credit'] <= 5){
			$v2++;
		}
		elseif($row['credit'] >= 6 & $row['credit'] <= 8){
			$v3++;
		}
		elseif($row['credit'] >= 9 & $row['credit'] <= 11){
			$v4++;
		}
		elseif($row['credit'] >= 12 & $row['credit'] <= 14){
			$v5++;
		}
		elseif($row['credit'] >= 15 & $row['credit'] <= 17){
			$v6++;
		}
		elseif($row['credit'] >= 18){
			$v7++;
		}
	}
	//echo "<script>alert('$v4 $v5');</script>";
?>
<div class="mainarea">
	<h1>图表数据</h1>
	<hr />
	<div id="chart1" style="width: 700px;height:500px;"></div>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('chart1'));

        // 指定图表的配置项和数据
        option = {
			title : {
				text: '志愿者信用分布图',
				//subtext: '纯属虚构',
				x:'center'
			},
			tooltip : {
				trigger: 'item',
				formatter: "{a} <br/>{b} : {c} ({d}%)"
			},
			legend: {
				x : 'center',
				y : 'bottom',
				data:['小于3分','3-5分','6-8分','9-11分','12-15分','16-18分','大于18分']
			},
			toolbox: {
				show : true,
				feature : {
					mark : {show: true},
					dataView : {show: true, readOnly: false},
					magicType : {
						show: true,
						type: ['pie', 'funnel']
					},
					restore : {show: true},
					saveAsImage : {show: true}
				}
			},
			calculable : true,
			series : [
			   
				{
					name:'人数',
					type:'pie',
					radius : [30, 130],
					center : ['50%', 250],
					roseType : 'area',
				<?php
					
					echo "data:[";
					echo "{value:$v1, name:'小于3分'},";
					echo "{value:$v2, name:'3-5分'},";
					echo "{value:$v3, name:'6-8分'},";
					echo "{value:$v4, name:'9-11分'},";
					echo "{value:$v5, name:'12-15分'},";
					echo "{value:$v6, name:'16-18分'},";
					echo "{value:$v7, name:'大于18分'}";
					echo "]";
				?>
				}
			]
		};


        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    </script>


</div>
</body><!--body和html封装在了mainframe.html里面-->
</html>

<?php
	endif;
?>