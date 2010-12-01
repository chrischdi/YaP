<?php include("inc/adminpanel.php"); ?>
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
}input

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

/*AdminPanel zusatz */

input {
    border:1px solid #aaaaaa;
}

#AdminLogin * input[type=text], #AdminLogin * input[type=password] {
	width:350px;
}

#AdminLogin form table{
    margin: 0 auto;
}

textarea {
	width:350px;
	height:240px;
}

table.pages {
    border-collapse:collapse;
}
.pages #item-name {
    width:130px;
}
.pages #edit-button {
    width:50px;
}
.pages #delete-button {
    width:50px;
}
.pages td {
    border-top:1px solid black;
    border-bottom:1px solid black;
}
table.general {
    border-collapse:collapse;
}
.general #item-name {
    width:130px;
}
table.users {
    border-collapse:collapse;
}
.users #item-name {
    width:130px;
}
.users #edit-button {
    width:50px;
}
.users td {
    border-top:1px solid black;
    border-bottom:1px solid black;
}
table.user {
    border-collapse:collapse;
}
.user #item-name {
    width:130px;
}
.subnode{
padding-left: 10px;
}
.subnode .subnode{
padding-left: 2em;
}



</style>
<title><?php $ap->website->title(); ?> AdminPanel - <?php $ap->page->title(); ?></title>
<?php $ap->page->head(); ?>
</head><body>
<div id="headbar"></div>
<div id="wrapper">
	<div id="header">
	    <div>
	        <h1><a href="<?php $ap->website->domain(); ?>"><?php $ap->website->title(); ?></h1>
	        <div id="nav">
<?php $ap->nav->menu(); ?>
	        </div>
	    </div>
	</div>
	<div id="main">
		<div id="content">
<?php $ap->page->body(); ?>
            <div style="clear: both;">&nbsp;</div>
		<br>&nbsp;
		</div>
	</div>
	<div id="footer">&copy; by 9er &amp; Chrischdi</div>
</div>
</body></html>
