<?
// Include plugins (all files in inc/plugins/)
foreach(glob("inc/plugins/*.php") as $filename) include($filename);

// include Db
include("inc/dbwrite.php");

include("inc/adminnav.php");
include("inc/website.php");
include("inc/admingeneral.php");
include("inc/adminpage.php");
//include("inc/adminuser.php");


class AdminPanel {
	
	
	function AdminPanel() {
		// get database
		$db		= &new DbWrite();
		
		$this->nav	= &new AdminNav(); // no db here, static navigation in admin-panel
		$this->website	= &new Website($db);
		
		// if _POST, set _GET to suitable overview-page
		// _POST-data will be handled by $this->page (constructor)
		if ($_POST) {
			switch ($_POST['edit']) {
				case "page":
					unset($_GET);
					$_GET['edit'] = "page";
					break;
				//case "user":
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
			// ~ToDo~
			//case "user":
			//	$this->page = &new AdminUser($db);
			//	break;
			//case "general":
			//	$this->page = &new AdminGeneral($db);
			//	break;
			default:
				$this->page = &new AdminGeneral($db);
				break;
		}
	}
}

$ap = &new AdminPanel();

?>
