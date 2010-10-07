<?
include "cms.php";
unset($cms);

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

class Backend {
	function Backend() {
		// get database
		$db		= &new DbWrite();
		$db->setContentAuthor("b", "chrischdi");
		$db->setContentTitle("b", "chrischdi");
		$db->setContentType("b", "frame");
		$db->setContentMain("b", "chrischdi");
		$db->saveXML();		// get instances of container-classes
		$this->nav = &new Nav($db);
		$this->website	= &new Website($db);
		$this->page	= &new Page($db);
	}
}

$be = &new backend();

?>
