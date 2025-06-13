<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dailyarrival extends CI_Model
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

    public function get_today_records()
    {
        $this->db->select('arr_id');
        $this->db->from('sch_arr');
        $this->db->where('DATE(arr_sta) = CURDATE()');
        return $this->db->get()->result();
    }

    public function batch_insert($data)
    {
        return $this->db->insert_batch('sch_arr', $data);
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

        $sql = "REPLACE INTO daily_arrival (" . 
               implode(',', $fields) . 
               ") VALUES " . 
               implode(',', $values);

        return $this->db->query($sql);
    }
}
