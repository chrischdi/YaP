<?php

class TinyMCEPlugin {
    
    var $tinymcePath = 'jscripts/tiny_mce/';

	function getBody() {
		return;
	}
	
	function isAviable() {
	    if (file_exists($this->tinymcePath.'tiny_mce.js')) return true;
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
	        global $PLUGINS;
	        $ret =  "<script type=\"text/javascript\" src=\"".$this->tinymcePath."tiny_mce.js\"></script>\n";
	        $ret .= "<script type=\"text/javascript\">\n";
	        $ret .= "tinyMCE.init({\n";
	        $ret .= "	theme : \"advanced\",\n";
	        $ret .= "	mode : \"textareas\",\n";
	        $ret .= "   plugins : \"fullpage\,template,advimage,\",\n";
	        $ret .= $PLUGINS['tinymcebrowser']->getTMCEinitaddition();
	        $ret .= "   theme_advanced_buttons3_add : \"fullpage\"\n";
	        $ret .= "});\n";
	        $ret .= $PLUGINS['tinymcebrowser']->getJSaddition();
	        $ret .= "</script>\n";
	        return $ret;
        }
        else return;
	}
}

$PLUGINS["tinymce"] = new TinyMCEPlugin();

?>

