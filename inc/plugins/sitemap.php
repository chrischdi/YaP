<?php

class SitemapPlugin {
	function getBody($main) {
		$tempdb = new Db();
		$tempnav = new Nav($tempdb);
		$sitemap = $tempnav->sitemap;
		$ret = "<h1>Sitemap</h1><ul class=\"sitemap\">";
		foreach($sitemap as $page) {
			$ret .= "<li><a href=\"?id=".$page[0]."\">".htmlentities($page[1])."</a></li>";
		}
		$ret .= "</ul>";
		return $ret;
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		// <main> can stay empty, no information needed here
		return "";
	}
	
	function getEditorBody() {
		// ToDo (?) editor to edit ... well ... nothing really
		return;
	}
	
	function getEditorHead() {
		return;
	}
}

$PLUGINS["sitemap"] = new SitemapPlugin();

?>
