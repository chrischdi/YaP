<?php

class DbUser {
	
	var $xml;

	function DbUser() {
		$this->xml = $this->getxml();
	}

	function getxml(){
		$database = "xml/user.xml";
		if (file_exists($database)){
			$doc = new DOMDocument();
            $doc->validateOnParse = true;
			$doc->load($database);
			return $doc;
		}
		else echo "Database doesn't exist.";
	}

    function saveXML() {
		$database = "xml/user.xml";
		$this->xml->save($database);
		unset($this->xml);
		$this->xml = $this->getXML();
	}

	function createUser(){
	    $id = "u".time();
        $doc = $this->xml->getElementsByTagName('database')->item(0);
        
        // Create parent element
        $content = $this->xml->createElement('user');
        
        // Create child elements
        $name = $this->xml->createElement('name');
        $password = $this->xml->createElement('password');
        $rights = $this->xml->createElement('rights');
        
        // Set parent's attributes
        $content->setAttribute('xml:id', $id);
        $content->setAttribute('active', 'false');
        
        // Append childs
        $content->appendChild($name);
        $content->appendChild($password);
        $content->appendChild($rights);
        $doc->appendChild($content);
        
        return $id;	
	}

	function getNode($id, $part){
	    $node = $this->xml->getElementByID($id);
		if(isset($node)){
			return $node->getElementsByTagName($part)->item(0)->nodeValue;
		}else{
		    return "Node doesn't exist.";
        }
	}

	function setNode($id, $string, $part){
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName($part)->item(0);
		$node->nodeValue = $string;
	}
	
	function setAttribute($id, $string, $part){
		$content = $this->xml->getElementByID($id);
		$content->setAttribute($part, $string);
    }
	
	function deleteContent($id){
	    $content = $this->xml->getElementByID($id);
        $doc = $this->xml->getElementsByTagName('database')->item(0);
        $doc->removeChild($content);
	}

    function getUserName($id){
        return $this->getNode($id, 'name');
    }

    function getUserPassword($id){
        return $this->getNode($id, 'password');
    }

    function getUserRights($id){
        return $this->getNode($id, 'rights');
    }

    function setUserName($id, $string){
        $this->setNode($id, $string, 'name');
    }

    function setUserPassword($id, $string){
        $this->setNode($id, md5($string), 'password');
    }

    function setUserRights($id, $string){
        $this->setNode($id, $string, 'rights');
    }
    
    	function getUsers() {
		$users = array();
		$nodes = $this->xml->getElementsByTagName('user');
		foreach($nodes as $user) {
			// add an array to $sitemap for each page, containing id and title
			$users[] = array($user->getAttribute('xml:id'), $user->getElementsByTagName('name')->item(0)->nodeValue);
		}
		return $users;
	}
}

?>

