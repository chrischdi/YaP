<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 transitional//DE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<!-- 
** This is YaP - Yet another Pager
** Yet another Pager is a content management system without a (common) database.
** It uses xml-files to save it's content.
** We are aviable on http://github.com/chrischdi/YaP
-->


<style type="text/css">
* {
    border: 0px;
}

#header, #headbar {
    height: 95px;
}

#wrapper {
    margin-top: -95px;
    margin-right: auto;
    margin-bottom: 0;
	margin-left: auto;
	width: 960px;
}

html, body {
	height: 100%;
	margin: 0;
	padding: 0;
	font-family: sans-serif,verdana;
}

#headbar {
	background-color:#3B5998;
	width:100%
	left: 0;
}

#header {
	text-align: center;
	width: 960px;
	color: #ffffff;
}

#header div {
	padding: 5px;
}

#header h1 a:link, #header h1 a:visited, #header h1 :hover, #header h1 a:active {
        margin: 0 2px;
	    color: #ffffff;
	    text-decoration:none;
}

#nav {
    margin-top: -23px;
}

#main {
	margin: 10px 0;
	width: 960px;
	border-bottom: 2px groove #3B5998;
}

#content {
	width: 960px;
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

#nav a:link, #nav a:visited, #nav a:hover, #nav a:active {
    margin: 0 2px;
	color: #eeeeee;
	text-decoration:none;
}
#nav a:hover {
	color: #ffffff;
	text-decoration: underline;
}

iframe {
    width: 100%;
    min-height: 510px;
    height: auto !important;
    height: 510px;
}
</style>
<?php include "inc/cms.php"; ?>
<title><?php $cms->website->title(); ?> - <?php $cms->page->title(); ?></title>
</head><body>
<div id="headbar"></div>
<div id="wrapper">
	<div id="header">
	    <div>
	        <h1><a href="<?php $cms->website->domain(); ?>"><?php $cms->website->title(); ?></a></h1>
	        <div id="nav">
<?php $cms->nav->menu(); ?>
	        </div>
	    </div>
	</div>
	<div id="main">
		<div id="content">
<?php $cms->page->body(); ?>
            <div style="clear: both;">&nbsp;</div>
		<br>&nbsp;
		</div>
	</div>
	<div id="footer">&copy; by 9er &amp; Chrischdi</div>
</div>
</body></html>
