<?php

require_once("inc/db.php");

class DbContent extends Db {

	// Getters of the website node
	function getWebsiteTitle() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('title')->item(0)->nodeValue;
	}
	
	function getWebsiteDomain() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('domain')->item(0)->nodeValue;
	}
	
	function getWebsiteWebmaster() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('webmaster')->item(0)->nodeValue;
	}
	
	// Getters of the contents
	function getSitemap() {
		$sitemap = array();
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content) {
			// add an array to $sitemap for each page, containing id and title
			if ($content->getAttribute('visible') == "true") {
				$sitemap[] = array($content->getAttribute('xml:id'), $content->getElementsByTagName('title')->item(0)->nodeValue);
			}
		}
		return $sitemap;
	}
	
	function getPageTitle($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) return $content->getElementsByTagName('title')->item(0)->nodeValue;
        	else return "Fehler in getPageTitle()";
	}
	
	function getPageAuthor($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) return $content->getElementsByTagName('author')->item(0)->nodeValue;
        	else return "Fehler in getPageAuthor()";
	}
	
	function getPageBody($id) {
		global $PLUGINS;
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			$main = $content->getElementsByTagName('main')->item(0)->nodeValue;
			$type = $content->getElementsByTagName('type')->item(0)->nodeValue;
			return $PLUGINS[$type]->getBody($main, $id);
		}
		else return "Fehler in getPageBody()";
	}
	
	function getPageHead($id) {
		global $PLUGINS;
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			$main = $content->getElementsByTagName('main')->item(0)->nodeValue;
			$type = $content->getElementsByTagName('type')->item(0)->nodeValue;
			return $PLUGINS[$type]->getHead($main);
		}
		else return "Fehler in getPageHead()";
		
	}
	
	function getType($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			return $content->getElementsByTagName('type')->item(0)->nodeValue;
		}
	}
	
	//  other functions
	function isPage($id) {
		// returns True if Page exists AND is has attribute visible="true"
		$content = $this->xml->getElementByID($id);
		if((isset($content)) AND ($content->getAttribute('visible') == "true")) return True;
        	else return False;
		
	}
	
	function strInMain($id, $string) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			$main = $content->getElementsByTagName('main')->item(0)->nodeValue;
			if (strpos($main, $string) !== False) return True;
		}
		return False;
	}
	
	function getPageIdByTitle($title) {
		$contents = $this->xml->getElementsByTagName('content');
		$id = -1;
		
		foreach($contents as $content){
			if( $content->getElementsByTagName('title')->item(0)->nodeValue == $title) {
				$id = $content->getAttribute('xml:id');
				break;
			}
		}
		return $id;
	}
}

?>
