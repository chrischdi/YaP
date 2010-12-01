<?php

require_once("inc/nav.php");

class AdminNav extends Nav{
	
	// $sitemap == array(array(id, title), ...)
	var $sitemap;
	var $itemcounter;
	
	function AdminNav() {
		
		$this->sitemap = array();
		// navigation-elements
		if (isset($_SESSION['username'])) {
			$this->sitemap[] = array("general", "general");
			$this->sitemap[] = array("page", "pages");
			$this->sitemap[] = array("user", "users");
			$this->sitemap[] = array("browser", "browser");
		}
		$this->sitemap[] = array("logout", "logout");
		$this->itemcounter = 0;
	}
	
	
	// function-override for links
	
	function menu() {	// ToDo: import template for navigation, before, in and/or after link
    	echo "<span id=\"AdminNav\">\n";
		foreach($this->sitemap as $page) {
			echo "<a href=\"?edit=".$page[0]."\">".htmlentities($page[1])."</a>\n";
		}
    	echo "</span>\n";
	}
	
	function itemLink() {
		echo "<a href=\"?edit=".$this->sitemap[$this->itemcounter][0]."\">".htmlentities($this->sitemap[$this->itemcounter][1])."</a>";
	}
	
	function itemUrl() {
		echo "?edit=".$this->sitemap[$this->itemcounter][0];
	}

}

?>
