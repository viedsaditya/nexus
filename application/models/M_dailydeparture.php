<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dailydeparture extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

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

    public function batch_upsert($records)
    {
        if (empty($records)) {
            return;
        }

        // Prepare the REPLACE INTO query
        $fields = array_keys($records[0]);
        $values = [];
        
        foreach ($records as $record) {
            $row = array_map(function($value) {
                return $this->db->escape($value);
            }, $record);
            $values[] = '(' . implode(',', $row) . ')';
        }

        $sql = "REPLACE INTO daily_departure (" . 
               implode(',', $fields) . 
               ") VALUES " . 
               implode(',', $values);

        return $this->db->query($sql);
    }
}
