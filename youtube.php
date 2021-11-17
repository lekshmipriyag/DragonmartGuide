<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Youtube Channel</title>
</head>

<body>

<?php
	

	//Get videos from channel by YouTube Data API
$API_key    = 'AIzaSyC5vPVHH2CKZbmLS4Il62RKzNXZMk8-SLI';
$channelID  = 'UCC0Pvkw5TNhDECrVe_7Rdjg';
$maxResults = 10;

$videoList = json_decode(file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelID.'&maxResults='.$maxResults.'&key='.$API_key.''));
	
	foreach($videoList->items as $item){
    //Embed video
    if(isset($item->id->videoId)){
       ?>
					<?php 
					 echo $thumb_src = '<iframe style="height:auto; width:auto" src="https://www.youtube.com/embed/'.$item->id->videoId.'?rel=0" frameborder="0" allowfullscreen></iframe>';
					?>
	<?php
    }
}
	
?>
</body>
</html>