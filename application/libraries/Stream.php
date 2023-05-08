<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stream {

    function __construct()
    {
        $CI = & get_instance();
        log_message('Debug', 'VideoStream class is loaded.');
    }

    function load($filePath)
    {
        include_once APPPATH.'/third_party/VideoStream.php';

        return new VideoStream($filePath);
    }
}