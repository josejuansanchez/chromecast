<?php

// Check the argument (video id) passed to script
if ($argv[1] == null) return;

// Get the video id from the argument passed to script
$video_id = $argv[1];
api_config_request($video_id);
api_video_request($video_id);

// Vimeo API: config request
function api_config_request($video_id) {
	$url = "http://player.vimeo.com/v2/video/".$video_id."/config";
	$json = file_get_contents($url);
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
}

// Vimeo API: video request
function api_video_request($video_id) {
	$url = "http://vimeo.com/api/v2/video/".$video_id.".json";
	$json = file_get_contents($url);
	$obj = json_decode($json);

	$id = $obj[0]->id;
	$title = $obj[0]->title;
	$description = $obj[0]->description;
	$upload_date = $obj[0]->upload_date;
	$thumbnail_small = $obj[0]->thumbnail_small;
	$thumbnail_medium = $obj[0]->thumbnail_medium;
	$thumbnail_large = $obj[0]->thumbnail_large;
	$user_name = $obj[0]->user_name;

	echo "id: $id\n";
	echo "title: $title\n";
	echo "description: $description\n";
	echo "upload_date: $upload_date\n";
	echo "thumbnail_small: $thumbnail_small\n";
	echo "thumbnail_medium: $thumbnail_medium\n";		
	echo "thumbnail_large: $thumbnail_large\n";
	echo "user_name: $user_name\n";	
}

?>