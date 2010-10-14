<?php include("inc/adminpanel.php"); ?>
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
	body {
		font-family:sans;
	}
	div.title {
		position:relative;
		text-align:center;
	}
	div.navi {
		position:relative;
		margin:0px;
		margin-bottom:10px;
		padding:2px 0px 1px 0px;
		border-left:2px solid black;
		border-bottom:2px solid black;
		background-color:#aaaaaa;
	}
	div.body {
		position:relative;
		padding:5px;
		border:1px dotted black;
	}
	
	div.navi ul {
		padding:2px 0px 1px 0px;
		margin:0px;
	}
	
	div.navi li {
		list-style:none;
		display:inline;
		/* margin-right:10px; */
	}

	div.navi a {
		background-color:#aaaaaa;
		text-decoration:none;
		font-size:18px;
		color:#333333;
		letter-spacing:1px;
		border-right:2px solid black;
		padding:2px 4px 1px 4px;
		margin:0px -5px 0px 0px;
	}
	div.navi a:hover {
		background-color:#dddddd;
		/* border:1px solid #222222; */
		color:#222222;
	}
	input[type=text] {
		width:350px;
	}
	input[type=password] {
		width:350px;
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
</style>
<title><?php $ap->website->title(); ?> AdminPanel - <?php $ap->page->title(); ?></title>
<?php $ap->page->head(); ?>
</head>
<body>
<!-- TITLE -->
<div class="title">
<h1><a href="<?php $ap->website->domain(); ?>"><?php $ap->website->title(); ?></a></h1>
</div>

<div class="navi">

<?php

//do {
//	echo "<li>";
//	$cms->nav->itemLink();
//	echo "</li>";
//} while ($cms->nav->getNext());

$ap->nav->menu();

?>

</div>
<div class="body">
<?php $ap->page->body(); ?>
</div>
</body>
</html>
