<?php
require_once("inc/dbnavwrite.php");

class Nav {
	
	// $sitemap == array(array(id, title), ...)
	var $sitemap;
	var $itemcounter;
	var $mainNavItems = array();
	
	function Nav($db) {
	    $db2 = new DbNav("xml/content.xml");
//		var_dump($db2);
	    $mainnode = $db2->getMainNav();
$mainnode = $mainnode->childNodes;
//$mainnode = $mainnode->getElementsByTagName('item');
	    foreach($mainnode as $node) {
			if($node->tagName == "item") {
				$node = new NavItem ($node);
				$this->mainNavItems[] = $node;
			 }
	    }
		$this->sitemap = $db2->getSitemap();
	}
	

	function echoSitemap($sitemap) {
		$ret = '<ul>';
		//var_dump($sitemap);
		//echo '<br><br>';
			foreach ( $sitemap as $node) {
			$ret .= '<li><a href="?id='.$node['id'].'">';
			$ret .= $node['title'];
			$ret .= '</a><br>';
			if(isset($node['childnodes']))	$ret .= $this->echoSitemap($node['childnodes']);
			$ret .= '</li>';
		}
		$ret .= '</ul>';
		return $ret;
	}
	
	function menu() {
		echo $this->echoSitemap($this->sitemap);
	}
	
}

class NavItem {
	
	var $title;
	var $id;
	var $url;
	var $isParent;
	var $nodes;
	var $position;
	var $visible;
	
	function NavItem($node, $position = 0) {
		// get item-stuff from xml-node
		$this->id = $node->getAttribute('xml:id'); // reference to content-id
		$this->visible = $node->getAttribute('visible'); // reference to content-id
		$this->title = $node->getElementsByTagName('title')->item(0)->nodeValue; // content title
		$this->position = $position + 1;
		$this->nodes = array();
//		if ($node->getElementsByTagName('item') !== NULL) {
		$this->isParent = False;
		foreach ($node->childNodes as $item) {
			if(($item->tagName == "item") and ($item->getAttribute('visible') == "true")) {
				$this->nodes[] = new NavItem($item, $this->position);
    			$this->isParent = True; // has child elements
			}
		}
			
//		}
//		else $this->isParent = False; // has no child elements
	}
	
	function getNavItem () {
	    if($this->visible == "true"){
		    $ret = "<li class=\"nav".$this->position."\"><a href=\"?id=".$this->id."\">".$this->title."</a>\n";
		    if($this->isParent){
			    $ret .= "<ul class=\"submenu\">";
			    foreach($this->nodes as $node) {
				    $ret .= $node->getNavItem();
			    	$ret .= "</ul>\n";
			    }
		    }
		    $ret .= "</li>\n";
		    return $ret;
        }
        return;
	}
	
}

?>
