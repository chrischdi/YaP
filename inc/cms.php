<?php
// Include plugins (all files in inc/plugins/)
require_once("inc/plugins/plugin.php");
foreach(glob("inc/plugins/*.php") as $filename) require_once($filename);

// Include Db
require_once("inc/dbcontent.php");

// Include Nav
require_once("inc/nav.php");

// Include Page
require_once("inc/page.php");

// Include Website
require_once("inc/website.php");

class Cms {
	var $dbPath = "xml/db.xml";
	/*
	*  Class for main cms functions (reading and serving content)
	*  Status: created function stubs
	*   for funcitons defined in
	*   docs/template-elements.txt
	*/
	
	var $website;	// stores (static) website information
	var $nav;	// stores navigation-elements
	var $page;	// stores information about current site
	var $main;	// stores main content
	
	// not declared - will be used in constructor only
	// var $db;	// database
	
	function Cms() {
		
		// get database
		$db		= &new DbContent($this->dbPath);

		// get instances of container-classesp
		$this->website	= &new Website($db);
		$this->nav	= &new Nav($db);
		$this->page	= &new Page($db);
	}

}

$cms = &new Cms();

?>
