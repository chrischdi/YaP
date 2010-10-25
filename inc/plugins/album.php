<?php

// "plugin" for albums

class AlbumPlugin {

    var $maxLength = "250"; //in pixels

    function getLongerSide($width, $height) {
        if($width > $height) return "w";
        elseif($height > $width) return "h";
        else return false;
    }
    
    function getPaddings($width, $height) {
        if($this->getLongerSide($width, $height) == "w") {
            $Paddings = ($this->maxLength - round($height / $width * $this->maxLength)) / 2;
            return $Paddings."px 0px";
        } else {
            $Paddings = ($this->maxLength - round($width / $height * $this->maxLength)) / 2;
            return "0px ".$Paddings."px";
        }
    }

	function getBody($main, $id) {
        $db = new Db();
        $heading = $db->getPageTitle($id);
        $ret = "<h1>".$heading."</h1>";
	    if(is_dir($main)) {
		    $handle = openDir($main);
            while ($file = readdir($handle)) {
                if(!is_dir($main."/".$file)){
                    list($width, $height, $type, $attr) = getImageSize($main."/".$file);
                    $style = "style=\"";
                    if($this->getLongerSide($width, $height) == "w") $style .= "width";
                    else $style .= "height";
                    $style .= ": ".$this->maxLength."px; ";
                    $style .= "padding: ".$this->getPaddings($width, $height)."; \"";
                    $ret .= "<div style=\"";
                    $ret .= "height: ".$this->maxLength."px;";
                    $ret .= "float:left;";
                    $ret .= "margin:5px;";
                    $ret .= "\">\n";
                    $ret .= "<a href=\"#\" onclick=\"javascript:foo=window.open('".$main."/".$file."','Album','') \">\n";
                    $ret .= "<img ".$style."src=\"".$main."/".$file."\"></img>\n";
                    $ret .= "</a>\n";
                    $ret .= "</div>\n";
                }
            }
        } else {
            $ret .= "<h2>ERROR:</h2>";
            $ret .= "<p>The Path given is not a valid Directory.</p>";
            $ret .= "<p>Check the entry in the Admin Panel!</p>";
        }
		return $ret;
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		return $post['album-url'];
	}
	
	function getEditorHead($main) {
		return;
	}
	
	function getEditorBody($main) {
		return "<h2>Album URL</h2><input type=\"text\" name=\"album-url\" value=\"".$main."\"><br>\n";
	}
}

// add plugin-object
$PLUGINS["album"] = new AlbumPlugin();
