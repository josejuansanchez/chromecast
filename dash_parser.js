var http = require("http");

var video_id = "8uFYfNjbyLk";
var url = "http://www.youtube.com/get_video_info?video_id=" + video_id;

console.log("Dash scanner...");

http.get(url, function(res) {
	console.log("Got response: " + res.statusCode);

	res.setEncoding('utf8');
  	res.on('data', function (chunk) {
    	console.log('\n\n** BODY: ' + chunk);
  	});

}).on('error', function(e) {
	console.log("Got error: " + e.message);
});