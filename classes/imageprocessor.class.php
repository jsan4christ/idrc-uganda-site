<?php

    // TimThumb script created by Tim McDaniels and Darren Hoyt with tweaks by Ben Gillbanks
    // http://code.google.com/p/timthumb/

    // MIT License: http://www.opensource.org/licenses/mit-license.php

    class ImageProcessor {

        var $imagePath; #path where the image is located
        var $newWidth; #new width
        var $newHeight; #new height
        var $zoom;
        var $quality;
        var $imageDir; #folder where images are stored
        var $mimeType;
        var $newFileName;
        var $target; #this will be set as the new width or height depending on whether the original is a portrait or landscape

        function ImageProcessor($imagePath, $target, $imageDir, $zoom = 0, $quality = 80){

            $this->imagePath = $imagePath;
            $this->newWidth = '';
            $this->newHeight = '';
            $this->imageDir = $imageDir;
            $this->zoom = $zoom;
            $this->quality = $quality;
            $this->mimeType = '';
            $this->newFileName = '';
            $this->target = $target;
        }

        function showImage($imageResized) {

            // check to see if we can write to the cache directory
            $is_writable = 0;
            $fileName = $this->imageDir . '/' . $this->getCacheFile();

            if( touch($fileName) ) {
                // give 666 permissions so that the developer
                // can overwrite web server user
                chmod($fileName, 0666);
                $is_writable = 1;
            }
            //            else {
            //                $fileName = NULL;
            //                header('Content-type: ' . $this->mimeType);
            //            }

            if( stristr($this->mimeType, 'gif') ) {
                imagegif($imageResized, $fileName);
            }
            elseif( stristr($this->mimeType, 'jpeg') ) {
                imagejpeg($imageResized, $fileName, $this->quality );
            }
            elseif( stristr($this->mimeType, 'png') ) {
                imagepng($imageResized, $fileName, ceil($this->quality / 10 ) );
            }
            if( $is_writable ) {
                #$this->showCacheFile($this->imageDir, $this->mimeType );
            }
            return;

        }

        function openImage() {

            if( stristr($this->mimeType, 'gif') ) {
                $image = imagecreatefromgif($this->imagePath);
            }
            elseif( stristr($this->mimeType, 'jpeg') ) {
                @ini_set('gd.jpeg_ignore_warning', 1);
                $image = imagecreatefromjpeg($this->imagePath);
            }
            elseif( stristr($this->mimeType, 'png') ) {
                $image = imagecreatefrompng($this->imagePath);
            }
            return $image;

        }

        function getMimeType() {

            $os = strtolower(php_uname());
            // use PECL fileinfo to determine mime type
            if( function_exists('finfo_open') ) {
                $finfo = finfo_open(FILEINFO_MIME);
                $this->mimeType = finfo_file($finfo, $this->imagePath);
                finfo_close($finfo);
            }
            // try to determine mime type by using unix file command
            // this should not be executed on windows
            if( !$this->isValidMimeType($this->mimeType) && !(eregi('windows', php_uname()))) {
                if( preg_match("/freebsd|linux/", $os)) {
                    $this->mimeType = trim(@shell_exec("file -bi $this->imagePath"));
                }
            }
            // use file's extension to determine mime type
            if( !$this->isValidMimeType($this->mimeType) ) {
                $frags = split("\.", $this->imagePath);
                $ext = strtolower($frags[count($frags) - 1]);
                $types = array('jpg'  => 'image/jpeg',
                                'jpeg' => 'image/jpeg',
                                'png'  => 'image/png',
                                'gif'  => 'image/gif');
                if( strlen($ext) && strlen($types[$ext]) ) {
                    $this->mimeType = $types[$ext];
                }
                // if no extension provided, default to jpg
                if( !strlen($ext) && !isValidMimeType($this->mimeType) ) {
                    $this->mimeType = 'image/jpeg';
                }
            }
            return $this->mimeType;

        }

        function isValidMimeType() {

            if( preg_match("/jpg|jpeg|gif|png/i", $this->mimeType) ) {
                return 1;
            }
            return 0;

        }

        function checkCache() {

            // make sure cache dir exists
            if( !file_exists($this->imageDir) ) {
                // give 777 permissions so that developer can overwrite
                // files created by web server user
                mkdir($this->imageDIr);
                chmod($this->imageDir, 0777);
            }
            $this->showCacheFile();

        }

        function showCacheFile() {

            $cacheFile = $this->imageDir . '/' . $this->getCacheFile();

            if( file_exists($cacheFile) ) {

                if( isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) ) {
                    // check for updates
                    $ifModifiedSince = preg_replace('/;.*$/', '', $_SERVER["HTTP_IF_MODIFIED_SINCE"]);
                    $gmdateMod = gmdate('D, d M Y H:i:s', filemtime($cacheFile));

                    if( strstr($gmdateMod, 'GMT') ) {
                        $gmdateMod .= " GMT";
                    }
                    if ( $ifModifiedSince == $gmdateMod ) {
                        header("HTTP/1.1 304 Not Modified");
                        exit;
                    }
                }

                $fileSize = filesize($cacheFile);
                // send headers then display image
                header("Content-Type: " . $this->mimeType);
                header("Accept-Ranges: bytes");
                header("Last-Modified: " . gmdate('D, d M Y H:i:s', filemtime($cacheFile) ) . " GMT");
                header("Content-Length: " . $fileSize);
                header("Cache-Control: max-age=9999, must-revalidate");
                header("Etag: " . md5($fileSize . $gmdate_mod));
                header("Expires: " . gmdate("D, d M Y H:i:s", time() + 9999) . "GMT");
                readfile($cacheFile);
                exit;

            }

        }

        function getCacheFile() {

            if( !$this->newFileName ) {
                $frags = split("\.", $this->imagePath);
                $ext = strtolower($frags[count($frags) - 1]);
                if( !$this->isValidExt($ext) ) {
                    $ext = 'jpg';
                }
                $cacheName = $this->imagePath . $this->newWidth . $this->newHeight . $this->zoom . $this->qquality;
                $this->newFileName = md5($cacheName . time()) . '.' .$ext;
            }
            return $this->newFileName;

        }

        function isValidExt($ext) {

            if( preg_match("/jpg|jpeg|png|gif/i", $ext) ) {
                return 1;
            }
            else{
                return 0;
            }

        }

        function resizeImageDim(){
            //takes the larger size of the width and height and applies the
            #formula accordingly...this is so this script will work
            #dynamically with any size image
            $size = getimagesize($this->imagePath);

            if( $size[0] > $size[1] ) {
                $percentage = ($this->target / $size[0]);
            }
            elseif( $size[1] > $size[0] ){
                $percentage = ($this->target / $size[1]);
            }
            else{
                $percentage = ($this->target / $size[0]);
            }
            //gets the new value and applies the percentage, then rounds the value
            $this->newWidth = round($size[0] * $percentage);
            $this->newHeight = round($size[1] * $percentage);

            return ;
        }

        function resizeImage(){
            #retrieve mime type
            $this->getMimeType();
            #set the new dimensions
            $this->resizeImageDim();

            if( strlen($this->imagePath) && file_exists($this->imagePath) ) {
                // open the existing image
                $image = $this->openImage();
                if( $image === false ) {
                    die('Unable to open image : ' . $this->imagePath);
                }
                // Get original width and height
                $width = imagesx($image);
                $height = imagesy($image);
                // don't allow new width or height to be greater than the original
                if( $this->newWidth > $width ) {
                    $this->newWidth = $width;
                }
                if( $this->newHeight > $height ) {
                    $this->newHeight = $height;
                }
                // generate new w/h if not provided
                if( $this->newWidth && !$this->newHeight ) {
                    $this->newHeight = $height * ($this->newWidth / $width);
                }
                elseif( $this->newHeight && !$this->newWidth ) {
                    $this->newWidth = $width * ($this->newHeight / $height);
                }
                elseif( !$this->newWidth && !$this->newHeight ) {
                    $this->newWidth = $width;
                    $this->newHeight = $height;
                }
                // create a new true color image
                $newImage = imagecreatetruecolor($this->newWidth, $this->newHeight );

                if( $this->zoom ) {

                    $src_x = $src_y = 0;
                    $src_w = $width;
                    $src_h = $height;

                    $cmp_x = $width  / $this->newWidth;
                    $cmp_y = $height / $this->newHeight;
                    // calculate x or y coordinate and width or height of source
                    if( $cmp_x > $cmp_y ) {
                        $src_w = round( ($width / $cmp_x * $cmp_y) );
                        $src_x = round( ($width - ($width / $cmp_x * $cmp_y)) / 2 );
                    }
                    elseif( $cmp_y > $cmp_x ) {
                        $src_h = round( ($height / $cmp_y * $cmp_x) );
                        $src_y = round( ($height - ($height / $cmp_y * $cmp_x)) / 2 );
                    }

                    imagecopyresampled($newImage, $image, 0, 0, $src_x, $src_y, $this->newWidth, $this->newHeight, $src_w, $src_h);
                }
                else {
                    // copy and resize part of an image with resampling
                    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $this->newWidth, $this->newHeight, $width, $height);
                }
                // output image to browser based on mime type
                $this->showImage($newImage);
                // remove image from memory
                imagedestroy($newImage);

            } else {
                if( strlen($this->imagePath) ) {
                    echo $this->imagePath . ' not found.';
                }
                else {
                    echo 'No source specified.';
                }
            }

        }

    }

?>