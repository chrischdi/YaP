<?php
require_once("inc/plugins/plugin.php");

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class IframePlugin extends Plugin{
	
	function getBody($main) {
		return "<iframe src=\"".$main."\">".$main."</iframe>";
	}
	
	function getHead($main) {
		return "<link rel=\"stylesheet\" href=\"css/iframe.css\">";
	}
	
	function getMain($post) {
		// set url of the iframe as <main>
		return $post['iframe-url'];
	}
	
	function getEditorBody($main, $id, $title, $type, $checked="") {
	    $this->checked = $checked;
	    $this->type = $type;
	    $this->title = $title;
		$ret;
		$ret .= $this->getStandardFormBeginning();
		$ret .= "<h2>Iframe URL</h2><input type=\"text\" name=\"iframe-url\" value=\"".$main."\"><br>\n";
		$ret .= $this->getStandardFormEnd();
		return $ret;
	}
	
	function getEditorHead($main) {
		return;
	}
}

// add plugin-object
$PLUGINS["iframe"] = new IframePlugin();
