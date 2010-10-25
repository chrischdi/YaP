<?php

class Nav {
	
	// $sitemap == array(array(id, title), ...)
	var $sitemap;
	var $itemcounter;
	
	function Nav($db) {
		$this->sitemap = $db->getSitemap();
		$this->itemcounter = 0;
	}
	
	function menu() {	// ToDo: import template for navigation, before, in and/or after link
		foreach($this->sitemap as $page) {
			echo "<a href=\"?id=".$page[0]."\">".htmlentities($page[1])."</a>\n";
		}
	}
	
	function getNext() {
		if ($this->itemcounter < (sizeof($this->sitemap) - 1)) {
			$this->itemcounter++;
			return True;
		}
		else {
			$this->itemcounter = 0;
			return False;
		}
	}
	
	function itemLink() {
		echo "<a href=\"?id=".$this->sitemap[$this->itemcounter][0]."\">".htmlentities($this->sitemap[$this->itemcounter][1])."</a>";
	}
	
	function itemUrl() {
		echo "?id=".$this->sitemap[$this->itemcounter][0];
	}
	
	function itemTitle() {
		echo htmlentities($this->sitemap[$this->itemcounter][1]);
	}
	
	function itemId() {
		echo $this->sitemap[$this->itemcounter][0];
	 }
}

?>
