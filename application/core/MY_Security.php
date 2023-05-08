<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Security extends CI_Security {

    public function __construct()
    {
        parent::__construct();
    }

    public function csrf_show_error()
    {
        header('Location: /monitor/login', TRUE, 302);
    }
}