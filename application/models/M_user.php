<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{
    // data
    // fungsi untuk tampil data
    public function tampil($id_sts)
    {
        $this->db->select('id_usr, fullname, username, password, email, foto, tb_user.is_active,
                          tb_station.id_sts, code_station, name_station,
                          tb_role.id_role, code_role');
        $this->db->from('tb_user');
        $this->db->join('tb_station', 'tb_station.id_sts = tb_user.id_sts', 'LEFT'); // join tb_station
        $this->db->join('tb_role', 'tb_role.id_role = tb_user.id_role', 'LEFT'); // join tb_role
        $this->db->order_by('id_usr', 'asc');
        $this->db->where('tb_user.id_sts', $id_sts);
        $this->db->where('tb_user.id_usr !=', 1);
        return $this->db->get()->result();
    }

    // fungsi untuk tampil station 
    public function tampilstation()
    {
        $this->db->select('*');
        $this->db->from('tb_station');
        $this->db->order_by('id_sts', 'asc');
        $this->db->where('is_active', 1);
        return $this->db->get()->result();
    }

    // fungsi untuk tampil role akses 
    public function tampilroleakses()
    {
        $this->db->select('*');
        $this->db->from('tb_role');
        $this->db->order_by('id_role', 'asc');
        $this->db->where('is_active', 1);
        return $this->db->get()->result();
    }

    // input
    // fungsi untuk simpan data
    public function simpan($data)
    {
        $this->db->insert('tb_user', $data);
    }

    // edit
    // fungsi untuk detail data
    public function detail($id_usr)
    {
        $this->db->select('*');
        $this->db->from('tb_user');
        $this->db->where('id_usr', $id_usr);
        return $this->db->get()->row();
    }
    
    // fungsi untuk edit data
    public function edit($data)
    {
        $this->db->where('id_usr', $data['id_usr']);
        $this->db->update('tb_user', $data);
    }

    // active/deactive data
    public function activate($data)
    {
        $this->db->where('id_usr', $data['id_usr']);
        $this->db->update('tb_user', $data);
    }

    public function deactivate($data)
    {
        $this->db->where('id_usr', $data['id_usr']);
        $this->db->update('tb_user', $data);
    }
}
