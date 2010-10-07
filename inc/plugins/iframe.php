<?php

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class IframePlugin {
	
	function getBody($main) {
		return "<iframe src=\"".$main."\">".$main."</iframe>";
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		// set url of the iframe as <main>
		return $post['iframe-url'];
	}
	
	function getEditor() {
		// ToDo: return html to edit the iframe-url
		return "";
	}
}

// add plugin-object
$PLUGINS["iframe"] = new IframePlugin();
