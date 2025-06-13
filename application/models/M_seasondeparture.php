<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_seasondeparture extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampil()
    {
        $this->db->select('*');
        $this->db->from('sch_dep');
        $this->db->order_by('inc_dep_id', 'asc');
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data
    public function simpan($data)
    {
        $this->db->insert('sch_dep', $data);
    }

    // edit
    // fungsi untuk detail data
    public function detail($dep_id)
    {
        $this->db->select('*');
        $this->db->from('sch_dep');
        $this->db->where('dep_id', $dep_id);
        return $this->db->get()->row();
    }
    
    // fungsi untuk edit data
    public function edit($dep_id, $data)
    {
        $this->db->where('dep_id', $dep_id);
        $this->db->update('sch_dep', $data);
    }

    // check if dep_id exists
    public function check_dep_id_exists($dep_id)
    {
        $this->db->where('dep_id', $dep_id);
        $query = $this->db->get('sch_dep'); 
        return $query->num_rows() > 0;
    }
}
