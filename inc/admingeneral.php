<?php

include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminGeneral extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function AdminGeneral($db) {
		
		$saved = False;
		
		// handle _POST
		if ($_POST and ($_POST['edit'] == "general")) {
			$db->setWebsiteTitle($_POST['title']);
			$db->setWebsiteDomain($_POST['domain']);
			$db->setWebsiteWebmaster($_POST['webmaster']);
			
			// save changes
			$db->saveXML();
			$saved = True;
		}
		
		// build page
        $ret = "<span id=\"AdminGeneral\"\n>";
		$ret .= "<h1>General Setup</h1>\n";
		if ($saved) {
			// ToDo: print some "page saved successfully"-stuff
			$ret .= "";
		}
		
		$ret .= "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n<table class=\"general\">\n";
		$ret .= "<input type=\"hidden\" name=\"edit\" value=\"general\">\n";
		$ret .= "<h2>Website</h2>
		\n";
		$ret .= "<tr><td id=\"item-name\">Title</td><td><input type=\"text\" name=\"title\" value=\"".$db->getWebsiteTitle()."\"></td></tr>\n";
		$ret .= "<tr><td id=\"item-name\">Domain</td><td><input type=\"text\" name=\"domain\" value=\"".$db->getWebsiteDomain()."\"></td></tr>\n";
		$ret .= "<tr><td id=\"item-name\">Webmaster</td><td><input type=\"text\" name=\"webmaster\" value=\"".$db->getWebsiteWebmaster()."\"></td></tr>\n";
		$ret .= "<tr><td></td><td><input type=\"submit\" value=\"save\"></td></tr>\n";
		$ret .= "</table></form>\n";
		$ret .= "</span>\n";
		$this->body = $ret;
		$this->head = "";
	}
}

?>
