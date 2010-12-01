<?php

require_once("inc/db.php");

class DbUser extends Db {
	
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
        $this->setNodeCData($id, stripslashes($string), 'name');
    }

    function setUserPassword($id, $string){
        $this->setNode($id, md5($string), 'password');
    }

    function setUserRights($id, $string){
        $this->setNodeCData($id, $string, 'rights');
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
	
	function validateUser($username, $password) {
		$nodes = $this->xml->getElementsByTagName('user');
		foreach($nodes as $user) {
			if ($user->getElementsByTagName('name')->item(0)->nodeValue == $username) {
				if ($user->getElementsByTagName('password')->item(0)->nodeValue == md5($password)) return True;
				else return False;
			}
		}
	}
}

?>

