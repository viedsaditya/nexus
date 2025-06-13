<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_station extends CI_Model
{
    // data
    // fungsi untuk tampil data 
    public function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_station');
        $this->db->order_by('id_sts', 'asc');
        // $this->db->where('is_active', 1);
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data 
    public function simpan($data)
    {
        $this->db->insert('tb_station', $data);
    }

    //edit
    // fungsi untuk detail data 
    public function detail($id_sts)
    {
        $this->db->select('*');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        return $this->db->get()->row();
    }

    // fungsi untuk edit data 
    public function edit($data)
    {
        $this->db->where('id_sts', $data['id_sts']);
        $this->db->update('tb_station', $data);
    }

    // active/deactive data
    public function activate($data)
    {
        $this->db->where('id_sts', $data['id_sts']);
        $this->db->update('tb_station', $data);
    }

    public function deactivate($data)
    {
        $this->db->where('id_sts', $data['id_sts']);
        $this->db->update('tb_station', $data);
    }
}
