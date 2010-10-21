<?php include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminBrowser extends Page {

	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
    var $path = "img";

	function AdminBrowser($db) {
	    $dir = $_GET['dir'];
	    $this->path .= $dir;
        $handle = openDir($this->path);
        $dirs = null;
        $files = null;
        $ret = "<h1>Browser</h2>\n";
        $ret .= "<a href=\"".$_SERVER['PHP_SELF']."?edit=browser&dir=".dirname($dir)."\">BACK</a>\n";
        $ret .= "<table class=\"general\">\n";
        $ret .= "    <tr><th>Name</th><th class=\"right\">Size</th></tr>\n";
        while ($file = readdir($handle)) {
            if(is_dir($this->path."/".$file) and $file !== "." and $file !== ".."){
                $dirs .= "    ";
                $dirs .= "<tr class=\"dir\">";
                $dirs .= "<td>";
                $dirs .= "<a href=\"".$_SERVER['PHP_SELF']."?edit=browser&dir=".$dir."/".$file."\">";
                $dirs .= $file;
                $dirs .= "</a>";
                $dirs .= "<td class=\"right\"></td>";
                $dirs .= "</tr>\n";
            }elseif (!is_dir($this->path."/".$file)) {
                $files .= "    ";
                $files .= "<tr>";
                $files .= "<td>";
                $files .= $file;
                $files .= "</td>";
                $files .= "<td class=\"right\">";
                $files .= $this->format_bytes(filesize($this->path."/".$file));
                $files .= "</td>";
                $files .= "</tr>\n";
            }
        }
        $ret .= $dirs;
        $ret .= $files;
        $ret .= "</table>\n";
        $this->body = $ret;
        $this->head = $this->getHead();
	}

	function format_bytes($bytes) {
        if ($bytes < 1024) return $bytes.' B';
        elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
        elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
        elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
        else return round($bytes / 1099511627776, 2).' TB';
    }

	function getHead() {
        $ret = "<style type=\"text/css\">\n";
        $ret .= ".general td {\n";
        $ret .= "	border-top:1px solid black;\n";
        $ret .= "	border-bottom:1px solid black;\n";
        $ret .= "}\n";
        $ret .= "table.general {\n";
        $ret .= "	border-collapse:collapse;\n";
        $ret .= "}\n";
        $ret .= "td{\n";
        $ret .= "    padding: 0 3px;\n";
        $ret .= "}\n";
        $ret .= "td.right, th.right{\n";
        $ret .= "    text-align: right;\n";
        $ret .= "}\n";
        $ret .= "td, th{\n";
        $ret .= "    text-align: left;\n";
        $ret .= "}\n";
        $ret .= "table .dir{\n";
        $ret .= "    background-color:#dddddd;\n";
        $ret .= "}\n";
        $ret .= "</style>\n";
        return $ret;
	}
}
?>
