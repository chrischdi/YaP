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
        echo $id;
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

	function setContentTitle($id, $string){
        $string = $this->xml->createCDATASection($string);
		$nodenew = $this->xml->createElement('title');
		$nodenew->appendChild($string);
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName('title')->item(0);
		$content->replaceChild($nodenew, $node);
	}

	function setContentAuthor($id, $string){
        $string = $this->xml->createCDATASection($string);
		$nodenew = $this->xml->createElement('author');
		$nodenew->appendChild($string);
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName('author')->item(0);
		$content->replaceChild($nodenew, $node);
	}
	
	function setContentType($id, $string){
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName('type')->item(0);
		$node->nodeValue = $string;
	}

    function setContentMain($id, $string){
        $string = $this->xml->createCDATASection($string);
		$nodenew = $this->xml->createElement('main');
		$nodenew->appendChild($string);
		$content = $this->xml->getElementByID($id);
		$node = $content->getElementsByTagName('main')->item(0);
		$content->replaceChild($nodenew, $node);
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
