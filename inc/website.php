<?

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

?>
