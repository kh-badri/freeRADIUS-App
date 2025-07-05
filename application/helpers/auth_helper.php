<?php
defined('BASEPATH') or exit('No direct script access allowed');

function check_login()
{
    $CI = &get_instance();
    if (!$CI->session->userdata('logged_in')) {
        redirect('login');
    }
}
