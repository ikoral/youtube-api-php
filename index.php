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
        include_once "configp.php";
        include "DbConnect.php";
        
        $CurrentKeys = new MyKeys();


        $db = new DbConnect();
        $db->set_pass($CurrentKeys);
        $conn = $db->connect();
        
        $base_url = "https://www.googleapis.com/youtube/v3/";
        $channelId = "UCE3nwg15c0_aE56ulCca3NQ";
        $maxResults = 10;
        
        //$API_URL = $base_url."search?part=snippet&channelId=".$channelId."&maxResults=".$maxResults."&type=video&key=".$CurrentKeys->getAPI();

        //echo $API_URL;

        $endPointSet = isset($_GET['vtype']);
        if ($endPointSet){
        $videoType = $_GET['vtype'];
        }else {
        $videoType = false;
        }

        if($videoType == 1) {
            $API_URL = $base_url."search?order=date&part=snippet&channelId=".$channelId."&maxResults=".$maxResults."&type=video&key=".$CurrentKeys->getAPI();
            getVideos($API_URL);
        }else if($videoType == 2) {
            $API_URL = $base_url."playlists?order=date&part=snippet&channelId=".$channelId."&maxResults=".$maxResults."&type=video&key=".$CurrentKeys->getAPI();
            getPlaylists($API_URL);
        }
        function getVideos($API_URL){
            global $conn;
            $videos = json_decode(file_get_contents($API_URL));
            echo "<pre>";
            print_r($videos);
            echo "</pre>";
            foreach($videos->items as $video) {
                $sql = "INSERT INTO `youtube`.`videos` (`id`, `video_type`, `video_id`, `title`,
                `thumbnail_url`, `published_at`)
                VALUES (NULL, 1, :vid, :title, :turl, :pdate)";
                //CURRENT_TIMESTAMP
                $publishDate = date('Y-m-d h:i:s', strtotime($video->snippet->publishedAt));
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":vid", $video->id->videoId);
                $stmt->bindParam(":title", $video->snippet->title);
                $stmt->bindParam(":turl", $video->snippet->thumbnails->high->url);
                $stmt->bindParam(":pdate", $publishDate);
                $stmt->execute();
            }
        }

        function getPlaylists($API_URL){
            global $conn;
            $playlists = json_decode(file_get_contents($API_URL));
            foreach($playlists->items as $video) {
                $sql = "INSERT INTO `youtube`.`videos` (`id`, `video_type`, `video_id`, `title`,
                `thumbnail_url`, `published_at`)
                VALUES (NULL, 2, :vid, :title, :turl, :pdate)";
                //CURRENT_TIMESTAMP
                $publishDate = date('Y-m-d h:i:s', strtotime($video->snippet->publishedAt));
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":vid", $video->id);
                $stmt->bindParam(":title", $video->snippet->title);
                $stmt->bindParam(":turl", $video->snippet->thumbnails->high->url);
                $stmt->bindParam(":pdate", $publishDate);
                // echo "<pre>";
                // print_r($sql);
                // echo "</pre>";
                $stmt->execute();
            }
        }

    ?>
    <div style = "position: fixed; bottom: 10px; right: 10px; color: green;">
        
    </div>
</body>
</html>