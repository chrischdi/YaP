<?php

// "plugin" for plain html-formatted text
// returns main as it is as page-body
// returns empty header

class IframePlugin {
	
	function parseBody($main) {
		return "<iframe src=\"".$main."\">".$main."</iframe>";
	}
	
	function parseHead($main) {
		return;
	}
}

// add plugin-object
$PLUGINS["iframe"] = new IframePlugin();
