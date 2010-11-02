<?php include_once("inc/page.php");

// ToDo: class for site elements (information about current page
class AdminBrowser extends Page {

	var $title;
	var $id;
	var $author;
	var $body;
	var $head;
    var $path = "img";
    var $dir;
    var $err;
    var $ckeckUpload;

    function generateBody () {
        $this->body = "<span id=\"AdminBrowser\">\n";
        $this->body .= $this->getBodyBrowser();
        $this->body .= $this->getBodyUpload();
        $this->body .= "</span>\n";
    }

    function generateHead () {
        $this->head = $this->getHeadBrowser();
        $this->head .= $this->getHeadUpload();
    }

	function AdminBrowser($db) {
        $this->dir = $_GET['dir'];
	    $this->path .= $this->dir;
        if($_GET['do'] == "upload") $this->doUpload();
        $this->generateHead();
        $this->generateBody();
	}

    function getBodyUpload() {
        $ret = "<div class=\"upload\">";
        $ret .= "<h1>Upload</h1>\n";
        if($_GET['do'] == "upload" && $this->ckeckUpload == true){
            if(isset($this->err[0])) {
                foreach($this->err as $error) { $ret .= "<div>".$error."</div>";}
            }
            else $ret .= "Uploaded the files successful";
        }

        $ret .= "<form enctype=\"multipart/form-data\" action=\"".$_SERVER['PHP_SELF']."?edit=browser&dir=".$this->dir."&do=upload\" method=\"post\"> \n";
        $ret .= "<span id=\"forms\" fields=\"1\">\n";
        $ret .= "<div><input type=\"file\" name=\"file[]\"></div>";
        $ret .= "</span>\n";
        $ret .= "<input type=\"button\" onClick=\"addInputFile();\" value=\"Add field\">\n";
        $ret .= "<input type=\"submit\" value=\"upload\">\n";
        $ret .= "</form>\n";
        $ret .= "</div>";
        return $ret;
    }
    
    function doUpload() {
        for ($i = 0; $i < sizeof($_FILES['file']['name']); $i++) {echo $his->path;
            if($this->checkUpload($this->path."/".$_FILES['file']['name'][$i])) $this->copyFile($_FILES['file']['tmp_name'][$i], $this->path."/".$_FILES['file']['name'][$i]);
        }
    }

    function checkUpload($path) {
        $mime = $this->mimetype($path);
        $this->ckeckUpload = true;
        if(file_exists($path)) {
            $this->err[] = "File already exists!";
        }
        
        if($mime !== 'image/png' && $mime !== 'image/gif' && $mime !== 'image/jpeg') {
            $this->err[] = "Not allowed Filetype!";
        }

        if(empty($this->err)) return true;
        else return false;
    }

    function copyFile($nameTemp, $name) {
        if(copy($nameTemp, $name)) return true;
        else return false;
        echo "erledigt";
    }

    function getBodyBrowser() {
        $handle = openDir($this->path);
        $dirs = null;
        $files = null;
        $ret = "<h1>Browser</h2>\n";
        $ret .= "<a mkdir($path, 0775);href=\"".$_SERVER['PHP_SELF']."?edit=browser&dir=".dirname($this->dir)."\">BACK</a>\n";
        $ret .= "<table class=\"general\">\n";
        $ret .= "    <tr><th>Name</th><th class=\"right\">Size</th><th class=\"right\">Actions</th></tr>\n";
        $dirs .= $this->getDirs($handle);
        $files .= $this->getFiles($handle);
        $ret .= $dirs;
        $ret .= $files;
        $ret .= "</table>\n";
        return $ret;
    }
    
    function getDirs ($handle) {
        $dirs = null;
        while ($dir = readdir($handle)) {
            if(is_dir($this->path."/".$dir) and $dir !== "." and $dir !== ".."){
                $dirs .= "<tr class=\"dir\">";
                $dirs .= "<td>";
                $dirs .= "<a href=\"".$_SERVER['PHP_SELF']."?edit=browser&dir=".$this->dir."/".$dir."\">";
                $dirs .= $dir;
                $dirs .= "</a>";
                $dirs .= "<td class=\"right\"></td>";
                $dirs .= "<td class=\"right\">REN CUT DEL</td>";
                $dirs .= "</tr>\n";
                return $dirs;

            }
        }
    }
    
