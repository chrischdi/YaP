<?

// Include Website
include("inc/db.php");

class DbWrite extends Db {
    function saveXML() {
		$database = "xml/db.xml";
		$this->xml->save($database);
		unset($db->xml);
		$this->xml = $this->getXML();
	}

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
        $content->setAttribute('restriction', null);
        $content->setAttribute('visible', 'true');
        
        // Append childs
        $content->appendChild($title);
        $content->appendChild($author);
        $content->appendChild($type);
        $content->appendChild($main);
        $doc->appendChild($content);
        
        return $id;
    }

    function setContentNodeCData($id, $string, $part){
        $string = $this->xml->createCDATASection($string);
	    $nodenew = $this->xml->createElement($part);
	    $nodenew->appendChild($string);
	    $content = $this->xml->getElementByID($id);
	    $node = $content->getElementsByTagName($part)->item(0);
	    $content->replaceChild($nodenew, $node);
    }

	function setContentNode($id, $string, $part){
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName($part)->item(0);
		$node->nodeValue = $string;
	}
	
	function setContentAttribute($id, $string, $part){
		$content = $this->xml->getElementByID($id);
		$content->setAttribute($part, $string);
    }
	
	function deleteContent($id){
	    $content = $this->xml->getElementByID($id);
        $doc = $this->xml->getElementsByTagName('database')->item(0);
        $doc->removeChild($content);
	}

    function setContentTitle($id, $string){
        $this->setContentNodeCData($id, $string, 'title');
    }

	function setContentAuthor($id, $string){
        $this->setContentNodeCData($id, $string, 'author');
	}
	
	function setContentType($id, $string){
        $this->setContentNode($id, $string, 'type');
	}

    function setContentMain($id, $string){
        $this->setContentNodeCData($id, $string, 'main');
	}
	
	// getMain is here, because it will be used in page administration only
	function getMain($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			return $content->getElementsByTagName('main')->item(0)->nodeValue;
		}
	}
	function getType($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			return $content->getElementsByTagName('type')->item(0)->nodeValue;
		}
	}
}

?>
