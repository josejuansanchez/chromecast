<?php

// Check the argument (video id) passed to script
if ($argv[1] == null) return;

// Get the video id from the argument passed to script
$video = new VimeoVideo();
$video->get_info($argv[1]);


class VimeoVideo {
	private $sources;
	private $title;	
	private $subtitle;
	private $studio;
	private $image_780_1200;
	private $image_480_270;
	private $id;
	private $description;
	private $upload_date;
	private $thumbnail_small;
	private $thumbnail_medium;
	private $thumbnail_large;
	private $user_name;

	// Vimeo API: config request
	private function api_config_request($video_id) {
		$url = "http://player.vimeo.com/v2/video/".$video_id."/config";
		$json = file_get_contents($url);
		$obj = json_decode($json);

		//$this->sources = $obj->request->files->h264->hd->url;
		$this->title = $obj->video->title;
		$this->studio = $obj->video->owner->name;
		$this->image_780_1200 = $obj->video->thumbs->{'1280'};
		$this->image_480_270 = $obj->video->thumbs->{'640'};
	}

	// Vimeo API: video request
	private function api_video_request($video_id) {
		$url = "http://vimeo.com/api/v2/video/".$video_id.".json";
		$json = file_get_contents($url);
		$obj = json_decode($json);

		$this->sources = $video_id;
		$this->id = $obj[0]->id;
		$this->title = $obj[0]->title;
		$this->subtitle = str_replace("\r\n", "", $obj[0]->description);
		$this->upload_date = $obj[0]->upload_date;
		$this->thumbnail_small = $obj[0]->thumbnail_small;
		$this->thumbnail_medium = $obj[0]->thumbnail_medium;
		$this->thumbnail_large = $obj[0]->thumbnail_large;
		$this->user_name = $obj[0]->user_name;
	}	

	private function print_info() {
		echo "{\n";
		echo "\"subtitle\" : \"$this->subtitle\",\n";
		echo "\"sources\" : [ \"$this->sources\" ],\n";
		echo "\"thumb\" : \"$this->thumbnail_small\",\n";
		echo "\"image-480x270\" : \"$this->image_480_270\",\n";
		echo "\"image-780x1200\" : \"$this->image_780_1200\",\n";
		echo "\"title\" : \"$this->title\",\n";
		echo "\"studio\" : \"$this->studio\"\n";
		echo "}\n";		
	}

	public function get_info($video_id) {
		$this->api_config_request($video_id);
		$this->api_video_request($video_id);
		$this->print_info();
	}
}

?>