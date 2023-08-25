<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YTDL-Panel</title>
    <link href="./assets/css/bootstrap@5.3.1.min.css" rel="stylesheet">
    <link href="./assets/css/bootstrap-icons@1.10.5.css" rel="stylesheet">
    <link href="./assets/css/ytdl-panel.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="./assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="./assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="./assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body data-bs-theme="dark" onload='YTDLPANEL_onload("start")'>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" style="font-family: Inter" href="./">
            <!--<img class="ms-2 me-2" src="./assets/media/logo.png" width="40" height="40" alt="YTDL-Panel Logo">-->
            YTDL-Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="./download"><i class="bi-cloud-download-fill"></i> Download</a>
            </li>
            <!--
            <li class="nav-item">
                <a class="nav-link" href="./info.php"><i class="bi-info-circle-fill"></i> JSON Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/list.php"><i class="bi-list"></i> List of files</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logs.php"><i class="bi-journals"></i> Logs</a>
            </li>
            -->
        </ul>
        </div>
    </div>
</nav>
<div class="container py-3">
    <h1>
    <?php
        date_default_timezone_set('Europe/Berlin');
        $time = date("G");
        if($time > 5 && $time < 14){
            $title_message = '<i class="bi-sunrise-fill"></i> Good Morning.';
        } elseif ($time > 13 && $time < 17){
            $title_message = '<i class="bi-sun-fill"></i> Good Afternoon.';
        } elseif ($time > 16 && $time < 21){
            $title_message = '<i class="bi-sunset-fill"></i> Good Evening.';
        } else {
            $title_message = '<i class="bi-moon-stars-fill"></i> Good Night.';
        }
        echo $title_message;
    ?>
    </h1>
    <div class="mt-1 row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id="dependency_title_ytdl">yt-dlp</h5>
                    <p class="card-text" id="dependency_text_ytdl">
                        <i>Required to download videos with YTDL-Panel</i>
                        <div id="dependency_check_ytdl">
                            <div class="border border-primary rounded p-2">
                                <span class="spinner-grow spinner-grow-sm text-primary" aria-hidden="true"></span>
                                <span role="status">Checking dependency status...</span>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">FFmpeg</h5>
                    <p class="card-text">
                        <i>Required to extract audio from videos with YTDL-Panel</i>
                        <div id="dependency_check_ffmpeg">
                            <div class="border border-primary rounded p-2">
                                <span class="spinner-grow spinner-grow-sm text-primary" aria-hidden="true"></span>
                                <span role="status">Checking dependency status...</span>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./assets/js/bootstrap@5.3.1.bundle.min.js"></script>
<script src="./assets/js/ytdl-panel.js"></script>
</body>
</html>