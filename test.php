<html><body><tt><?php

include("inc/cms.php");

echo "platzhalter-test<br>****************";

echo "<br><br>cms->website->title()<br>&nbsp;";
$cms->website->title();

echo "<br><br>cms->website->domain()<br>&nbsp;";
$cms->website->domain();

echo "<br><br>cms->website->webmaster()<br>&nbsp;";
$cms->website->webmaster();

echo "<br><br>cms->page->title()<br>&nbsp;";
$cms->page->title();

echo "<br><br>cms->page->id()<br>&nbsp;";
$cms->page->id();

echo "<br><br>cms->nav->menu()<br>&nbsp;";
$cms->nav->menu();

echo "<br><br>cms->page->body()<br>&nbsp;";
$cms->page->body();

echo "<br><br>TESTING<br>db->getPageIdByTitle('Home')<br>&nbsp;";
$db = new Db();
echo $db->getPageIdByTitle('Home');

echo "<br><br>get all: ->nav->itemId() - ->nav->itemTitle() - ->nav->itemUrl()<br>&nbsp;";
do {
	$cms->nav->itemId();
	echo " - ";
	$cms->nav->itemTitle();
	echo " - ";
	$cms->nav->itemUrl();
	echo "<br>\n&nbsp;";
} while ($cms->nav->getNext());

?></tt></body></html>
