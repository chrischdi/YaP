<?php

class SitemapPlugin {
	function parseBody($main) {
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
	
	function parseHead($main) {
		return;
	}
}

$PLUGINS["sitemap"] = new SitemapPlugin();

?>
