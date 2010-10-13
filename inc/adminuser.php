<?

include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminUser extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function AdminUser($db) {
		
		$dbuser		= &new DbUser();
		
		// handle _POST
		if ($_POST and ($_POST['edit'] == "user")) {
			if ($_POST['id'] == "new") {
				// get new id that's not in db already
				$id = $dbuser->createUser();
			}
			else {
				$id = $_POST['id'];
			}
			
			$dbuser->setUserName($id, $_POST['name']);
			$dbuser->setUserRights($id, $_POST['rights']);
			if ($_POST['password'] !== "") $dbuser->setUserPassword($id, $_POST['password']);
			
			// save changes
			$dbuser->saveXML();
		}
		
		// get page-id and check if page exists
		if (isset($_GET['id']) and ($_GET['id'] !== "new")) {
			
			// get page contents
			$this->id = $_GET['id'];
			$id = $this->id;
			$this->title = $dbuser->getUserName($id);
			$this->author = "";
			$name = $dbuser->getUserName($id);
			$rights = $dbuser->getUserRights($id);
			
			// build form
			$ret = "<h1>Edit User</h1>\n";
			$ret .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"><table class=\"user\">";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$id."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"user\">\n";
			$ret .= "<tr><td id=\"item-name\">Name</td><td><input type=\"text\" name=\"name\" value=\"".$name."\"></td></tr>\n";
			$ret .= "<tr><td id=\"item-name\">Rights</td><td><input type=\"text\" name=\"rights\" value=\"".$rights."\"></td></tr>\n";
			$ret .= "<tr><td id=\"item-name\">Name</td><td><input type=\"password\" name=\"password\" value=\"\"></td></tr>\n";
			$ret .= "<tr><td id=\"item-name\"></td><td><input type=\"submit\" value=\"save\"></td></tr>\n";
			$ret .= "</table></form>";
			$this->body = $ret;
			$this->head = "";
		}
		elseif ($_GET['id'] == "new") {
			
			// create empty form
			$this->id = "new";
			$this->title = "new page";
			$this->author = ""; // ToDo
			
			// build form
			$ret = "<h1>New Page</h1>\n";
			$ret = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$ret .= "<input type=\"checkbox\" name=\"visible\" value=\"true\">&nbsp;visible\n";
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
			$this->title = "user overview";
			$this->author = "";
			$this->head = "";
			
			$users = $dbuser->getUsers();
			$ret = "<h1>List Of Users</h1>\n<table class=\"users\">";
			foreach($users as $user) {
				$ret .= "<tr>";
				// Title
				$ret .= "<td id=\"item-name\">".htmlentities($user[1])."</td>";
				// edit-button
				$ret .= "<td id=\"edit-button\"><a href=\"?edit=user&id=".$user[0]."\">EDIT</a></td>";
				// delete-button
				$ret .= "<td id=\"delete-button\">DELETE</td>";
				$ret .= "</tr>\n";
			}
			$ret .= "</tr></table>\n";
			
			// new page
			$ret .= "<form method=\"get\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"user\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"new\">\n";
			$ret .= "<h2>New User</h2>\n";
			$ret .= "<input type=\"submit\" value=\"create new user\">\n";
			$ret .= "</form>";
			
			$this->body = $ret;
			$this->head = "";
		}
	}
}

?>
