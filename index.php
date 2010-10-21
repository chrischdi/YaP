<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//DE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- 
** This is YaP - Yet another Pager
** Yet another Pager is a content management system without a (common) database.
** It uses xml-files to save it's content.
** We are aviable on http://github.com/chrischdi/YaP
-->
<html>
<head>
<style type="text/css">

html, body {
	height: 100%;
	margin: 0;
	padding: 0;
	font-family: sans-serif,verdana;
}

#headbar {
	background-color:#3B5998;
	height: 80px;
	width:100%
	left: 0;
}

#wrapper {
	margin: -80px auto 0 auto;
	width: 960px;
}

#header {
	text-align: center;
	height: 80px;
	width: 960px;
	color: #ffffff;
}

#header div {
	padding: 5px;
}

#main {
	margin: 10px 0;
	width: 960px;
	border-bottom: 2px groove #3B5998;
}

#nav {
	width: 150px;
	float: left;
}

#content {
	width: 810px;
	margin-left: 150px;
}

p {
	margin: 4px 0;
}

#footer {
	color: #afafaf;
	width: 960px;
	height: 40px;
	padding: 10px;
	text-align: center;
}

#footer span {
	margin: 0 10px 0 10px;
}

#nav a {
    display: block;
}
<?php
include "inc/cms.php";
?>
</style>
<title><?php $cms->website->title(); ?> - <?php $cms->page->title(); ?></title>
</head>
<body>
<div id="headbar"></div>
<div id="wrapper">
	<div id="header"><div><h1>YaP - Yet Another Pager</h1></div></div>
	<div id="main">
		<div id="nav">
		    <?php
            $cms->nav->menu();
            ?>
		</div>
		<div id="content">
		    <?php $cms->page->body(); ?>
		<div style="clear: both;">&nbsp;</div>
		<br/>&nbsp;
		</div>

	</div>
	<div id="footer">&copy; by 9er & Chrischdi</div>
</div>
</body>
</html>

