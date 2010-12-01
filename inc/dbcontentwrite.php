<?php

require_once('inc/dbcontent.php');

class DbContentWrite extends DbContent {
    
	// getMain is here, because it will be used in page administration only
	function getMain($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {

			return $content->getElementsbyTagname('main')->item(0)->nodeValue;
		}
	}
	
	// Building a complete content node without content. Creates the content ID by "a$timestamp "
    function createContent(){
        $id = "a".time();
        $doc = $this->xml->getElementsByTagName('database')->item(0);
        
        // Create parent element
        $content = $this->xml->createElement('content');
        
        // Create child elements
        $title = $this->xml->createElement('title');
        $author = $this->xml->createElement('author');
        $type = $this->xml->createElement('type');
        $main = $this->xml->createElement('main');
        
        // Set parent's attributes
        $content->setAttribute('xml:id', $id);
        $content->setAttribute('restriction', null);// ToDo
        $content->setAttribute('visible', 'false'); //standard setting is false.
        
        // Append childs
        $content->appendChild($title);
        $content->appendChild($author);
        $content->appendChild($type);
        $content->appendChild($main);
        $doc->appendChild($content);
        
        return $id;
    }

    // setter for content. This are executed after createContent or if the content gets modified.
    function setContentTitle($id, $string){
        $this->setNodeCData($id, $string, 'title');
    }

	function setContentAuthor($id, $string){
        $this->setNodeCData($id, $string, 'author');
	}
	
	function setContentType($id, $string){
        $this->setNode($id, $string, 'type');
	}

    function setContentMain($id, $string){
        $this->setNodeCData($id, stripslashes($string), 'main');
	}
	
    // setter for website information
    function setWebsiteTitle($string){
        $this->setNodeCData('default', $string, 'title');
    }

    function setWebsiteDomain($string){
        $this->setNodeCData('default', $string, 'domain');
    }

    function setWebsiteWebmaster($string){
        $this->setNodeCData('default', $string, 'webmaster');
    }

	// overwrite function to get entries with attribute visible="false"
	function getSitemap() {
		$sitemap = array();
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content) {
			// add an array to $sitemap for each page, containing id and title
			$sitemap[] = array($content->getAttribute('xml:id'), $content->getElementsByTagName('title')->item(0)->nodeValue);
		}
		return $sitemap;
	}
}

?>
