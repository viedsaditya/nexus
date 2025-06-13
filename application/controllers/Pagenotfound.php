<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pagenotfound extends CI_Controller
{
    public function index()
    {
        $data = array(
            'title' => '',
            'isi' => 'pagenotfound/v_pagenotfound'
        );
        $this->load->view('admin-layout/v_wrapperlogin', $data, FALSE);
    }
}
