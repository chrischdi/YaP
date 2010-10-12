<?

include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminPage extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function AdminPage($db) {
		
		// handle _POST
		if ($_POST and ($_POST['edit'] == "page")) {
			if ($_POST['id'] == "new") {
				// get new id that's not in db already
				$id = $db->createContent();
			}
			else {
				if ($db->isPage($_POST['id'])) $id = $_POST['id'];
				else die("Failed: Entry not found");
			}
			$db->setContentTitle($id, $_POST['title']);
			$db->setContentType($id, $_POST['type']);
			// ToDo: get from _SESSION: $db->setContentAuthor($id, ... );
			global $PLUGINS;
			$db->setContentMain($id, $PLUGINS[$_POST['type']]->getMain($_POST));
			
			// save changes
			$db->saveXML();
		}
		
		// get page-id and check if page exists
		if (isset($_GET['id']) and ($_GET['id'] !== "new") and $db->isPage($_GET['id'])) {
			
			// get page contents
			$this->id = $_GET['id'];
			$this->title = $db->getPageTitle($this->id);
			$this->author = $db->getPageAuthor($this->id);
			$main = $db->getMain($this->id);
			$type = $db->getType($this->id);
			
			// build form
			$ret = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$ret .= "<h2>Title</h2>";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"type\" value=\"".$type."\">\n";
			$ret .= "<input type=\"text\" name=\"title\" value=\"".$this->title."\">";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$this->id."\">\n";
			// plugin stuff
			global $PLUGINS;
			$ret .= $PLUGINS[$type]->getEditorBody($main);
			$ret .= "<input type=\"submit\" value=\"save\">\n";
			$ret .= "</form>";
			$this->body = $ret;
			$this->head = $PLUGINS[$type]->getEditorHead($main);
		}
		elseif ($_GET['id'] == "new") {
			
			// create empty form
			$this->id = "new";
			$this->title = "new page";
			$this->author = ""; // ToDo
			
			
			// build form
			$ret = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$ret .= "<h2>Title</h2>\n";
			$ret .= "<input type=\"text\" name=\"title\" value=\"\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"type\" value=\"".$_GET['type']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$this->id."\">\n";
			// plugin stuff
			global $PLUGINS;
			$ret .= $PLUGINS[$_GET['type']]->getEditorBody("");
			$ret .= "<input type=\"submit\" value=\"create\">\n";
			$ret .= "</form>";
			$this->body = $ret;
			$this->head = $PLUGINS[$_GET['type']]->getEditorHead("");
		}
		else {
			// show list of pages
			$this->id = "";
			$this->title = "page overview";
			$this->author = "";
			$this->head = "";
			
			$sitemap = $db->getSitemap();
			$ret = "<h2>List of pages</h2>\n<table>";
			foreach($sitemap as $page) {
				$ret .= "<tr>";
				// Title
				$ret .= "<td>".htmlentities($page[1])."</td>";
				// edit-button
				$ret .= "<td><a href=\"?edit=page&id=".$page[0]."\">EDIT</a></td>";
				// delete-button
				$ret .= "<td>DELETE</td>";
				$ret .= "</tr>\n";
			}
			$ret .= "</tr></table>\n";
			
			// new page
			$ret .= "<form method=\"get\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"new\">\n";
			$ret .= "<h2>New Page</h2>\nType: <select name=\"type\">\n";
			global $PLUGINS;
			foreach(array_keys($PLUGINS) as $type) {
				$ret .= "<option>".$type."</option>\n";
			}
			$ret .= "</select>\n";
			$ret .= "<input type=\"submit\" value=\"new\">\n";
			$ret .= "</form>";
			
			$this->body = $ret;
			$this->head = "";
		}
	}
}

?>
