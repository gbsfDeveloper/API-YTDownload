<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: *" );
set_time_limit(0);
if (isset($_GET['video_id'])) {
    $videoID = $_GET['video_id'];
    $URL = "https://www.yt-download.org/api/button/mp3/$videoID";
    $html_data = file_get_contents($URL);
    $regex = '/(?<=<a href=")(.*?)(?=\")/';
    preg_match_all($regex, $html_data,$matches);
    $MP3urlsArray = array();
    foreach($matches[0] as $key=>$url){
        $regex_videoType = '/(?<=https:\/\/www.yt-download.org\/download\/'. $videoID .'\/mp3\/)(.*?)(?=\/)/';
        preg_match_all($regex_videoType, $url,$match);
        $mp3_quality = $match[0][0];
        $MP3urlsArray["mp3-" . $mp3_quality] = $url;
    }
    echo json_encode($MP3urlsArray);
} else {
    echo "Debes mandar un ID de un video";
}

?>