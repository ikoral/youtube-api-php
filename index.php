<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube API</title>
    <link rel = "stylesheet" href = "./css/bootstrap.min.css">
</head>
<body>
    <div class = "container">
        <h2 class = "text-center">YouTube data API V3 Integration in PHP</h2>

    </div>
    <?php
        include "config.php";

        $base_url = "https://www.googleapis.com/youtube/v3/";
        $channelId = "UCE3nwg15c0_aE56ulCca3NQ";
        $maxResults = 10;
        
        $API_URL = $base_url."search?part=snippet&channelId=".$channelId."&maxResults=".$maxResults."&type=video&key=".$API_KEY;

        //echo $API_URL;

        $videos = json_decode(file_get_contents($API_URL));
        echo "<pre>";
        print_r($videos);
        echo "</pre>";

    ?>
    <div style = "position: fixed; bottom: 10px; right: 10px; color: green;">
        
    </div>
</body>
</html>