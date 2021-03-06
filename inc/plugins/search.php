<?php

/*
*  simple search plugin, checks title and main-content of pages and lists them
*  still needs a lot of improvements
*/

class SearchPlugin {
	
	function getBody($main) {
		if (!$_POST OR $_POST['action'] !== "search") return "<form method=\"post\" action=\"".$_SERVER['REQUEST_URI']."\"><input type=\"text\" name=\"q\"><input type=\"hidden\" name=\"action\" value=\"search\"><input type=\"submit\" value=\"go\" name=\"submit\"></form>";
		else {
			$db = new Db();
			$word = $_POST['q'];
			
			// check every <content><main> for seach-string
			$sitemap = $db->getSitemap();
			$hits = array();
			$ret = "<ul>";
			foreach($sitemap as $page) {
				if ( (strpos($page[1], $word) !== False) OR ($db->strInMain($page[0], $word)) ) {
					$hits[] = $page;
				}
			}
			foreach($hits as $hit) {
				$ret .= "<li><a href=\"?id=".$hit[0]."\">".htmlentities($hit[1])."</a></li>";
			}
			$ret .= "</ul>";
			return $ret;
		}
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		return;
	}
	
	function getEditorBody($main) {
		return;
	}
	
	function getEditorHead($main) {
		return;
	}
	
}

$PLUGINS['search'] = new SearchPlugin();

?>
