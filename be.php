<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 transitional//DE" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- 
** This is YaP - Yet another Pager
** Yet another Pager is a content management system without a (common) database.
** It uses xml-files to save it's content.
** We are aviable on http://github.com/chrischdi/YaP
-->

<html>
<head>
<?php
include "inc/backend.php";
?>
<title>Backend - <?php $be->website->title(); ?> - <?php $be->page->title(); ?></title>

</head>
<body>
<div>
<?php
$be->nav->menu();
?>
</div>
<div>
<?php
$be->page->body();
?>
</div>
</body>
</html>

