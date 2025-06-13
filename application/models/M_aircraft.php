<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_aircraft extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampil()
    {
        $this->db->select('*');
        $this->db->from('tb_aircraft');
        $this->db->order_by('id_ac', 'asc');
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data
    public function simpan($data)
    {
        $this->db->insert('tb_aircraft', $data);
    }

    // edit
    // fungsi untuk detail data
    public function detail($acreg)
    {
        $this->db->select('*');
        $this->db->from('tb_aircraft');
        $this->db->where('acreg', $acreg);
        return $this->db->get()->row();
    }
    
    // fungsi untuk edit data
    public function edit($acreg, $data)
    {
        $this->db->where('acreg', $acreg);
        $this->db->update('tb_aircraft', $data);
    }

    // check if acreg exists
    public function check_acreg_exists($acreg)
    {
        $this->db->where('acreg', $acreg);
        $query = $this->db->get('tb_aircraft'); 
        return $query->num_rows() > 0;
    }

    // edit manual
    // fungsi untuk detail data 
    public function detailmanual($id_ac)
    {
        $this->db->select('*');
        $this->db->from('tb_aircraft');
        $this->db->where('id_ac', $id_ac);
        return $this->db->get()->row();
    }

    // fungsi untuk edit data 
    public function editmanual($data)
    {
        $this->db->where('id_ac', $data['id_ac']);
        $this->db->update('tb_aircraft', $data);
    }
}
