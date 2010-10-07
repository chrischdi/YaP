<?
// Include plugins (all files in inc/plugins/)
foreach(glob("inc/plugins/*.php") as $filename) include($filename);

// include Db
include("inc/dbwrite.php");

// Include Nav
include("inc/nav.php");

// Include Page
include("inc/page.php");

// Include Website
include("inc/website.php");

class Backend {
	function Backend() {
		// get database
		$db		= &new DbWrite();
		$this->nav = &new Nav($db);
		$this->website	= &new Website($db);
		$this->page	= &new Page($db);
	}
}

$be = &new backend();

?>
