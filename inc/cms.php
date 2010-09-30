<?
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
			$sitemap[] = array($content->getAttribute('id'), $content->getElementsByTagName('title')->item(0)->nodeValue);
		}
		return $sitemap;
	}
	
	
	function isPage($id) {
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content) {
			if ($content->getAttribute('id') == $id) return True;
		}
		return False;
	}
	
	function getPageTitle($id) {
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content){
			if( $content->getAttribute('id') == $id) {
				if($content->getAttribute('visible') == "true") {
					$title = $content->getElementsByTagName('title')->item(0)->nodeValue;
					break;
				}
			}
		}
		return $title;
	}
	
	function getPageBody($id) {
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content){
			if( $content->getAttribute('id') == $id) {
				if($content->getElementsByTagName('type')->item(0)->nodeValue == "html") {
					if($content->getAttribute('visible') == "true") {
						return $content->getElementsByTagName('main')->item(0)->nodeValue;
						break;
					}
					// else { ToDo: GoTo id="0" (home) or return error message }
				}
				// else { ToDo: Plugins! }
			}
		}
	}
	
	function getPageIdByTitle($title) {
		
		$contents = $this->xml->getElementsByTagName('content');
		$id = -1;
		
		foreach($contents as $content){
			if( $content->getElementsByTagName('title')->item(0)->nodeValue == $title) {
				$id = $content->getAttribute('id');
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
	
	function Nav($db) {
		$this->sitemap = $db->getSitemap();
	}
	
	function menu() {	// ToDo: import template for navigation, before, in and/or after link
		foreach($this->sitemap as $page) {
			echo "<a href=\"?id=".$page[0]."\">".$page[1]."</a><br>\n";
		}
	}
	
}


// ToDo: class for site elements (information about current page
class Page {
	
	var $title;
	var $id;
	var $body;
	
	function Page($db) {
		// get page-id and check if page exists
		if (isset($_GET['id']) AND $db->isPage($_GET['id'])) $this->id = $_GET['id'];
		else $this->id = 0; // home
		
		$this->title = $db->getPageTitle($this->id);
		$this->body = $db->getPageBody($this->id);
	}
	
	function title() {
		echo $this->title;
	}
	
	function id() {
		echo $this->id;
	}
	
	function body() {
		echo $this->body;
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

		// get instances of container-classes
		$this->website	= &new Website($db);
		$this->nav	= &new Nav($db);
		$this->page	= &new Page($db);
	}

}

$cms = &new Cms();

?>
