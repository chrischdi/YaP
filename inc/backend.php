<?
include "cms.php";
unset($cms);

class DbWrite extends Db {
    function saveXML() {
		$database = "xml/db2.xml"; //for testing time, later it will get the $database value, wich $db->getXML(); is using.
		$this->xml->save($database);
	}

    function setContentMain($id, $string){ 
        $string = $this->xml->createCDATASection($string);
		$content = $this->xml->getElementByID($id);
		$main = $content->getElementsByTagName('main')->item(0);
		$main->appendChild($string);
		$this->saveXML();   //later it's in the function, executing this function
	}
	
	function setContentTitle($id, $string){
		$content = $this->xml->getElementByID($id);
		$main = $content->getElementsByTagName('title')->item(0);
		$main->nodeValue = $string;
		$this->saveXML();   //later it's in the function, executing this function
	}
}

class Backend {
	function Backend() {
		// get database
		$db		= &new DbWrite();
		// get instances of container-classes
		$this->nav = &new Nav($db);
		$this->website	= &new Website($db);
		$this->page	= &new Page($db);
	}
}

$be = &new backend();

?>
