<?

include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminLogin extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function AdminLogin($db) {
		session_unset();
		$this->title = "Login";
		$this->id = "";
		$this->author = "";
		$ret = "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\"><table>\n";
		$ret .= "<tr><td>username</td><td><input type=\"text\" name=\"username\"></td></tr>\n";
		$ret .= "<tr><td>password</td><td><input type=\"password\" name=\"password\"></td></tr>\n";
		$ret .= "<tr><td></td><td><input type=\"submit\" value=\"login\"></td></tr>\n";
		$ret .= "<input type=\"hidden\" name=\"action\" value=\"login\">\n";
		$ret .= "</table></form>";
		$this->body = $ret;
		$this->head = "";
		
	}
}

?>
