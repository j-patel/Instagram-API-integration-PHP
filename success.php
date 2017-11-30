<!DOCTYPE html>
<?php
require_once 'Instagram.php';
require_once 'params.php';

$instagram = new Instagram($config);
$response = $instagram->getUserRecent('self');

$result_array = json_decode($response, true);

$result = json_decode($response);

$avatar = $result_array['data'][0]['user']['profile_picture'];
$username = $result_array['data'][0]['user']['username'];

$access_code = $_GET['code'];

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram - photo stream</title>
    <link href="assets/style.css" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <header class="clearfix">
        <img src="assets/instagram.png" alt="Instagram logo">

        <h1>Instagram photos</h1> <h3><div>taken by</div><div class="avatar" style="background-image: url(<?= $avatar ?>)"></div>
            <p><?= $username ?></p></h3>
                           
    </header>
    <div class="main">
        <ul class="grid">
            <?php
            // display all user likes
            foreach ($result->data as $media) {
                $content = '<li>';
                // output media
                if ($media->type === 'video') {
                    // video
                    $poster = $media->images->low_resolution->url;
                    $source = $media->videos->standard_resolution->url;
                    $content .= "<video class=\"media\" width=\"250\" height=\"250\" poster=\"{$poster}\"
                           data-setup='{\"controls\":true, \"preload\": \"auto\"}'>
                             <source src=\"{$source}\" type=\"video/mp4\" />
                           </video>";
                } else {
                    // image
                    $image = $media->images->standard_resolution->url;
                    $content .= "<img class=\"media\" src=\"{$image}\"/>";
                }
                // create meta section
                $username = $media->user->username;
                $media_Id = $media->id;
                $comment = $media->caption->text;
                $likes = $media->likes->count;
                $content .= "<div class=\"content\">
                                <div class=\"comment\">{$comment}</div>
                                <div class=\"like\">{$likes} Likes</div>
                            </div>";
                // output media
                echo $content . '</li>';
            }
            ?>
        </ul>
    </div>
</div>
<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        // rollover effect
        $('li').hover(
            function () {
                var $media = $(this).find('.media');
                var height = $media.height();
                $media.stop().animate({marginTop: -(height - 82)}, 1000);
            }, function () {
                var $media = $(this).find('.media');
                $media.stop().animate({marginTop: '0px'}, 1000);
            }
        );
    });
</script>
</body>
</html>
