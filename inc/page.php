<?

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
		else $this->id = $db->getPageIdByTitle('Home'); // home
		
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

?>
