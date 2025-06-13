<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_airline extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_airline');
        $this->db->order_by('id_air', 'asc');
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data
    public function simpan($data)
    {
        $this->db->insert('tb_airline', $data);
    }

    // edit
    // fungsi untuk detail data
    public function detail($flightkey)
    {
        $this->db->select('*');
        $this->db->from('tb_airline');
        $this->db->where('flightkey', $flightkey);
        return $this->db->get()->row();
    }
    
    // fungsi untuk edit data
    public function edit($flightkey, $data)
    {
        $this->db->where('flightkey', $flightkey);
        $this->db->update('tb_airline', $data);
    }

    // check if flightkey exists
    public function check_flightkey_exists($flightkey)
    {
        $this->db->where('flightkey', $flightkey);
        $query = $this->db->get('tb_airline'); 
        return $query->num_rows() > 0;
    }

    // edit manual
    // fungsi untuk detail data 
    public function detailmanual($id_air)
    {
        $this->db->select('*');
        $this->db->from('tb_airline');
        $this->db->where('id_air', $id_air);
        return $this->db->get()->row();
    }

    // fungsi untuk edit data 
    public function editmanual($data)
    {
        $this->db->where('id_air', $data['id_air']);
        $this->db->update('tb_airline', $data);
    }
}
