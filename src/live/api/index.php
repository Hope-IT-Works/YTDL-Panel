<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(400);
    die();
}

class YTDL_Panel {
    private $config = [];
    private $error = false;
    private $error_message = '';
    private $gui = false;

	public function __construct() {
		$this->config = require dirname(__DIR__, 2).DIRECTORY_SEPARATOR.'config.php';
        if(isset($_GET['gui'])){
            if($_GET['gui'] == true){
                $this->gui = true;
            }
        }
	}

    public function print_header() {
        $result = '';
        $result .= '<!doctype html>';
        $result .= '<html lang="de">';
        $result .= '<head>';
        $result .= '<meta charset="utf-8">';
        $result .= '<meta name="viewport" content="width=device-width, initial-scale=1">';
        $result .= '<title>YTDL-Panel API</title>';
        $result .= '<link href="../assets/css/bootstrap@5.3.1.min.css" rel="stylesheet">';
        $result .= '<link href="../assets/css/prism@1.29.0.min.css" rel="stylesheet">';
        $result .= '</head>';
        $result .= '<body data-bs-theme="dark">';
        $result .= '';
        $result .= '<nav class="navbar navbar-expand-lg bg-body-tertiary">';
        $result .= '<div class="container-fluid">';
        $result .= '<a class="navbar-brand" style="font-family: Inter" href="./">YTDL-Panel API</a>';
        $result .= '</div>';
        $result .= '</nav>';
        $result .= '<div class="container">';
        $result .= '<pre class="my-3 p-3 border rounded bg-body-tertiary"><code class="language-json">';
        if($this->is_gui_enabled()){
            echo $result;
        }
    }

    public function print_footer() {
        $result = '';
        $result .= '</code>';
        $result .= '</pre>';
        $result .= '</div>';
        $result .= '<script src="../assets/js/prism@1.29.0.min.js"></script>';
        $result .= '</body>';
        $result .= '</html>';
        if($this->is_gui_enabled()){
            echo $result;
        }
    }

    public function is_validURL($url) {
        return preg_match('/^(http|https):\/\/([a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]+)(:\d+)?(\/[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]*)?(\?[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/?%=]*)?(#[a-zA-Z0-9\-._~%!$&\'()*+,;=:@\/]*)?$/i', $url);
    }

    private function is_gui_enabled() {
        return $this->gui;
    }

    private function is_installed ($dependency = null) {
        $result = array(
            'installed' => false,
            'message' => '',
            'version' => ''
        );
        switch ($dependency) {
            case "ytdl":
                exec($this->config['bin_ytdl'].' --version', $output, $exit_code);
                if ($exit_code === 1) {
                    $this->error = true;
                    $this->error_message = "YTDL-Panel requires youtube-dl or ytdl-dlp to download videos.";
                    $result['message'] = '❌ ytdl-dlp was not found.<br>For instructions on how to install yt-dlp, see <a target="_blank" href="https://github.com/Hope-IT-Works/YTDL-Panel/wiki">YTDL-Panel Wiki</a>';
                    $result['version'] = "/";
                } else {
                    $result['installed'] = true;
                    $result['message'] = '✅ yt-dlp is installed and ready to use.';
                    $result['version'] = $output[0];
                }
                break;
            case "ffmpeg":
                exec($this->config['bin_ffmpeg'].' -version', $output, $exit_code);
                if ($exit_code === 1) {
                    $this->error = true;
                    $this->error_message = "YTDL-Panel requires FFmpeg to convert videos.";
                    $result['message'] = '❌ FFmpeg was not found.<br>For instructions on how to install FFmpeg, see <a target="_blank" href="https://github.com/Hope-IT-Works/YTDL-Panel/wiki">YTDL-Panel Wiki</a>.';
                    $result['version'] = "/";
                } else {
                    $result['installed'] = true;
                    $result['message'] = '✅ FFmpeg is installed and ready to use.';
                    $result['version'] = explode(' Copyright', $output[0])[0];
                }
                break;
        }
        return $result;
    }

    private function get_formats($url = null){
        $result = null;
        if($this->is_validURL($url)){
            exec($this->config['bin_ytdl'].' -J '.$url, $output, $exit_code);
            if($exit_code === 1){
                $this->error = true;
                $this->error_message = "yt-dlp returned an error: ".$output[0];
            } else {
                try {
                    $result = json_decode($output[0], true);
                } catch (Exception $e) {
                    $this->error = true;
                    $this->error_message = "yt-dlp result could not be decoded: ".$e->getMessage();
                }
            }
        } else {
            $this->error = true;
            $this->error_message = "Invalid URL.";
        };
        return $result;
    }

    private function build_response($data = null) {
        echo json_encode(array(
            'data' => $data,
            'error' => $this->error,
            'error_message' => $this->error_message
        ), JSON_PRETTY_PRINT);
    }

    public function api_undefined_action() {
        $this->error = true;
        $this->error_message = "Unknown or undefined API action.";
        $this->build_response();
    }

    public function api_undefined_data() {
        $this->error = true;
        $this->error_message = "Unknown or undefined API data.";
        $this->build_response();
    }

    public function api_is_installed($dependency = null) {
        $result = $this->is_installed($dependency);
        $this->build_response($result);
    }

    public function api_get_formats($url = null) {
        $result = $this->get_formats($url);
        $this->build_response($result);
    }
}

$YTDL_Panel = new YTDL_Panel();
$YTDL_Panel->print_header();

if(isset($_GET['action'])){
    $action = $_GET['action'];
    switch ($action) {
        case "is_installed":
            if(isset($_GET['data'])){
                $YTDL_Panel->api_is_installed($_GET['data']);
            } else {
                $YTDL_Panel->api_undefined_data();
            }
            break;
        case "get_formats":
            if(isset($_GET['data'])){
                $YTDL_Panel->api_get_formats($_GET['data']);
            } else {
                $YTDL_Panel->api_undefined_data();
            }
            break;
        default:
            $YTDL_Panel->api_undefined_action();
    }
}

$YTDL_Panel->print_footer();

?>