    function getFiles ($handle) {
        $files = null;
        while ($file = readdir($handle)) {
            if (!is_dir($this->path."/".$file)) {
                $files .= "<tr>";
                $files .= "<td>";
                $files .= $file;
                $files .= "</td>";
                $files .= "<td class=\"right\">";
                $files .= $this->format_bytes(filesize($this->path."/".$file));
                $files .= "</td>";
                $files .= "<td class=\"right\">";
                $files .= "REN CUT DEL";
                $files .= "</td>";
                $files .= "</tr>\n";
            }
        }
        return $files;
    }

	function format_bytes($bytes) {
        if ($bytes < 1024) return $bytes.' B';
        elseif ($bytes < 1048576) return round($bytes / 1024, 2).' KB';
        elseif ($bytes < 1073741824) return round($bytes / 1048576, 2).' MB';
        elseif ($bytes < 1099511627776) return round($bytes / 1073741824, 2).' GB';
        else return round($bytes / 1099511627776, 2).' TB';
    }

    function getHeadUpload() {
        $ret = "<script type=\"text/javascript\">\n";
        $ret .= "function addInputFile(){\n";
        $ret .= "    var forms = document.getElementById('forms')\n";
        $ret .= "    var container = document.createElement('div');\n";
        $ret .= "    var field = document.createElement('input');\n";
        $ret .= "    if(Number(forms.getAttribute('fields')) > 5 - 1){\n";
        $ret .= "        alert('Too many fields! Only 5 allowed');\n";
        $ret .= "    }else{\n";
        $ret .= "        field.setAttribute('type','file');\n";
        $ret .= "        field.setAttribute('name','file[]');\n";
        $ret .= "        container.appendChild(field);\n";
        $ret .= "        forms.appendChild(container);\n";
        $ret .= "        forms.setAttribute('fields', Number(forms.getAttribute('fields')) + 1);\n";
        $ret .= "}}\n";
        $ret .= "</script>\n";
        return $ret;
    }

	function getHeadBrowser() {
        $ret = "<style type=\"text/css\">\n";
        $ret .= ".general td {\n";
        $ret .= "	border-top:1px solid black;\n";
        $ret .= "	border-bottom:1px solid black;\n";
        $ret .= "}\n";
        $ret .= "table.general {\n";
        $ret .= "	border-collapse:collapse;\n";
        $ret .= "}\n";
        $ret .= "td, th{\n";
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
	
	function mimetype($filename) {
        // MIME TYPES for file-download http-header
        $mime_types = array(

        'txt' => 'text/plain',
        'nfo' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        '7z' => 'application/x-7z-compressed',
        'nrg' => 'application/octet-stream',

        // audio/video
        'mp3' => 'audio/mpeg',
        'mka' => 'audio/x-matroska',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'avi' => 'video/x-msvideo',
        'mkv' => 'video/x-matroska',
        'mpg' => 'video/mpeg',
        'mpeg' => 'video/mpeg',
        'mpe' => 'video/mpe',
        'mpa' => 'audio/mpeg',
        'm3u' => 'audio/x-mpegurl',


        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );

        $ext = strtolower(array_pop(explode('.',$filename)));
        if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
        }
        else {
                return 'application/octet-stream';
        }
    }
}

class fileAccess {

    var $dirPath;

    function fileAccess ($dirPath) {
        $this->dirPath = $dirPath;
    }

    function checkDir ($path) {
        if(is_dir($path) && $this->validatePath()) return true;
        else return false;
    }

    function validatePath ($path) {
        if (substr_count("/".$path."/.", "/../") == 0) return true;
        else return false;
    }

    function makeDir ($path) {
        if ($this->checkDir($path)) {
            mkdir($path, 0775);
            return true;
        }
        else return false;
    }







}

?>
