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
	
	function getEditorBody($main) {
		// ToDo: return html to edit the iframe-url
		return "<h2>Iframe URL</h2><input type=\"text\" name=\"iframe-url\" value=\"".$main."\"><br>\n";
	}
	
	function getEditorHead($main) {
		return;
	}
}

// add plugin-object
$PLUGINS["iframe"] = new IframePlugin();
