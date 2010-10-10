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
include "inc/adminpanel.php";
?>
<title>Backend - <?php $ap->website->title(); ?> - <?php $ap->page->title(); ?></title>
<?php $ap->page->head(); ?>
</head>
<body>
<div>
<?php
$ap->nav->menu();
?>
</div>
<div>
<?php
$ap->page->body();
?>
</div>
</body>
</html>

