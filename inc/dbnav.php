<?php

require_once("inc/db.php");

class DbNav extends Db {
    var $mainNavItems = array();
    var $showinvisible = false;
	
	function getMainNav () {
		$content = $this->xml->getElementsByTagName('database')->item(0);
		return $content;
    }

//    function getSitemap() {
//		$mainnode = $this->getMainNav();
//		$sitemap = $this->getArray($mainnode);
//		var_dump($sitemap);
//	}

function getSitemap() {
	return $this->getArrayNode($this->xml->childNodes->item(0), $this->showinvisible); // later doc to $this->xml and getArrayNode to $this->getArrayNode
}

function getArrayNode($mainNode, $showinvisible) {
	foreach($mainNode->childNodes as $node){
		if(($node->tagName == 'item' and !$showinvisible and $node->getAttribute('visible') == "true") or  ($node->tagName == 'item' and $showinvisible)){
			foreach($node->childNodes as $subnode){
				if($subnode->tagName == 'title') $title = $subnode->nodeValue;
			}
			$id = $node->getAttribute('xml:id');

			$childnodes = $this->getArrayNode($node, $showinvisible);
			if(!is_array($childnodes)){
				$nodearray[] = array('title' => $title,  'id' => $id);
			} else {
				$nodearray[] = array('title' => $title,  'id' => $id, 'childnodes' => $childnodes);
			}
		}
	}
	return $nodearray;
}
	
	function getArray($node) {
		foreach($node->childNodes as $node) {if($node->tagName == "item"){
			// add an array to $sitemap for each page, containing id and title
				if($node->childNodes->length > 1) {
				echo "test<br>";
					foreach($node->childNodes as $subnode) {
						if($subnode->tagName == "item") {$subnodes[] = $this->getArray($subnode);}
					}
				}
				$sitemap[] = array("id" => $node->getAttribute('xml:id'), "title" => $node->getElementsByTagName('title')->item(0)->nodeValue, "nodes" => $subnodes);
		}}

		foreach($sitemap as $site){
			$this->echoArray($site);
		}
		return $sitemap;
	}
	
	function echoArray($node, $count=0){
		echo "<br>newElement:<br>count: ".$count."<br";
		echo "xml:id: ".$node['id']."<br>";
		echo "title: ".$node['title']."<br>";
		if(sizeof($node > 2)) {
			echo "subnodes:".$node['nodes']."<br>";
			var_dump($node['nodes']);
			echo "<br";
			/*
			if(!empty($node['nodes'])){
				foreach($node['nodes'] as $sub) {
					$this->echoArray($sub, $count+1);
					$count = $count+1;
				}
			}*/
		}
	}
}

?>


