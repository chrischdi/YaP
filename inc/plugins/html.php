<?php

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class HtmlPlugin {
	
	function parseBody($main) {
		return $main;
	}
	
	function parseHead($main) {
		return;
	}
}

// add plugin-object
$PLUGINS["html"] = new HtmlPlugin();
