<?php

require_once("inc/dbnav.php");

class DbNavWrite extends DbNav {

	function modifyItem($id, $title, $visible=false){
		if($this->xml->getElementByID($id) !== null){
			$node = $this->xml->getElementByID($id);
			// set new title
			$this->setNodeCData($id, $title, 'title');
			// change the parameter visible
			$node->setAttribute('visible', $visible);
		}
	}

	function createItem($parentid, $id){
		// Create parent element
        $doc = $this->xml->getElementByID($parentid);
		$content = $this->xml->createElement('item');

		// Create child elements
		$title = $this->xml->createElement('title');

		// Set parent's attributes
		$content->setAttribute('xml:id', $id);
		$content->setAttribute('restriction', null);// ToDo
		$content->setAttribute('visible', 'false'); //standard setting is false.

		// Append childs
		$content->appendChild($title);
		$doc->appendChild($content);
        $this->saveXML();
		return $id;
    }

}

?>
