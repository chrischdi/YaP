<?

include("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminPage extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	var $main;
	var $type;
	
	function AdminPage($db) {
		// get page-id and check if page exists
		if (isset($_GET['id']) AND $db->isPage($_GET['id'])) {
			
			// get page contents
			$this->id = $_GET['id'];
			$this->title = $db->getPageTitle($this->id);
			$this->author = $db->getPageAuthor($this->id);
			$this->main = $db->getMain($this->id);
			$this->type = $db->getType($this->id);
			
			// build form
			$ret = "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\">";
			$ret .= "<h2>Title</h2>";
			$ret .= "<input type=\"text\" name=\"title\" value=\"".$this->title."\">";
			// plugin stuff
			global $PLUGINS;
			$ret .= $PLUGINS[$this->type]->getEditorBody($this->main);
			$ret .= "</form>";
			$this->body = $ret;
		}
		else {
			// show list of pages
			$this->id = "";
			$this->title = "page overview";
			$this->author = "";
			$this->body = "<tt>TODO: PAGE LIST</tt>"; // ToDo
			$this->head = "";
		}
	}
}

?>
