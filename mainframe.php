<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>团队管理系统</title>

<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 
	if($_SESSION['author'] == 1):
?>

<span class="MenuBarContent">
<p class="logo"><?php echo "$ses";?></p>
<hr />
<ul id="MenuBar1" class="MenuBarVertical">
  <li><a href="groupindex.php">主页</a></li>
  <li><a href="#" class="MenuBarItemSubmenu">项目管理</a>
    <ul>
      <li><a href="createproject.php">添加/删除项目</a></li>
      <li><a href="alterpjtmain.php">更改项目</a></li>
    </ul>
  </li>
  <li><a class="MenuBarItemSubmenu" href="#">组员管理</a>
    <ul>
      <li><a href="createmem.php">添加/删除组员</a></li>
      <li><a href="altermemmain.php">更改组员</a></li>
		</ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">查看志愿者</a>
    <ul>
      <li><a href="volunlist.php">按项目查询</a></li>
      <li><a href="blacklist.php">查看黑名单</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">管理志愿者</a>
    <ul>
      <li><a href="creatvolunteer.php">新建志愿者</a></li>
      <li><a href="deletevolunteer.php">删除志愿者</a></li>
      <li><a href="altervolunteerinfo.php">更改志愿者信息</a></li>
      <li><a href="createblacklist.php">添加/删除黑名单</a></li>
    </ul>
  </li>
   <li><a href="#">数据统计</a>
  	<ul>
      <li><a href="creditlist.php">信用排行</a></li>
      <li><a href="chartlist.php">图表数据</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">个人管理</a>
    <ul>
      <li><a href="changepassword.php">修改密码</a></li>
      <li><a href="BUG.php">BUG反馈</a></li>
    </ul>
  </li>
</ul>
</span>

<?php
	elseif($_SESSION['author'] == 2):
?>

<span class="MenuBarContent">
<p class="logo"><?php echo "$ses";?></p>
<hr />
<ul id="MenuBar1" class="MenuBarVertical">
  <li><a href="usrindex.php">主页</a></li>
  <li><a href="#" class="MenuBarItemSubmenu">查看志愿者</a>
    <ul>
      <li><a href="volunlist.php">按项目查询</a></li>
      <li><a href="blacklist.php">查看黑名单</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">管理志愿者</a>
    <ul>
      <li><a href="creatvolunteer.php">新建志愿者</a></li>
      <li><a href="responsedeletevolunteer.php">删除志愿者</a></li>
      <li><a href="responsealtervolunteerinfo.php">更改志愿者信息</a></li>
      <li><a href="createblacklist.php">添加/删除黑名单</a></li>
    </ul>
  </li>
  <li><a href="#">数据统计</a>
  	<ul>
      <li><a href="creditlist.php">信用排行</a></li>
      <li><a href="chartlist.php">图表数据</a></li>
    </ul>
  </li>
  <li><a href="#" class="MenuBarItemSubmenu">个人管理</a>
    <ul>
      <li><a href="changepassword.php">修改密码</a></li>
      <li><a href="BUG.php">BUG反馈</a></li>
    </ul>
  </li>
</ul>
</span>

<?php
	elseif($_SESSION['author'] == 3):
?>

<span class="MenuBarContent">
<p class="logo">统计页面</p>
<hr />
<ul id="MenuBar1" class="MenuBarVertical">
  <li><a href="supervolunlist.php">统计页面</a></li>
</ul>
</span>

<?php
	endif;
?>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
