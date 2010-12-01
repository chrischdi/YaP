<?php

class Db {
	
	var $xmlPath;
	var $xml;
	
	// Main functions. Needed at every access to a Db object
	function __construct($xmlPath) {
		$this->xmlPath = $xmlPath;
		$this->xml = $this->getxml();
	}
	
	function getxml(){
		$database = $this->xmlPath;
		if (file_exists($database)){
			$doc = new DOMDocument();
            $doc->validateOnParse = true;
			$doc->preserveWhiteSpace = false;
			$doc->load($database);
			return $doc;
		}
		else {
			echo "Database doesn't exist.";
			return false;
		}
	}
	
	// Setter functions of nodes. (Getters not needed, because of using the standard ones)
	function setNodeCData($id, $string, $part){
    	if($this->xml->getElementByID($id) !== null) {
            $string = $this->xml->createCDATASection($string);
			$nodenew = $this->xml->createElement($part);
			$nodenew->appendChild($string);
			$content = $this->xml->getElementByID($id);
			$node = $content->getElementsByTagName($part)->item(0);
			$content->replaceChild($nodenew, $node);
			return true;
        }
        else return false;
    }

	function setNode($id, $string, $part){
    	if($this->xml->getElementByID($id) !== null) {
        	$content = $this->xml->getElementByID($id);
			$node = $content->getElementsByTagName($part)->item(0);
			$node->nodeValue = $string;
        }
        else return false;
    }

	function setAttribute($id, $string, $part){
    	if($this->xml->getElementByID($id) !== null) {
		    $content = $this->xml->getElementByID($id);
    		$content->setAttribute($part, $string);
        }
        else return false;
    }

	function deleteContent($id){
    	if($this->xml->getElementByID($id) !== null) {
	        $content = $this->xml->getElementByID($id);
            $content->parentNode->removeChild($content);
        }
        else return false;
    }
    
    function saveXML() {
		$database = $this->xmlPath;
		$this->xml->save($database);
		unset($this->xml);
		$this->xml = $this->getXML();
	}
	
}

?>
