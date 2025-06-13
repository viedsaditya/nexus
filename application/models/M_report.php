<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_report extends CI_Model
{
    // fungsi untuk tampil data pairing
    public function tampilpairing($date_a, $date_b, $flightno, $id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $w = "";
        if ($date_a != "") { $w .= "DATE(`dep_std`) >= '$date_a'";} 
        if ($date_b != "") {
            if ( $date_a != "") $w .= " AND "; 
            $w .= "DATE(`dep_std`) <= '$date_b'";
        }
        if ($flightno != "") {
            if ( $date_a != "" || $date_b != "" ) $w .= " AND ";
            $w .= "`dep_flightno` LIKE '%$flightno%'";
        } 

        $r = $this->db->query("WITH arr AS (
                SELECT a.arr_id, a.arr_flightkey, a.arr_flightno, a.arr_actype, a.arr_acreg, c.acsize as arr_acsize, a.arr_origin, a.arr_destination, a.arr_bay, a.arr_gate, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_status, a.arr_season, a.arr_dop, a.arr_source, a.arr_user_created, a.arr_last_update, a.arr_is_active, 
                c.actype as master_arr_actype,
                b.airline_terminal as arr_terminal
                FROM sch_arr a
                INNER JOIN tb_airline b on b.flightkey = a.arr_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.arr_acreg
                where a.arr_is_active = 1 AND a.arr_status = 'OPERATED' AND date(a.arr_sta) BETWEEN '$date_a' - INTERVAL 3 DAY AND '$date_b'
        ), dep AS (
                SELECT a.dep_id, a.dep_flightkey, a.dep_flightno, a.dep_actype, a.dep_acreg, a.dep_origin, a.dep_destination, a.dep_bay, a.dep_gate, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_status, a.dep_season, a.dep_dop, a.dep_source, a.dep_user_created, a.dep_last_update, a.dep_is_active,
                b.airline_terminal as dep_terminal,
                c.acsize as dep_acsize,
                c.actype as master_dep_actype
                FROM sch_dep a
                INNER JOIN tb_airline b on b.flightkey = a.dep_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.dep_acreg
                WHERE a.dep_status = 'OPERATED' and a.dep_is_active = 1 and a.dep_is_active = 1 AND date(a.dep_std) BETWEEN '$date_a' AND '$date_b'
        ), time_diff AS (
                SELECT 
                    a.*,
                    b.*,
                    TIMESTAMPDIFF(SECOND, a.arr_sta, b.dep_std) AS time_diff_a
                FROM arr a
                INNER JOIN dep b 
                    ON a.arr_acreg = b.dep_acreg
                    AND a.arr_destination = b.dep_origin
        ), ranked_time_diff AS (
                SELECT 
                    *,
                    ROW_NUMBER() OVER (PARTITION BY arr_id ORDER BY time_diff_a ASC) AS rn_arr,
                    ROW_NUMBER() OVER (PARTITION BY dep_id ORDER BY time_diff_a ASC) AS rn_dep
                FROM time_diff
                WHERE time_diff_a > 0
        )   SELECT *
            FROM ranked_time_diff a
            WHERE rn_arr = 1 and rn_dep = 1 ".
            ($w ? " AND arr_destination='$cs->code_station' AND dep_origin='$cs->code_station' AND ".$w : ""))->result();
            // ($w ? " WHERE `a_des_cod_iata`='$cs->code_station' AND ".$w : ""))->result();

        return $r;
    }

    // fungsi untuk tampil data arrival
    public function tampilarrival($date_a, $date_b, $flightno, $id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $w = "";
        if ($date_a != "") { $w .= "DATE(`arr_sta`) >= '$date_a'";} 
        if ($date_b != "") {
            if ( $date_a != "") $w .= " AND "; 
            $w .= "DATE(`arr_sta`) <= '$date_b'";
        }
        if ($flightno != "") {
            if ( $date_a != "" || $date_b != "" ) $w .= " AND ";
            $w .= "`arr_flightno` LIKE '%$flightno%'";
        } 

        $r = $this->db->query("WITH arr AS (
                SELECT a.arr_id, a.arr_flightkey, a.arr_flightno, a.arr_actype, a.arr_acreg, c.acsize as arr_acsize, a.arr_origin, a.arr_destination, a.arr_bay, a.arr_gate, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_status, a.arr_season, a.arr_dop, a.arr_source, a.arr_user_created, a.arr_last_update, a.arr_is_active, 
                c.actype as master_arr_actype,
                b.airline_terminal as arr_terminal
                FROM sch_arr a
                INNER JOIN tb_airline b on b.flightkey = a.arr_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.arr_acreg
                where a.arr_is_active = 1 
                AND date(a.arr_sta) BETWEEN '$date_a' AND '$date_b'
        ), dep AS (
                SELECT a.dep_id, a.dep_flightkey, a.dep_flightno, a.dep_actype, a.dep_acreg, a.dep_origin, a.dep_destination, a.dep_bay, a.dep_gate, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_status, a.dep_season, a.dep_dop, a.dep_source, a.dep_user_created, a.dep_last_update, a.dep_is_active,
                b.airline_terminal as dep_terminal,
                c.acsize as dep_acsize,
                c.actype as master_dep_actype
                FROM sch_dep a
                INNER JOIN tb_airline b on b.flightkey = a.dep_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.dep_acreg
                WHERE a.dep_is_active = 1 
                AND date(a.dep_std) BETWEEN '$date_a' AND '$date_b' + INTERVAL 3 DAY
        ), time_diff AS (
            SELECT 
                a.*,
                b.*,
                TIMESTAMPDIFF(SECOND, a.arr_sta, b.dep_std) AS time_diff_a
            FROM arr a
            INNER JOIN dep b 
                ON a.arr_acreg = b.dep_acreg
                AND a.arr_destination = b.dep_origin AND a.arr_status = 'OPERATED' AND b.dep_status = 'OPERATED'
        ), ranked_time_diff AS (
            SELECT 
                *,
                ROW_NUMBER() OVER (PARTITION BY arr_id ORDER BY time_diff_a ASC) AS rn_arr,
                ROW_NUMBER() OVER (PARTITION BY dep_id ORDER BY time_diff_a ASC) AS rn_dep
            FROM time_diff
            WHERE time_diff_a > 0
        ), paired_flight as(
            SELECT *,
                'PAIRED' as paired
            FROM ranked_time_diff a
            WHERE rn_arr = 1 and rn_dep = 1
        ), unpaired_arr as (
            SELECT a.*, 'NOT-PAIRED' AS paired
            FROM arr a
            WHERE a.arr_id NOT IN (SELECT arr_id FROM paired_flight)
        ), paired_unpaired as (
            SELECT 
                a.arr_id, a.arr_flightno, a.arr_origin, a.arr_destination, a.arr_acreg, a.arr_actype, a.master_arr_actype, a.arr_acsize, a.arr_bay, a.arr_gate, a.arr_terminal, a.arr_status, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_is_active, a.paired 
            FROM unpaired_arr a
            UNION ALL
            SELECT 
                b.arr_id, b.arr_flightno, b.arr_origin, b.arr_destination, b.arr_acreg, b.arr_actype, b.master_arr_actype, b.arr_acsize, b.arr_bay, b.arr_gate, b.arr_terminal, b.arr_status, b.arr_sta, b.arr_eta, b.arr_ata, b.arr_landing, b.arr_is_active, b.paired 
            FROM paired_flight b
        )
            SELECT * 
            FROM paired_unpaired ".
            ($w ? " WHERE arr_destination='$cs->code_station' AND ".$w : ""))->result();
            // ($w ? " WHERE `a_des_cod_iata`='$cs->code_station' AND ".$w : ""))->result();

        return $r;
    }

    // fungsi untuk tampil data departure
    public function tampildeparture($date_a, $date_b, $flightno, $id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $w = "";
        if ($date_a != "") { $w .= "DATE(`dep_std`) >= '$date_a'";} 
        if ($date_b != "") {
            if ( $date_a != "") $w .= " AND "; 
            $w .= "DATE(`dep_std`) <= '$date_b'";
        }
        if ($flightno != "") {
            if ( $date_a != "" || $date_b != "" ) $w .= " AND ";
            $w .= "`dep_flightno` LIKE '%$flightno%'";
        } 

        $r = $this->db->query("WITH arr AS (
                SELECT a.arr_id, a.arr_flightkey, a.arr_flightno, a.arr_actype, a.arr_acreg, c.acsize as arr_acsize, a.arr_origin, a.arr_destination, a.arr_bay, a.arr_gate, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_status, a.arr_season, a.arr_dop, a.arr_source, a.arr_user_created, a.arr_last_update, a.arr_is_active, 
                c.actype as master_arr_actype,
                b.airline_terminal as arr_terminal
                FROM sch_arr a
                INNER JOIN tb_airline b on b.flightkey = a.arr_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.arr_acreg
                where a.arr_is_active = 1 
                AND date(a.arr_sta) BETWEEN '$date_a' - INTERVAL 3 DAY AND '$date_b'
        ), dep AS (
                SELECT a.dep_id, a.dep_flightkey, a.dep_flightno, a.dep_actype, a.dep_acreg, a.dep_origin, a.dep_destination, a.dep_bay, a.dep_gate, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_status, a.dep_season, a.dep_dop, a.dep_source, a.dep_user_created, a.dep_last_update, a.dep_is_active,
                b.airline_terminal as dep_terminal,
                c.acsize as dep_acsize,
                c.actype as master_dep_actype
                FROM sch_dep a
                INNER JOIN tb_airline b on b.flightkey = a.dep_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.dep_acreg
                WHERE a.dep_is_active = 1 
                AND date(a.dep_std) BETWEEN '$date_a' AND '$date_b'
        ), time_diff AS (
            SELECT 
                a.*,
                b.*,
                TIMESTAMPDIFF(SECOND, a.arr_sta, b.dep_std) AS time_diff_a
            FROM arr a
            INNER JOIN dep b 
                ON a.arr_acreg = b.dep_acreg
                AND a.arr_destination = b.dep_origin AND a.arr_status = 'OPERATED' AND b.dep_status = 'OPERATED'
        ), ranked_time_diff AS (
            SELECT 
                *,
                ROW_NUMBER() OVER (PARTITION BY arr_id ORDER BY time_diff_a ASC) AS rn_arr,
                ROW_NUMBER() OVER (PARTITION BY dep_id ORDER BY time_diff_a ASC) AS rn_dep
            FROM time_diff
            WHERE time_diff_a > 0
        ), paired_flight as(
            SELECT *,
                'PAIRED' as paired
            FROM ranked_time_diff a
            WHERE rn_arr = 1 and rn_dep = 1
        ), unpaired_dep as (
            SELECT a.*, 'NOT-PAIRED' AS paired
            FROM dep a
            WHERE a.dep_id NOT IN (SELECT dep_id FROM paired_flight)
        ), paired_unpaired as (
            SELECT 
                a.dep_id, a.dep_flightno, a.dep_origin, a.dep_destination, a.dep_acreg, a.dep_actype, a.master_dep_actype, a.dep_acsize, a.dep_bay, a.dep_gate, a.dep_terminal, a.dep_status, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_is_active, a.paired 
            FROM unpaired_dep a
            UNION ALL
            SELECT 
                b.dep_id, b.dep_flightno, b.dep_origin, b.dep_destination, b.dep_acreg, b.dep_actype, b.master_dep_actype, b.dep_acsize, b.dep_bay, b.dep_gate, b.dep_terminal, b.dep_status, b.dep_std, b.dep_etd, b.dep_atd, b.dep_airborne, b.dep_is_active, b.paired 
            FROM paired_flight b
        )
            SELECT * 
            FROM paired_unpaired ".
                ($w ? " WHERE dep_origin='$cs->code_station' AND ".$w : ""))->result();
                // ($w ? " WHERE `a_des_cod_iata`='$cs->code_station' AND ".$w : ""))->result();

        return $r;
    }
}
