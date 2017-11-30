<?php
require_once 'Instagram.php';
require_once 'params.php';

$instagram = new Instagram($config);
$loginUrl = $instagram->getAuthorizationUrl();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Instagram - OAuth Login</title>
        <link rel="stylesheet" type="text/css" href="assets/style.css">
    </head>
    <body>
        <div class="container">
            <header class="clearfix">
                <h1>Instagram <span>display your photo stream</span></h1>
            </header>
            <div class="main">
                <ul class="grid">
                    <li><img src="assets/instagram-big.png" alt="Instagram logo"></li>
                    <li>
                        <a class="login" href="<?php echo $loginUrl ?>">» Login with Instagram</a>
                        <h4>Use your Instagram account to login.</h4>
                    </li>
                </ul>
            </div>
        </div>
    </body>
</html>
