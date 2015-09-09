<?php

/*
        ClassName: FileDisplay

        See readme.txt and manual.txt for more info.

        This version: Greg Lane, 30th December 2003

*/

    class FileDisplay
    {
/*
Public Properties
*/

        var $rootdir;
        var $showperms = false;
        var $showsize = true;
        var $showtype = true;
        var $showmodified = true;
        var $extallow = "php";
        var $arrsortkeys = array("+type","+filename","+filesize");
        var $realtarget ;
        var $tree;
/*
Private Properties
*/

        var $colnum;
        var $arrdircontents = array();

/*
Public Methods
*/

        function FileDisplay($rootdir = "./main")
        {
            $this->rootdir = $rootdir;
            $this->realtarget = substr($rootdir,3,strlen($rootdir));
        }


        function showContents($targetdir)
        {

            $showdir;
            $getrootdir;


            $this->getColNum();

            // The $showdir contains the full path that is displayed at the top of the page
            if(strlen($targetdir) == 0)
            {
                $showdir = $this->rootdir;
                $realtarget = substr($showdir,7,strlen($showdir));
            } else {

                $getrootdir = substr($targetdir, 0, strlen($this->rootdir));

                // This checks to see if the rootdir is a sub string of the target directory
                if($this->rootdir == $getrootdir){
                    $showdir = $targetdir;
                    $realtarget = substr($showdir,7,strlen($showdir));
                } else {
                    $targetdir = $this->rootdir;
                    $showdir = $targetdir;
                    $realtarget = substr($showdir,7,strlen($showdir));
                }
            }
            $this->tree = "<table width='100' bgcolor='#FFFFFF' cellspacing='2' cellpadding='1'>";
            $this->tree .= "<tr>";
            $this->tree .= "<td align='left' colspan='".$this->colnum."'>";
            $this->tree .= "<p>Current directory is: ";
            $this->tree .= $this->dirlinks($realtarget);
            $this->tree .= "</p>";
            $this->tree .= "</td>";
            $this->tree .= "</tr>";
            $this->tree .= "<tr>";
            $this->tree .= "<td bgcolor='#CCCCCC' align='left' colspan='2' width='35%'>";
            $this->tree .= "<font class='theader'>File Name</font>";
            $this->tree .= "</td>";

            if($this->showperms){
                $this->maketableheader("Permissions");
            }
            if($this->showsize){
                $this->maketableheader("File Size");
            }
            if($this->showtype){
                $this->maketableheader("Type");
            }
            if($this->showmodified){
                $this->maketableheader("Date Modified");
            }

            $this->tree .= "</tr>";

            $this->getDirContents($this->rootdir,$targetdir);

            $this->tree .= "</table>";

            ob_start();
            echo $this->tree;
            $html_block = ob_get_contents();
            ob_end_clean();
            return $html_block;


        }

/*
Private Methods
*/

        function getDirContents($docroot,$targetdir)
        {

            $dirempty;		// Holds Boolean true/false depending whether directory is empty or full
            $dir;
            $fullpath;
            $newtargetdir;
            $prevdir;
            $cnt;

            $cnt=0;

            if(strlen($targetdir) == 0)
            {
                $targetdir = $docroot;

            }
            $dirempty = true;
            $dir = opendir($targetdir);
            while ($diritem = readdir($dir)){
                $additem = false;
                $fullpath = $targetdir . "/" . $diritem;
                if(is_file($targetdir . "/" . $diritem)){


                    if($this->checkext($diritem)){
                        $dirempty = false;
                        $newtarget = $targetdir . "/" . $diritem;
                        $additem = true;
                    }


                } elseif(is_dir($targetdir . "/" . $diritem) && ($diritem != ".") && ($diritem != "..")) {

                    $dirempty = false;
                    $newtarget = './index.php?path=./main/security/tm0.security.assign_object.php' . "&activefolder=" . $targetdir . "/" . $diritem;
                    $additem = true;

                }

                if($additem){
                    $this->arrdircontents[] = array(
                                                                "fullpath" => $newtarget,
                                                                "filename" => $diritem,
                                                                "filesize" => filesize($fullpath),
                                                                "type" => filetype($fullpath),
                                                                "fileperms" => $this->convertperms(fileperms($fullpath)),
                                                                "filemodified" => date("Y-m-d H:i:s", filemtime($fullpath)),
                                                                "fileicon" => $this->selectfileicon($diritem,filetype($fullpath))
                    );
                }
            }
            closedir($dir);



            if($dirempty){

                $this->tree .= "<tr>";
                $this->tree .= "<td valign='top' colspan='".$this->colnum."' align='center'>";
                $this->tree .= "Directory is empty<br>";
                $this->tree .= "</td>";
                $this->tree .= "</tr>";

            } else {

                $arrsortkeys = $this->arrsortkeys;

                $this->aasort($this->arrdircontents, array($arrsortkeys));
                $this->printFileInfo($fullpath);

            }

            $prevdir = substr($targetdir, 0, strrpos($targetdir, "/"));


            $this->tree .= "<tr>";
            $this->tree .= "<td valign='top' colspan='".$this->colnum."'>";

            if($targetdir != $this->rootdir)
            {

                $this->tree .= "<font class='itemtext'><a href='./index.php?path=./main/security/tm0.security.assign_object.php&activefolder='".htmlspecialchars($prevdir)."'>BACK</a></font>";

            } else {
                $this->tree .= "&nbsp;";
            }

            $this->tree .= "</td>";
            $this->tree .= "</tr>";

        }


        function printFileInfo($fullpath)
        {
            // declare variables for this function

            foreach($this->arrdircontents as $sdiritem){


                $this->tree .= "<tr>";
                $this->tree .= "<td valign='top' align='centre'><a href='".$sdiritem["fullpath"]."'><img src='".$sdiritem["fileicon"]."' border='0'></a></td>";
                $this->tree .= "<td valign='middle'><font class='itemtext'>";
                $this->tree .= "<a href='./index.php?path=./main/security/tm0.security.add_object.php&filename={$sdiritem["fullpath"]}'>";
                $this->tree .= htmlspecialchars($sdiritem["filename"])."</a>";
                $this->tree .= $this->arrdircontents["filename"] ."</font></td>";

            if($this->showperms){
                $this->maketablecell($sdiritem["fileperms"]);
            }
            if($this->showsize){
                $this->maketablecell($this->convertFileSize($sdiritem["filesize"]));
            }
            if($this->showtype){
                $this->maketablecell($sdiritem["type"]);
            }
            if($this->showmodified){
                $this->maketablecell($sdiritem["filemodified"]);
            }

            $this->tree .= "</tr>";

        }
    }

    function maketablecell($cellcontent)
    {
        $this->tree .= "<td valign='middle'><font class='itemtext'>";
        $this->tree .= htmlspecialchars($cellcontent);
        $this->tree .= "</font></td>";
    }


    function maketableheader($cellcontent)
    {
        $this->tree .= "<td valign='middle' bgcolor='#CCCCCC'><font class='theader'>";
        $this->tree .= htmlspecialchars($cellcontent);
        $this->tree .= "</font></td>";
    }


    function getColNum()
    {
        $this->colnum = 2;
        if($this->showsize){
            $this->colnum += 1;
        }
        if($this->showtype){
            $this->colnum += 1;
        }
        if($this->showmodified){
            $this->colnum += 1;
        }
        if($this->showperms){
            $this->colnum += 1;
        }
    }


    function aasort(&$array, $args) {
        foreach($args as $arg) {
            $order_field = substr($arg, 1, strlen($arg));
            foreach($array as $array_row) {
                $sort_array[$order_field][] = $array_row[$order_field];
            }
            $sort_rule .= '$sort_array['.$order_field.'], '.($arg[0] == "+" ? SORT_ASC : SORT_DESC).',';
        }
        eval ("array_multisort($sort_rule".' $array);');
    }


    function convertPerms($inperms)
    {
        $permstr;   // holds the 'rwxrwxrwx' style permission string to be returned

        if($inperms & 0x1000)     // FIFO pipe
        $permstr = 'p';
        elseif($inperms & 0x2000) // Character special
        $permstr = 'c';
        elseif($inperms & 0x4000) // Directory
        $permstr = 'd';
        elseif($inperms & 0x6000) // Block special
        $permstr = 'b';
        elseif($inperms & 0x8000) // Regular
        $permstr = '-';
        elseif($inperms & 0xA000) // Symbolic Link
        $permstr = 'l';
        elseif($inperms & 0xC000) // Socket
        $permstr = 's';
        else                         // UNKNOWN
        $permstr = 'u';

        // owner
        $permstr .= (($inperms & 0x0100) ? 'r' : '-') .
        (($inperms & 0x0080) ? 'w' : '-') .
        (($inperms & 0x0040) ? (($inperms & 0x0800) ? 's' : 'x' ) :
            (($inperms & 0x0800) ? 'S' : '-'));

        // group
        $permstr .= (($inperms & 0x0020) ? 'r' : '-') .
        (($inperms & 0x0010) ? 'w' : '-') .
        (($inperms & 0x0008) ? (($inperms & 0x0400) ? 's' : 'x' ) :
            (($inperms & 0x0400) ? 'S' : '-'));

        // world
        $permstr .= (($inperms & 0x0004) ? 'r' : '-') .
        (($inperms & 0x0002) ? 'w' : '-') .
        (($inperms & 0x0001) ? (($inperms & 0x0200) ? 't' : 'x' ) :
            (($inperms & 0x0200) ? 'T' : '-'));
        return $permstr;
    }

    function convertFileSize($inbytes)
    {
        if($inbytes < 1000){
            return $inbytes . " bytes" ;
        }
        if($inbytes >= 1000)
        {
            return number_format($inbytes) . " KB";
        }


    }


    function checkext($inputstr){
        if(strlen($this->extallow) > 0){
            $inputstrlen = strlen($inputstr);
            $revstr = strrev($inputstr);
            $cutstr = $inputstrlen - strpos($revstr,".");
            $inputsubstr = strtolower(substr($inputstr,$cutstr,$inputstrlen));

            $arrExtAllow = explode(",", strtolower($this->extallow));
            $extpass = false;

            foreach($arrExtAllow as $sExt){
                if($sExt == $inputsubstr){
                    return true;
                    $extpass = true;
                }
            }

            if($extpass == false)
            {
                return false;
            }
        } else {
            return true;
        }
    }

    function dirlinks($indirlinks)
    {
        $lastdir;
        $end;
        $i;
        $output;
        $arrDirLinks;
        $dirlink;

        $arrDirLinks = explode("/",$indirlinks);
        $end=count($arrDirLinks);
        $i=0;

        foreach($arrDirLinks as $dirlink){

            $i = $i + 1;

            if($i == 1){
                $lastdir = $dirlink;
            } else {
                $lastdir = $lastdir . "/" . $dirlink;
            }

            if ($i == $end){
                if($i == 1){
                    $output = $dirlink;
                } else {
                    $output = $output . "/" . $dirlink;
                }
            } else {
                if($i == 1) {
                    $output = $output . "<a href='" . $PHP_SELF . "?activefolder=" . $lastdir . "'>" . $dirlink . "</a>";
                } else {
                    $output = $output . "/<a href='" . $PHP_SELF . "?activefolder=" . $lastdir . "'>" . $dirlink . "</a>";
                }
            }
        }
        return $output;
    }

    function selectfileicon($inputstr,$inputtype)
    {
        if($inputtype != "dir"){
            $inputstrlen = strlen($inputstr);
            $revstr = strrev($inputstr);
            $cutstr = $inputstrlen - strpos($revstr,".");
            $inputsubstr = substr($inputstr,$cutstr,$inputstrlen);
            switch ($inputsubstr) {
/*
        case "PDF";
                return "pdficon.png";
                break;
*/
                default;
                return "./images/file.gif";
            }
        } else {
            return "./images/folder.gif";
        }
    }
}
?>
