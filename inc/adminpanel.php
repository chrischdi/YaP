<?
session_start();

// Include plugins (all files in inc/plugins/)
require_once("inc/plugins/plugin.php");
foreach(glob("inc/plugins/*.php") as $filename) require_once($filename);

// include Db
require_once("inc/dbwrite.php");
require_once("inc/dbuser.php");

require_once("inc/adminnav.php");
require_once("inc/website.php");
require_once("inc/adminlogin.php");
require_once("inc/admingeneral.php");
require_once("inc/adminpage.php");
require_once("inc/adminuser.php");
require_once("inc/adminbrowser.php");


class AdminPanel {
	
	
	function AdminPanel() {
		
		$dbuser = &new DbUser();
		
		if (isset($_SESSION['username'])) {
		
			// logout?
			if (isset($_GET['edit']) and ($_GET['edit'] == "logout")) {
				session_unset();
				session_destroy();
			}
		}
		else {
			if ($_POST and ($_POST['action'] == "login")) {
				if ($dbuser->validateUser($_POST['username'], $_POST['password'])) {
					$_SESSION['username'] = $_POST['username'];
					$_GET['edit'] = "general"; // default page after login!
				}
				else unset($_GET); // will set page to AdminLogin (default case in second switch)
			}
			else unset($_GET); // will set page to AdminLogin (default case in second switch)
			unset($_POST);
			
		}
		
		// get database
		$db = &new DbWrite();
		
		// if _POST, set _GET to suitable overview-page
		// _POST-data will be handled by $this->page (constructor)
		if ($_POST) {
			switch ($_POST['edit']) {
				case "page":
					unset($_GET);
					$_GET['edit'] = "page";
					break;
				case "user":
					unset($_GET);
					$_GET['edit'] = "user";
					break;
					
				case "general":
					unset($_GET);
					$_GET['edit'] = "general";
					break;
			}
		}
		
		// nav is static, website reads from db,
		// but page-type depends on _GET
		switch ($_GET['edit']) {
			case "page":
				$this->page = &new AdminPage($db);
				break;
			case "user":
				$this->page = &new AdminUser($db);
				break;
			case "general":
				$this->page = &new AdminGeneral($db);
				break;
			case "browser":
				$this->page = &new AdminBrowser($db);
				break;
			default:
				$this->page = &new AdminLogin($db);
				break;
		}
				
		$this->nav	= &new AdminNav(); // no db here, static navigation in admin-panel
		$this->website	= &new Website($db);
	}
}

$ap = &new AdminPanel();

?>
