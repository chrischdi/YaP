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
    margin-top: -38px;
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
	color: #eeeeee;
	text-decoration:none;
}
#nav a:hover {
	color: #ffffff;
	text-decoration: underline;
}

iframe {
    width: 100%;
	margin-top: 100px;
    min-height: 510px;
    height: auto !important;
    height: 510px;
}

#nav li {
    margin: 0 6px;
	list-style: none;
    float: left;
}

#nav ul li ul li {
	list-style:decimal outside;
	float: none;
	display: block;
}
#nav {display: inline-block; padding: 0;}
#nav ul ul {
	visibility:hidden;
	background-color: #3B5998;
}

#nav ul {	height: auto;
}

#nav ul li a { text-align: center;}

ul {
	padding: 0px;
	padding-left: 2px;
}

#nav ul li:hover ul {
	visibility: visible;
}

#nav ul li{
	border: 2px none;
}

#nav ul li:hover {
	background-color: #3B5998;

}

#nav ul li {
	position: relative;
}

.nav1 ul {
	padding: 6px;
	position: relative;
}
nav1 ul * {
	padding: 0px;
	position: relative;
}

#nav ul li {
	list-style: none;
    float: left;
	text-align:left;
}

</style>
<script type="text/javascript">
if(window.navigator.systemLanguage && !window.navigator.language) {
  function hoverIE() {
    var LI = document.getElementById("navi").firstChild;
    do {
      if (sucheUL(LI.firstChild)) {
        LI.onmouseover=einblenden; LI.onmouseout=ausblenden;
      }
      LI = LI.nextSibling;
    }
    while(LI);
  }

  function sucheUL(UL) {
    do {
      if(UL) UL = UL.nextSibling;
      if(UL && UL.nodeName == "UL") return UL;
    }
    while(UL);
    return false;
  }

  function einblenden() {
    var UL = sucheUL(this.firstChild);
    UL.style.display = "block"; UL.style.backgroundColor = "silver";
  }
  function ausblenden() {
    sucheUL(this.firstChild).style.display = "none";
  }

  window.onload=hoverIE;
}
</script>

<?php include('inc/cms.php'); ?>
<title><?php $cms->website->title(); ?> - <?php $cms->page->title(); ?></title>
</head><body>
<div id="headbar"></div>
<div id="wrapper">
	<div style="z-index:0;" id="header">
	    <div>
	        <h1><a href="<?php $cms->website->domain(); ?>"><?php $cms->website->title(); ?></a></h1>
		</div>
		<div id="nav">
<?php $cms->nav->menu(); ?>
	        </div>
	</div>
	<div style="z-index:1;" id="main">
		<div id="content">
<?php /* $cms->nav->menu(); */?>
<?php $cms->page->body(); ?>
            <div style="clear: both;">&nbsp;</div>
		<br>&nbsp;
		</div>
	</div>
	<div id="footer">&copy; by 9er &amp; Chrischdi</div>
</div>
</body></html>
