<?php

// "plugin" for plain html-formatted text
// uses tinymce (if installed)
// returns main as it is as page-body
// returns empty header

class HtmlPlugin {
	
	var $tinymcePath = 'jscripts/tiny_mce/';
	var $browserPath = 'jscripts/tiny_mce/plugins/browser/browser.php';
	
	// <browser>
	
	function browserAviable() {
		if (file_exists($this->browserPath)) return true;
		else return false;
	}

	function getTMCEinitaddition() {
		if($this->browserAviable() == true) {
			$ret .= "	file_browser_callback : \"myCustomFileBrowser\",\n";
			return $ret;
		}
		else return;
	}
	// </browser>
	
	function getJSaddition() {
		if($this->browserAviable() == true) {
			$ret .= "function myCustomFileBrowser(field_name, url, type, win) {\n";
			$ret .= "   FileWindow=win;\n";
			$ret .= "   window.open('../browser/browser.php?type=' + type,'Assets','scrollbars=yes,width=600,height=600');\n";
			$ret .= "}\n";
			$ret .= "function CallBackReturn(field_name, url){\n";
			$ret .= "  FileWindow.document.forms[0].elements[field_name].value =url ;\n";
			$ret .= "}\n";
			return $ret;
		}
		else return;
	}
	
	// </browser>
	// <tinymce>
	
	function tinymceAviable() {
		if (file_exists($this->tinymcePath.'tiny_mce.js')) return true;
		else return false;
	}
	
	// </tinymce>
	
	function getBody($main) {
		return $main;
	}
	
	function getHead($main) {
		return;
	}
	
	function getMain($post) {
		// schoudl be html-formatted already
		return $post['html-content'];
	}
	
	function getEditorBody($main) {
		// ToDo: return an wysiwyg-editor (as html)
		return "<h2>Page Content</h2><textarea name=\"html-content\">".$main."</textarea><br>\n";
	}
	
	function getEditorHead($main) {
		$ret = "";
		if($this->tinymceAviable() == true) {
			$ret =  "<script type=\"text/javascript\" src=\"".$this->tinymcePath."tiny_mce.js\"></script>\n";
			$ret .= "<script type=\"text/javascript\">\n";
			$ret .= "tinyMCE.init({\n";
			$ret .= "	theme : \"advanced\",\n";
			$ret .= "	mode : \"textareas\",\n";
			$ret .= "   plugins : \"template,advimage,\",\n";
			$ret .= $this->getTMCEinitaddition();
			$ret .= "   theme_advanced_statusbar_location : \"bottom\",\n";
			$ret .= "   theme_advanced_resizing : true,\n";
			$ret .= "   theme_advanced_buttons3_add : \"fullpage\"\n";
			$ret .= "});\n";
			$ret .= $this->getJSaddition();
			$ret .= "</script>\n";
		}
		return $ret;
	}
}

// add plugin-object
$PLUGINS["html"] = new HtmlPlugin();
