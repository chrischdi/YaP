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

echo "<br><br>get all ->db->getNextAsLink()<br>&nbsp;";
while ($cms->nav->getNextAsLink()) { echo "<br>\n&nbsp;"; }

echo "<br><br>get all ->db->getNextTitle()<br>&nbsp;";
while ($cms->nav->getNextTitle()) { echo "<br>\n&nbsp;"; }

echo "<br><br>get all ->db->getNextId()<br>&nbsp;";
while ($cms->nav->getNextId()) { echo "<br>\n&nbsp;"; }

?></tt></body></html>
