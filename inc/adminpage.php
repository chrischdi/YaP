<?php

require_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminPage extends Page {
	
	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
	
	function AdminPage($db, $dbnav) {
		
		// handle _POST
		if ($_POST and ($_POST['edit'] == "page") and ($_POST['delete'] == "true")) {
	//do Delete a Node
			if((isset($_POST['id'])) and ($_POST['id'] !== "new")) {
				$id = $_POST['id'];
			}
			$db->deleteContent($id);
			$dbnav->deleteContent($id);
			// save changes
			$db->saveXML();
			$dbnav->saveXML();
		}
		elseif ($_POST and ($_POST['edit'] == "page")) {
       		$parentid = $_POST['pid'];
			if ($_POST['id'] == "new") {
	//do initiate new content in dbnav and db
				// get new id that's not in db already
				$id = $db->createContent();
                $dbnav->createItem($parentid, $id);
    			$db->setContentAuthor($id, $_SESSION['username']);
			}
			else {
				$id = $_POST['id'];
			}
			
	//write contents
			if (isset($_POST['visible']) and ($_POST['visible'] == "true")) {
				$visible = "true";
			}
			else $visible = "false";
			
			$db->setAttribute($id, $visible, "visible");
			
			$db->setContentTitle($id, $_POST['title']);
			$db->setContentType($id, $_POST['type']);
			// ToDo: get from _SESSION: $db->setContentAuthor($id, ... );
			global $PLUGINS;
			$db->setContentMain($id, $PLUGINS[$_POST['type']]->getMain($_POST));
			
			$dbnav->modifyItem($id, $_POST['title'], $visible);
			// save changes
			$db->saveXML();
			$dbnav->saveXML();
		}
		
		// get page-id and check if page exists
		if (isset($_GET['id']) and ($_GET['id'] !== "new" and ($_GET['action'] == "delete"))) {
	//delete Content
			// get page contents
			$this->id = $_GET['id'];
			$id = $this->id;
			$this->title = $db->getPageTitle($id);

			// delete question
		    $ret = "<span id=\"AdminPage\"\n>";
			$ret .= "<h1>Delete Page</h1>\n";
			$ret .= "<p>Do you realy want to delete the &quot;".htmlentities($this->title)."&quot; page?</p>\n";
			$ret .= "<p>Every subcontent will also be deleted!</p>\n";
			$ret .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"delete\" value=\"true\">";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$id."\">\n";
			$ret .= "<input type=\"submit\" value=\"Ja\">\n";
			$ret .= "</form>\n";
    		$ret .= "</span>\n";
			$this->body = $ret;
		}
		elseif (isset($_GET['id']) and ($_GET['id'] !== "new")) {
	//edit content
			// get page contents
			$this->id = $_GET['id'];
			$id = $this->id;
			$this->title = $db->getPageTitle($id);
			$main = $db->getMain($id);
			$type = $db->getType($id);
			$this->author = $db->getPageAuthor($id);

			// build form
/*		    $ret = "<span id=\"AdminPage\"\n>";
			$ret .= "<h1>Edit Page</h1>\n";
			$ret .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";*/
			if ($db->isPage($id)) $checked = " checked=\"checked\""; // only true, if page is visible
			else $checked = "";
/*			$ret .= "<input type=\"checkbox\" name=\"visible\" value=\"true\"".$checked.">&nbsp;visible\n";
			$ret .= "<h2>Title</h2>";
			$ret .= "<input type=\"text\" name=\"title\" value=\"".$this->title."\">";
			$ret .= "<h2>Author</h2>\n";
			$ret .= "<p>".$this->author."</p>\n";getSitemap()
			$ret .= "<input type=\"hidden\" name=\"type\" value=\"".$type."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$id."\">\n";*/
			// plugin stuff
			global $PLUGINS;
			$ret .= $PLUGINS[$type]->getEditorBody($main, $this->id, $this->title, $type, $checked);
/*			$ret .= "<input type=\"submit\" value=\"save\">\n";
			$ret .= "</form>\n";*/
    		$ret .= "</span>\n";
			$this->body = $ret;
			$this->head = $PLUGINS[$type]->getEditorHead($main);
		}
		elseif ($_GET['id'] == "new") {
			
			// create empty form
			$this->id = "new";
			$this->title = "new page";
			
			// build form
		    
			$ret = "<span id=\"AdminPage\"\n>";
			/*
			$ret .= "<h1>New Page</h1>\n";
			$ret .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$ret .= "<input type=\"checkbox\" name=\"visible\" value=\"true\">&nbsp;visible\n";
			$ret .= "<h2>Title</h2>\n";
			$ret .= "<input type=\"text\" name=\"title\" value=\"\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"type\" value=\"".$_GET['type']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"".$this->id."\">\n";*/
			// plugin stuff
			global $PLUGINS;
			$ret .= $PLUGINS[$_GET['type']]->getEditorBody("", $this->id, $this->title, $_GET['type']);
			/*$ret .= "<input type=\"submit\" value=\"create\">\n";
			$ret .= "</form>\n";*/
    		$ret .= "</span>\n";
			$this->body = $ret;
			$this->head = $PLUGINS[$_GET['type']]->getEditorHead("");
		}
		else {
			// show list of pages
			$this->id = "";
			$this->title = "page overview";
			$this->author = "";
			$this->head = "";
			$dbnav->showinvisible = true;
			$sitemap = $dbnav->getSitemap();
		    $ret = "<span id=\"AdminPage\"\n>";
			$ret .= "<h2>List Of Pages</h2>\n";
			$ret .= '<table class="pages">';
function echoSitemap($sitemap, $issubnode=false, $depth=1){	
/*
	$ret = '<ul>';
		foreach ( $sitemap as $node) {
		$ret .= '<li><a href="#">';
		$ret .= $node['title'].' - '. $node['id'];
		$ret .= '</a><br>';
		if(is_array($node['childnodes']))	$ret .= echoSitemap($node['childnodes']);
		$ret .= '</li>';
	}
	$ret .= '</ul>';
*/
		foreach ( $sitemap as $node) {
		
			//var_dump($node);
			$padding = $depth * 8;
			if($issubnode) $addstyle = ' style="padding-left: '.$padding.'px;"';
			$ret .= '<tr><td id="item-name"'.$addstyle.'>'.$node['title'].' - '. $node['id'].'</td>';
			$ret .= '<td id="edit-button"><a href="?edit=page&id='. $node['id'].'">EDIT</a></td>';
			$ret .= '<td id="delete-button"><a href="?edit=page&id='. $node['id'].'&action=delete">DEL</a></td>';

			$ret .= '<td id="Append CD">';
			$ret .= '<form method="get" action="'.$_SERVER['REQUEST_URI'].'">';
			$ret .= '<input type="hidden" name="edit" value="page">';
			$ret .= '<input type="hidden" name="pid" value="'.$node['id'].'">';
			$ret .= '<input type="hidden" name="id" value="new">';
			$ret .= '&nbsp;New Page: type: ';
			$ret .= '<select name="type">';
			global $PLUGINS;
			foreach(array_keys($PLUGINS) as $type) {
				$ret .= "<option>".$type."</option>";
			}
			$ret .= '</select>';
			$ret .= '<input type="submit" value="APPEND">';
			$ret .= '</form>';
			$ret .= '</td>';
			$ret .= '</tr>';

			if(isset($node['childnodes']))	{
			$ret .= echoSitemap($node['childnodes'], true, $depth+1);
			}
		}
	return $ret;
}
		//echo sizeof($sitemap[1]['childnodes']);
//		var_dump($sitemap);
		$ret .= echoSitemap($sitemap);
		$ret .= '</table>';
		//var_dump($sitemap);
			/*
			foreach($sitemap as $page) {
				$ret .= "<tr>";
				// Title
				$ret .= "<td id=\"item-name\">".htmlentities($page[1])."</td>";
				// edit-button
				$ret .= "<td id=\"edit-button\"><a href=\"?edit=page&id=".$page[0]."\">EDIT</a></td>";
				// delete-button
				$ret .= "<td id=\"delete-button\"><a href=\"?edit=page&id=".$page[0]."&action=delete\">DELETE</a></td>";

			
				$ret .= "<td id=\"Append CD\">";
			$ret .= "<form method=\"get\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"new\">\n";
			$ret .= "<input type=\"hidden\" name=\"pid\" value=\"".$page[0]."\">\n";
			$ret .= "&nbsp;New Page: Type: <select name=\"type\">\n";
			global $PLUGINS;
			foreach(array_keys($PLUGINS) as $type) {
				$ret .= "<option>".$type."</option>\n";
			}
			$ret .= "</select>\n";
			$ret .= "<input type=\"submit\" value=\"APPEND\">\n";
			$ret .= "</form></td>\n";


				$ret .= "</tr>\n";
			}
			$ret .= "</tr></table>\n";
			*/
			
			// new page
			$ret .= "<form method=\"get\" action=\"".$_SERVER['REQUEST_URI']."\">\n";
			$ret .= "<input type=\"hidden\" name=\"edit\" value=\"page\">\n";
			$ret .= "<input type=\"hidden\" name=\"id\" value=\"new\">\n";
			$ret .= "<input type=\"hidden\" name=\"pid\" value=\"database\">\n";
			$ret .= "<h2>New Page</h2>\nType: <select name=\"type\">\n";
			global $PLUGINS;
			foreach(array_keys($PLUGINS) as $type) {
				$ret .= "<option>".$type."</option>\n";
			}
			$ret .= "</select>\n";
			$ret .= "<input type=\"submit\" value=\"create new page\">\n";
			$ret .= "</form>\n";
    		$ret .= "</span>\n";
			
			$this->body = $ret;
			$this->head = "";
		}
		$dbnav->getSitemap();
	}
}

?>
