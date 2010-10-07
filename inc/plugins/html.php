<?php

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class HtmlPlugin {
	
	function getBody($main) {
		return $main;
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		// schoudl be html-formatted already
		return $post['html-content'];
	}
	
	function getEditor() {
		// ToDo: return an wysiwyg-editor (as html)
		return "";
	}
}

// add plugin-object
$PLUGINS["html"] = new HtmlPlugin();
