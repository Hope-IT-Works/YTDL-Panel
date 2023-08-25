<?php
    //var_dump($_POST);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //var_dump($_POST);
        $FormData = array();
        foreach(array('InputDownloadURL','InputFilenameTemplate','InputAudioOnly','InputFormatSelect') as $key){
            if(isset($_POST[$key])){
                if(!empty($_POST[$key])){
                    $FormData[$key] = $_POST[$key];
                }
            }
        }
        var_dump($FormData);
    }

    function validate_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        return htmlspecialchars($data);
    }
?>