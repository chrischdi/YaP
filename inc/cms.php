<?php
// Include plugins (all files in inc/plugins/)
foreach(glob("inc/plugins/*.php") as $filename) if($filename !== "inc/plugins/index.php") require_once($filename);

// Include Db
include("inc/db.php");

// Include Nav
include("inc/nav.php");

// Include Page
include("inc/page.php");

// Include Website
include("inc/website.php");

class Cms {
	
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
		$db		= &new Db();

		// get instances of container-classesp
		$this->website	= &new Website($db);
		$this->nav	= &new Nav($db);
		$this->page	= &new Page($db);
	}

}

$cms = &new Cms();

?>
