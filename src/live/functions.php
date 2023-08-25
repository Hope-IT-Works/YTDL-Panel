<?php
    //default_charset = "utf-8";
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //exec('whoami', $output, $exit_code);
    $output = shell_exec('"C:\Users\Tobias\AppData\Local\Microsoft\WinGet\Packages\yt-dlp.yt-dlp_Microsoft.Winget.Source_8wekyb3d8bbwe\yt-dlp.exe" --version');
    var_dump($output);
    var_dump($_SERVER);
    var_dump($_ENV);
?>