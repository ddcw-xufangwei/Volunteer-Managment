<?php
	
	function connectdb($selectdb){
		$conn = @mysql_connect("localhost","root","buptisvolunteer") or die("mysql数据库连接失败");
		mysql_select_db($selectdb) or die("{$selectdb}连接失败");
		@mysql_query("set names utf8");
	}
?>