<?php

// Check the arguments passed to script
if ($argv[1] == null) return;

// Get the video id from the argument passed to script
$id_video = $argv[1];
$json = file_get_contents("http://player.vimeo.com/v2/video/".$id_video."/config");
$obj = json_decode($json);

//print_r($obj);

$sources = $obj->request->files->h264->hd->url;
$title = $obj->video->title;
$subtitle = $obj->video->title;
$studio = $obj->video->owner->name;
$image_780_1200 = $obj->video->thumbs->{'1280'};
$image_480_270 = $obj->video->thumbs->{'640'};

echo "{\n";
echo "\"subtitle\" : \"$subtitle\",\n";
echo "\"sources\" : [ \"$sources\" ],\n";
echo "\"thumb\" : \"\",\n";
echo "\"image-480x270\" : \"$image_480_270\",\n";
echo "\"image-780x1200\" : \"$image_780_1200\",\n";
echo "\"title\" : \"$title\",\n";
echo "\"studio\" : \"$studio\"\n";
echo "}\n";

?>