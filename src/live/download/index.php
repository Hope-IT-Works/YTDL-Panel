<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>YTDL-Panel</title>
    <link href="../assets/css/bootstrap@5.3.1.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-icons@1.10.5.css" rel="stylesheet">
    <link href="../assets/css/ytdl-panel.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicon/site.webmanifest">
    <link rel="mask-icon" href="../assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../assets/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="../assets/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
</head>
<body data-bs-theme="dark" onload='YTDLPANEL_onload("download")'>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" style="font-family: Inter" href="../">
            <!--<img class="ms-2 me-2" src="./assets/media/logo.png" width="40" height="40" alt="YTDL-Panel Logo">-->
            YTDL-Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link active" href="../download"><i class="bi-cloud-download-fill"></i> Download</a>
            </li>
        </ul>
        </div>
    </div>
</nav>
<div class="container py-3">
    <h1>Download</h1>
    <form action="../queue/index.php" id="DownloadForm" method="post">
        <div class="mb-3">
            <label for="InputDownloadURL" class="form-label">Download URL</label>
            <input type="url" class="form-control" id="InputDownloadURL" name="InputDownloadURL" aria-describedby="InputDownloadURLHelp">
            <div id="InputDownloadURLHelp" class="form-text">The URL of the file you want to download. Only <a target="_blank" href="https://github.com/Hope-IT-Works/YTDL-Panel/wiki/FAQ#valid-urls">valid URLs</a> supported.</div>
        </div>
        <div class="mb-3">
            <label for="InputFilenameTemplate" class="form-label">Filename Template</label>
            <input type="text" class="form-control" id="InputFilenameTemplate" name="InputFilenameTemplate" aria-describedby="InputFilenameTemplateHelp" disabled>
            <div id="InputFilenameTemplateHelp" class="form-text">The Filename Template can use <a target="_blank" href="https://github.com/yt-dlp/yt-dlp/blob/master/README.md#output-template">placeholders</a>.</div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="InputAudioOnly" name="InputAudioOnly" disabled>
            <label class="form-check-label" for="InputAudioOnly">Audio only</label>
        </div>
        <div class="mb-3" id="DivChangeFormat">
            <button type="button" class="btn btn-secondary" id="InputChangeFormat" disabled>Change format</button>
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100" id="InputSubmit" disabled>Download</button>
        </div>
    </form>
</div>
<script src="../assets/js/bootstrap@5.3.1.bundle.min.js"></script>
<script src="../assets/js/ytdl-panel.js"></script>
</body>
</html>