<?php
session_start();

// Include plugins (all files in inc/plugins/)
foreach(glob("inc/plugins/*.php") as $filename) include($filename);

// include Db
include("inc/dbwrite.php");
include("inc/dbuser.php");

include("inc/adminnav.php");
include("inc/website.php");
include("inc/adminlogin.php");
include("inc/admingeneral.php");
include("inc/adminpage.php");
include("inc/adminuser.php");
include("inc/adminbrowser.php");


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
