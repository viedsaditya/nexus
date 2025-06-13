<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
    // login
    public function login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where(array('username'=>$username, 'password'=>$password));
        return $this->db->get()->row();
    }
}