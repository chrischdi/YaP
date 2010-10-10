<?php

include("inc/nav.php");

class AdminNav extends Nav{
	
	// $sitemap == array(array(id, title), ...)
	var $sitemap;
	var $itemcounter;
	
	function AdminNav() {
		// old (in class Nav):
		// $this->sitemap = $db->getSitemap();
		
		$this->sitemap = array();
		// navigation-elements
		$this->sitemap[] = array("general", "general");
		$this->sitemap[] = array("page", "pages");
		$this->sitemap[] = array("user", "users");
		
		$this->itemcounter = 0;
	}
	
	
	// function-override for links
	
	function menu() {	// ToDo: import template for navigation, before, in and/or after link
		foreach($this->sitemap as $page) {
			echo "<a href=\"?edit=".$page[0]."\">".htmlentities($page[1])."</a>\n";
		}
	}
	
	function itemLink() {
		echo "<a href=\"?edit=".$this->sitemap[$this->itemcounter][0]."\">".htmlentities($this->sitemap[$this->itemcounter][1])."</a>";
	}
	
	function itemUrl() {
		echo "?edit=".$this->sitemap[$this->itemcounter][0];
	}

}

?>
