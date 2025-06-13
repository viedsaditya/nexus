<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_seasonarrival extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampil()
    {
        $this->db->select('*');
        $this->db->from('sch_arr');
        $this->db->order_by('inc_arr_id', 'asc');
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data
    public function simpan($data)
    {
        $this->db->insert('sch_arr', $data);
    }

    // edit
    // fungsi untuk detail data
    public function detail($arr_id)
    {
        $this->db->select('*');
        $this->db->from('sch_arr');
        $this->db->where('arr_id', $arr_id);
        return $this->db->get()->row();
    }
    
    // fungsi untuk edit data
    public function edit($arr_id, $data)
    {
        $this->db->where('arr_id', $arr_id);
        $this->db->update('sch_arr', $data);
    }

    // check if arr_id exists
    public function check_arr_id_exists($arr_id)
    {
        $this->db->where('arr_id', $arr_id);
        $query = $this->db->get('sch_arr'); 
        return $query->num_rows() > 0;
    }
}
