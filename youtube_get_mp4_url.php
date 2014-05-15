<?php
//http://www.youtube.com/get_video_info?video_id=9gPHZEXoMKc

//$id = "_q12gb7OwsA";
$id = "8uFYfNjbyLk";
$dash = file_get_contents("http://www.youtube.com/get_video_info?video_id=".$id);
$first_level = explode("&", $dash);
//print_r($values);

foreach ($first_level as $fl) {
	$adaptive_fmts = explode("=", $fl);
	if ($adaptive_fmts[0] == "adaptive_fmts") {
		$adaptive_fmts_value = utf8_decode(urldecode($adaptive_fmts[1]));
		$second_level = explode("&", $adaptive_fmts_value);
		//print_r($second_level);

		foreach ($second_level as $sl) {
			$values = explode("=", $sl);
			echo "$values[0] = ".utf8_decode(urldecode($values[1]));
			
			if (count($values) == 3) {
				echo " = ".utf8_decode(urldecode($values[2]));
			}

			echo "\n";
			//print_r($values);
		}
	}
}
?>