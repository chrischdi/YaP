<?

// Include Website
include("inc/db.php");

class DbWrite extends Db {
    
    var $error = "Error! Call an issue at www.github.com/chrischdi/YaP";
    
    function saveXML() {
		$database = "xml/db.xml";
		$this->xml->save($database);
		unset($this->xml);
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
        $content->setAttribute('visible', 'false');
        
        // Append childs
        $content->appendChild($title);
        $content->appendChild($author);
        $content->appendChild($type);
        $content->appendChild($main);
        $doc->appendChild($content);
        
        return $id;
    }

    function setNodeCData($id, $string, $part){
    	if($this->xml->getElementByID($id) !== null) {
            $string = $this->xml->createCDATASection($string);
	        $nodenew = $this->xml->createElement($part);
	        $nodenew->appendChild($string);
	        $content = $this->xml->getElementByID($id);
	        $node = $content->getElementsByTagName($part)->item(0);
	        $content->replaceChild($nodenew, $node);
        }
        else {
            echo $this->error;
            exit;
        }
    }

	function setNode($id, $string, $part){
    	if($this->xml->getElementByID("asd") !== null) {
        	$content = $this->xml->getElementByID($id);
		    $node = $content->getElementsByTagName($part)->item(0);
		    $node->nodeValue = $string;
        }
        else {
            echo $this->error;
            exit;
        }
	}

    // setter for content
	function setAttribute($id, $string, $part){
    	if($this->xml->getElementByID($id) !== null) {
		    $content = $this->xml->getElementByID($id);
    		$content->setAttribute($part, $string);
        }
        else {
            echo $this->error;
            exit;
        }
    }
	
	function deleteContent($id){
    	if($this->xml->getElementByID($id) !== null) {
	        $content = $this->xml->getElementByID($id);
            $doc = $this->xml->getElementsByTagName('database')->item(0);
            $doc->removeChild($content);
        }
        else {
            echo $this->error;
            exit;
        }
	}

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
        $this->setNodeCData($id, $string, 'main');
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
