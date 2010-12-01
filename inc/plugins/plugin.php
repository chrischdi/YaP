<?php

// "plugin" for plain html-formatted text
// uses tinymce (if installed)
// returns main as it is as page-body
// returns empty header

class Plugin {

	var $type;	//needs to be set
	var $id;
	var $title;
    var $checked;

	function Plugin () {

	}

	function getBody($main) {
		return;
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		return $post['main'];
	}
	
	function getStandardFormBeginning () {
		$ret;
		$ret .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">\n";
		$checked; //ToDo: function that cheks if visible or not. if visible $ckecked = " checked=\"checked\""
		$ret .= "<input type=\"checkbox\" name=\"visible\" value=\"true\"".$this->checked.">\n";
		$ret .= "&nbsp;visible\n";
		$ret .= "<h2>Title</h2>\n";
		$title; //ToDo: function that sets title if not a new id! --> $title = "content  of the titlenode"
		$ret .= "<input type=\"text\" name=\"title\" value=\"".$this->title."\">\n";
		$ret .= "<input type=\"hidden\" name=\"pid\" value=\"".$_GET['pid']."\">\n";
		$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
		$ret .= "<input type=\"hidden\" name=\"type\" value=\"".$this->type."\">\n";
		$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$_GET['id']."\">\n";
		
		return $ret;
	}

	function getStandardFormEnd () {
		$ret;
		$ret .= "<input type=\"submit\" value=\"create\">\n";
		$ret .= "</form>\n";
		return $ret;
	}

	function getEditorBody($main, $id, $title, $type, $checked="") {
	    $this->checked = $checked;
	    $this->type = $type;
	    $this->title = $title;
		$ret;
		$ret .= $this->getStandardFormBeginning();
		$ret .= "";
		$ret .= $this->getStandardFormEnd();
		return;
	}
	
	function getEditorHead($main) {
		$ret = "";
		return $ret;
	}
}

?>
