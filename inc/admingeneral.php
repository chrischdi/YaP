<?

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
			// ToDo: do some db-stuff
			
			// save changes
			$db->saveXML();
			$saved = True;
		}
		
		// build page
		$ret = "<h1>General Setup</h1>";
		if ($saved) {
			// ToDo: print some "page saved successfully"-stuff
			$ret .= "";
		}
		
		$ret .= "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">\n<table>\n";
		$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
		$ret .= "<tr><th>Website</th><th></th></tr>\n";
		$ret .= "<tr><td>Title</td><td><input type=\"text\" name=\"title\" value=\"".$db->getWebsiteTitle()."\"></td></tr>\n";
		$ret .= "<tr><td>Domain</td><td><input type=\"text\" name=\"domain\" value=\"".$db->getWebsiteDomain()."\"></td></tr>\n";
		$ret .= "<tr><td>Webmaster</td><td><input type=\"text\" name=\"webmaster\" value=\"".$db->getWebsiteWebmaster()."\"></td></tr>\n";
		$ret .= "<tr><td></td><td><input type=\"submit\" value=\"save\"></td></tr>\n";
		$ret .= "</table></form>";
		
		$this->body = $ret;
		$this->head = "";
	}
}

?>
