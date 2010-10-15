<?php

class TinyMCEPlugin {
    
    var $tinymcePath = 'inc/plugins/jscripts/tiny_mce/tiny_mce.js';

	function getBody() {
		return;
	}
	
	function isAviable() {
	    if (file_exists($this->tinymcePath)) return true;
	    else return false;
	}
	
	function getHead() {
		return;
	}
	
	function getMain() {
		return;
	}
	
	function getEditorBody() {
		return;
	}
	
	function getEditorHead() {
	    if($this->isAviable() == true) {
	        $ret =  "<script type=\"text/javascript\" src=\"".$this->tinymcePath."\"></script>\n";
	        $ret .= "<script type=\"text/javascript\">\n";
	        $ret .= "tinyMCE.init({\n";
	        $ret .= "	theme : \"advanced\",\n";
	        $ret .= "	mode : \"textareas\",\n";
	        $ret .= "   plugins : \"fullpage\,template,advimage,\",\n";
	        $ret .= "   theme_advanced_buttons3_add : \"fullpage\",\n";
	        $ret .= "});\n";
	        $ret .= "</script>\n";
	        echo $ret;
        }
        else return;
	}
}

$PLUGINS["tinymce"] = new TinyMCEPlugin();

?>

