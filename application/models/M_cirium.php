<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_cirium extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampilarr($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row(); 

        $this->db->select('*');
        $this->db->from('sch_arr');
        $this->db->order_by('inc_arr_id', 'asc');
        $this->db->where('arr_source', 'API Cirium');
        $this->db->where('DATE(arr_sta) = CURDATE()');
        $this->db->where('arr_destination', $cs->code_station);
        return $this->db->get()->result();
    }

    // data
    // fungsi untuk tampil data
    public function tampildep($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $this->db->select('*');
        $this->db->from('sch_dep');
        $this->db->order_by('inc_dep_id', 'asc');
        $this->db->where('dep_source', 'API Cirium');
        $this->db->where('DATE(dep_std) = CURDATE()');
        $this->db->where('dep_origin', $cs->code_station);
        return $this->db->get()->result();
    }
}
