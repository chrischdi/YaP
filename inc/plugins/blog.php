<?php

require_once("inc/dbwrite.php");
require_once("inc/plugins/html.php");

class DbBlog extends dbwrite {

    var $path;

    function saveXML() {
		$database = $this->path;
		$this->xml->save($database);
		unset($this->xml);
		$this->xml = $this->getXML();
	}

    function createContent(){
        $id = "b".time();
        $doc = $this->xml->getElementsByTagName('database')->item(0);
        
        // Create parent element
        $content = $this->xml->createElement('content');
        
        // Create child elements
        $title = $this->xml->createElement('title');
        $author = $this->xml->createElement('author');
        $main = $this->xml->createElement('main');
        
        // Set parent's attributes
        $content->setAttribute('xml:id', $id);
        $content->setAttribute('date', date('d.m.Y, H:i'));
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

    function DbBlog ($path) {
        $this->path = $path;
		$this->xml = $this->getxml();
    }

	function getxml(){
		$database = $this->path;
		if (file_exists($database)){
			$doc = new DOMDocument();
            $doc->validateOnParse = true;
			$doc->load($database);
			return $doc;
		}
		else echo "Database doesn't exist.";
	}
	
	function getPageMain($id) {
		$content = $this->xml->getElementByID($id);
		if(isset($content)) return $content->getElementsByTagName('main')->item(0)->nodeValue;
        	else return false;
	}
	
	function getSitemap() {
		$sitemap = array();
		$contents = $this->xml->getElementsByTagName('content');
		foreach($contents as $content) {
			// add an array to $sitemap for each page, containing id and title
			if ($content->getAttribute('visible') == "true") {
				$sitemap[] = array($content->getAttribute('xml:id'), $content->getElementsByTagName('title')->item(0)->nodeValue, $content->getElementsByTagName('main')->item(0)->nodeValue, $content->getElementsByTagName('author')->item(0)->nodeValue, $content->getAttribute('date'));
			}
		}
		return $sitemap;
	}
}

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class BlogPlugin {

    var $db;

	function getBody($main) {
        $this->db = &new DbBlog($main);
	    $sitemap = $this->db->getSitemap();
	    $sitemap = array_reverse ($sitemap);
	    $db = new Db();
        $heading = $db->getPageTitle($_GET['id']);
        $ret = "<h1>".$heading."</h1>\n";

	    foreach ($sitemap as $site) {
	        $ret .= "<span class=\"blogEntry\">\n";
            $ret .= "<h2>".$site[1]."</h2>\n";
            $ret .= "<p>".$site[2]."</p>\n";
            $ret .= "<p style=\"font-size: 0.7em; color: #aaaaaa;\">Author: ".$site[3]." | ".$site[4]." Uhr</p>\n";
	        $ret .= "</span>\n";
	    }
		return $ret;
	}
	
	function getHead($main) {
	}
	
	function getMain($post) {
		return $post['main'];
	}
	
	function getEditorBody($main) {

		if($_POST['id'] and ($_GET['do'] == "edit") ) {
       		$this->db = &new DbBlog($main);
	        $sitemap = $this->db->getSitemap();
	        $sitemap = array_reverse ($sitemap);
	        
		    if($_POST['id'] == "new") {
		        $id = $this->db->createContent();
    			$this->db->setContentAuthor($id, $_SESSION['username']);
		    }
		    else $id = $_POST['id'];
		    
		    if (isset($_POST['visible']) and ($_POST['visible'] == "true")) {
				$this->db->setAttribute($id, "true", "visible");
			}
			else $this->db->setAttribute($id, "false", "visible");
			
			$this->db->setContentTitle($id, $_POST['title']);
			$this->db->setContentMain($id, $_POST['main']);
			// save changes
			$this->db->saveXML();
		    
		    return "<h2>The content has been saved succesfull!</h2>";
		} elseif ($_GET['do'] and $_GET['do'] !== "edit") {
    		$this->db = &new DbBlog($main);
		    if ($_GET['do'] !== "new") {
		        $id = $_GET['do'];
                $heading = $this->db->getPageTitle($id);
            }
		    else {
		        $id = "new";
		        $heading;
            }
            if ($this->db->isPage($id)) $checked = " checked=\"checked\""; // only true, if page is visible
			else $checked = "";
			if(!$this->db->getPageMain($id)){}else $content = $this->db->getPageMain($id);
            $ret = "<form method=\"post\" action=\"".$_SERVER['self']."?edit=page&id=".$_GET['id']."&do=edit\">";
            $ret .= "<input type=\"checkbox\" name=\"visible\" value=\"true\"".$checked.">&nbsp;visible";
            $ret .= "<h2>Title</h2><input type=\"text\" name=\"title\" value=\"".$heading."\">";
            $ret .= "<h2>Author</h2><p>".$_SESSION['username']."</p>";
            $ret .= "<input type=\"hidden\" name=\"id\" value=\"".$id."\">";
            $ret .= "<textarea name=\"html-content\">".$content."</textarea>";
            $ret .= "<input type=\"submit\" value=\"save\">";

		    return $ret;
		
		} else {
            $this->db = &new DbBlog($main);
	        $sitemap = $this->db->getSitemap();
	        $sitemap = array_reverse ($sitemap);
            
            $ret = "<h1>".$heading."</h1>\n";
                $ret .= "<p style=\"color: #000000;\"><span style=\"float: right;\"><a href=\"".$_SERVER['PHP_SELF']."?edit=".$_GET['edit']."&id=".$_GET['id']."&do=new\">ADD ENTRY</a></span></p>\n";
                $ret .= "<span style=\"display: block; border-bottom: 1px solid #aaaaaa;\">&nbsp;<br/>&nbsp;</span>";
	        foreach ($sitemap as $site) {
	            $ret .= "<span style=\"display: block; border-bottom: 1px solid #aaaaaa;\" class=\"blogEntry\">\n";
                $ret .= "<h2>".$site[1]."</h2>\n";
                $ret .= "<p style=\"color: #000000;\">";
                $ret .= "<span style=\"text-align: left;\">";
                $ret .= "Author: ".$site[3]." | Created: ".$site[4]."</span>";
                $ret .= "<span style=\"float: right;\"><a href=\"".$_SERVER['PHP_SELF']."?edit=".$_GET['edit']."&id=".$_GET['id']."&do=".$site[0]."\">EDIT</a> | DELETE</span>";
                $ret .= "</p>\n";
                $ret .= "<p style=\"font-size: 0.8em;\">".$site[2]."</p>\n";
	            $ret .= "<br/></span>\n";
	        }
	        
	        $ret .= "<br/><p>Ignore the following Save Button. Later it'll be removed.</p>";
	        
		    return $ret;
/*
"<form method=\"post\" action=\"/~user/YaP/admin.php\"><input type=\"checkbox\" name=\"visible\" value=\"true\" checked=\"checked\">&nbsp;visible
<h3>Title</h3><input type="text" name="title" value="html-demo"><h2>Author</h2>
<p>someone</p>
<input type="hidden" name="type" value="html">
<input type="hidden" name="edit" value="page">
<input type="hidden" name="id" value="a1286461109">
<h3>Content</h3><textarea name=\"html-content\"><h1>html</h1></textarea><br>
<input type="submit" value="save">
</form>
*/
		}
	}
	
    function getEditorHead($main) {
		$ret = "";
		if($this->tinymceAviable() == true) {
			$ret =  "<script type=\"text/javascript\" src=\"".$this->tinymcePath."tiny_mce.js\"></script>\n";
			$ret .= "<script type=\"text/javascript\">\n";
			$ret .= "tinyMCE.init({\n";
			$ret .= "	theme : \"advanced\",\n";
			$ret .= "	mode : \"textareas\",\n";
			$ret .= "   plugins : \"template,advimage,\",\n";
			$ret .= $this->getTMCEinitaddition();
			$ret .= "   theme_advanced_statusbar_location : \"bottom\",\n";
			$ret .= "   theme_advanced_resizing : true,\n";
			$ret .= "   theme_advanced_buttons3_add : \"fullpage\"\n";
			$ret .= "});\n";
			$ret .= $this->getJSaddition();
			$ret .= "</script>\n";
		}
		return $ret;
	}
	
	var $tinymcePath = 'jscripts/tiny_mce/';
	var $browserPath = 'jscripts/tiny_mce/plugins/browser/browser.php';
	
	function browserAviable() {
		if (file_exists($this->browserPath)) return true;
		else return false;
	}

	function getTMCEinitaddition() {
		if($this->browserAviable() == true) {
			$ret .= "	file_browser_callback : \"myCustomFileBrowser\",\n";
			return $ret;
		}
		else return;
	}
	
	function getJSaddition() {
		if($this->browserAviable() == true) {
			$ret .= "function myCustomFileBrowser(field_name, url, type, win) {\n";
			$ret .= "   FileWindow=win;\n";
			$ret .= "   window.open('../browser/browser.php?type=' + type,'Assets','scrollbars=yes,width=600,height=600');\n";
			$ret .= "}\n";
			$ret .= "function CallBackReturn(field_name, url){\n";
			$ret .= "  FileWindow.document.forms[0].elements[field_name].value =url ;\n";
			$ret .= "}\n";
			return $ret;
		}
		else return;
	}
	
	function tinymceAviable() {
		if (file_exists($this->tinymcePath.'tiny_mce.js')) return true;
		else return false;
	}
	
}

// add plugin-object
$PLUGINS["blog"] = new BlogPlugin();
