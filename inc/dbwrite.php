<?

// Include Website
include("inc/db.php");

class DbWrite extends Db {
    function saveXML() {
		$database = "xml/db2.xml"; //for testing time, later it will get the $database value, wich $db->getXML(); is using.
		$this->xml->save($database);
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
}

?>
