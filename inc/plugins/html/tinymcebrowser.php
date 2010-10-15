<?php

class TinyMCEBrowserPlugin {
    
    var $browser = 'jscripts/tiny_mce/plugins/browser/browser.php';

	function isAviable() {
	    if (file_exists($this->browser)) return true;
	    else return false;
	}

	function getTMCEinitaddition() {
	    if($this->isAviable() == true) {
	        $ret .= "	file_browser_callback : \"myCustomFileBrowser\",\n";
	        return $ret;
        }
        else return;
	}
	
	function getJSaddition() {
	    if($this->isAviable() == true) {
	        $ret .= "function myCustomFileBrowser(field_name, url, type, win) {\n";
	        $ret .= "   FileWindow=win;\n";
	        $ret .= "   window.open('../browser/browser.php?type=' + type,'Assets','width=600,height=600');\n";
	        $ret .= "}\n";
	        $ret .= "function CallBackReturn(field_name, url){\n";
	        $ret .= "  FileWindow.document.forms[0].elements[field_name].value =url ;\n";
	        $ret .= "}\n";
	        return $ret;
        }
        else return;
	}
}

$PLUGINS["tinymcebrowser"] = new TinyMCEBrowserPlugin();

?>

