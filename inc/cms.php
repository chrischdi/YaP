<?
// Include plugins (all files in inc/plugins/)
foreach(glob("inc/plugins/*.php") as $filename) include($filename);

// ToDo
class Db {
	
	var $xml;
	
	function Db() {
		$this->xml = $this->getxml();
	}
	
	function getxml(){
		$database = "xml/db.xml";
		if (file_exists($database)){
			$doc = new DOMDocument();
            $doc->validateOnParse = true;
			$doc->load($database);
			return $doc;
		}
		else echo "Database doesn't exist.";
	}
	
	function getWebsiteTitle() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('title')->item(0)->nodeValue;
	}
	
	function getWebsiteDomain() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('domain')->item(0)->nodeValue;
	}
	
	function getWebsiteWebmaster() {
		$info = $this->xml->getElementsByTagName('website')->item(0);
		return $info->getElementsByTagName('webmaster')->item(0)->nodeValue;
	}
	
	
	function getSitemap() {
		$sitemap = array();
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content) {
			// add an array to $sitemap for each page, containing id and title
			$sitemap[] = array($content->getAttribute('xml:id'), $content->getElementsByTagName('title')->item(0)->nodeValue);
		}
		return $sitemap;
	}
	
	function isPage($id) {
		// returns True if Page exists AND is has attribute visible="true"
		$content = $this->xml->getElementByID($id);
		if((isset($content)) AND ($content->getAttribute('visible') == "true")) return True;
        else return False;
		
	}
	
	function getPageTitle($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) return $content->getElementsByTagName('title')->item(0)->nodeValue;
        else return "Fehler in getPageTitle()";
	}
	
	function getPageAuthor($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) return $content->getElementsByTagName('author')->item(0)->nodeValue;
        else return "Fehler in getPageAuthor()";
	}
	
	function getPageBody($id) {
		global $PLUGINS;
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			$main = $content->getElementsByTagName('main')->item(0)->nodeValue;
			$type = $content->getElementsByTagName('type')->item(0)->nodeValue;
			return $PLUGINS[$type]->getBody($main);
		}
		else return "Fehler in getPageBody()";
	}
	
	function getPageHead($id) {
		global $PLUGINS;
		$content = $this->xml->getElementByID($id);
		if(isset($content)) {
			$main = $content->getElementsByTagName('main')->item(0)->nodeValue;
			$type = $content->getElementsByTagName('type')->item(0)->nodeValue;
			return $PLUGINS[$type]->getHead($main);
		}
		else return "Fehler in getPageHead()";
		
	}
	
	function getPageIdByTitle($title) {
		$contents = $this->xml->getElementsByTagName('content');
		$id = -1;
		
		foreach($contents as $content){
			if( $content->getElementsByTagName('title')->item(0)->nodeValue == $title) {
				$id = $content->getAttribute('xml:id');
				break;
			}
		}
		return $id;
	}
}

// ToDo: class for static website information (like title, domain, webmaster)
class Website {
	
	var $title;
	var $domain;
	var $webmaster;
	// ...
	
	function Website($db) {
		$this->title = $db->getWebsiteTitle();
		$this->domain = $db->getWebsiteDomain();
		$this->webmaster = $db->getWebsiteWebmaster();
	}
	
	function title() {
		
		echo $this->title;
	}
	
	function domain() {
		
		echo $this->domain;
	}
	
	function webmaster() {
		
		echo $this->webmaster;
	}
	function isBackend(){
		$path = Explode('/', $_SERVER['SCRIPT_NAME']);
		$file = $path[count($path) - 1];
		if($file == "backend.php") return true;
		else return false;
	}
}


class Nav {
	
	// $sitemap == array(array(id, title), ...)
	var $sitemap;
	var $itemcounter;
	
	function Nav($db) {
		$this->sitemap = $db->getSitemap();
		$this->itemcounter = 0;
	}
	
	function menu() {	// ToDo: import template for navigation, before, in and/or after link
		foreach($this->sitemap as $page) {
			echo "<a href=\"?id=".$page[0]."\">".htmlentities($page[1])."</a>\n";
		}
	}
	
	function getNext() {
		if ($this->itemcounter < (sizeof($this->sitemap) - 1)) {
			$this->itemcounter++;
			return True;
		}
		else {
			$this->itemcounter = 0;
			return False;
		}
	}
	
	function itemLink() {
		echo "<a href=\"?id=".$this->sitemap[$this->itemcounter][0]."\">".htmlentities($this->sitemap[$this->itemcounter][1])."</a>";
	}
	
	function itemUrl() {
		echo "?id=".$this->sitemap[$this->itemcounter][0];
	}
	
	function itemTitle() {
		echo htmlentities($this->sitemap[$this->itemcounter][1]);
	}
	
	function itemId() {
		echo $this->sitemap[$this->itemcounter][0];
	 }
}


// ToDo: class for site elements (information about current page
class Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function Page($db) {
		// get page-id and check if page exists
		if (isset($_GET['id']) AND $db->isPage($_GET['id'])) $this->id = $_GET['id'];
		else $this->id = "a"; // home
		
		$this->title = $db->getPageTitle($this->id);
		$this->author = $db->getPageAuthor($this->id);
		$this->body = $db->getPageBody($this->id);
		$this->head = $db->getPageHead($this->id);
	}
	
	function title() {
		echo $this->title;
	}
	
	function id() {
		echo $this->id;
	}
	
	function author() {
		echo $this->author;
	}
	
	function body() {
		echo $this->body;
	}
	
	function head() {
		echo $this->head;
	}

}

class Cms {
	
	/*
	*  Class for main cms functions (reading and serving content)
	*  Status: created function stubs
	*   for funcitons defined in
	*   docs/template-elements.txt
	*/
	
	var $website;	// stores (static) website information
	var $nav;	// stores navigation-elements
	var $page;	// stores information about current site
	var $main;	// stores main content
	
	// not declared - will be used in constructor only
	// var $db;	// database
	
	function Cms() {
		
		// get database
		$db		= &new Db();

		// get instances of container-classesp
		$this->website	= &new Website($db);
		$this->nav	= &new Nav($db);
		$this->page	= &new Page($db);
	}

}

$cms = &new Cms();

?>
