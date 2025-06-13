<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function gettotalflightdailypair($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $r = $this->db->query("WITH arr AS (
                SELECT a.arr_id, a.arr_flightkey, a.arr_flightno, a.arr_actype, a.arr_acreg, c.acsize as arr_acsize, a.arr_origin, a.arr_destination, a.arr_bay, a.arr_gate, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_status, a.arr_season, a.arr_dop, a.arr_source, a.arr_user_created, a.arr_last_update, a.arr_is_active, 
                c.actype as master_arr_actype,
                b.airline_terminal as arr_terminal
                FROM sch_arr a
                INNER JOIN tb_airline b on b.flightkey = a.arr_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.arr_acreg
                where a.arr_is_active = 1 AND a.arr_status = 'OPERATED' AND date(a.arr_sta) BETWEEN CURDATE() - INTERVAL 3 DAY AND CURDATE()
        ), dep AS (
                SELECT a.dep_id, a.dep_flightkey, a.dep_flightno, a.dep_actype, a.dep_acreg, a.dep_origin, a.dep_destination, a.dep_bay, a.dep_gate, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_status, a.dep_season, a.dep_dop, a.dep_source, a.dep_user_created, a.dep_last_update, a.dep_is_active,
                b.airline_terminal as dep_terminal,
                c.acsize as dep_acsize,
                c.actype as master_dep_actype
                FROM sch_dep a
                INNER JOIN tb_airline b on b.flightkey = a.dep_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.dep_acreg
                WHERE a.dep_status = 'OPERATED' and a.dep_is_active = 1 AND date(a.dep_std) = CURDATE()
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
        )   SELECT COUNT(*) as ct
            FROM ranked_time_diff a
            WHERE rn_arr = 1 and rn_dep = 1
			AND arr_destination='$cs->code_station' AND dep_origin='$cs->code_station'")->row();

        return $r->ct;
    }
    public function gettotalflightdailyarr($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $r = $this->db->query("SELECT COUNT(*) as ct FROM `sch_arr` WHERE arr_status='OPERATED' AND DATE(arr_sta)=CURDATE() AND arr_destination='".$cs->code_station."' ORDER BY arr_sta ASC")->row();
		return $r->ct;
    }
    public function gettotalflightdailydep($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $r = $this->db->query("SELECT COUNT(*) as ct FROM `sch_dep` WHERE dep_status='OPERATED' AND DATE(dep_std)=CURDATE() AND dep_origin='".$cs->code_station."' ORDER BY dep_std ASC")->row();
		return $r->ct;
    }
    public function gettotalflightdailycancel($id_sts)
    {
        $this->db->select('code_station');
        $this->db->from('tb_station');
        $this->db->where('id_sts', $id_sts);
        $cs = $this->db->get()->row();

        $r = $this->db->query("WITH arr AS (
                SELECT a.arr_id, a.arr_flightkey, a.arr_flightno, a.arr_actype, a.arr_acreg, c.acsize as arr_acsize, a.arr_origin, a.arr_destination, a.arr_bay, a.arr_gate, a.arr_sta, a.arr_eta, a.arr_ata, a.arr_landing, a.arr_status, a.arr_season, a.arr_dop, a.arr_source, a.arr_user_created, a.arr_last_update, a.arr_is_active, 
                c.actype as master_arr_actype,
                b.airline_terminal as arr_terminal
                FROM sch_arr a
                INNER JOIN tb_airline b on b.flightkey = a.arr_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.arr_acreg
                where a.arr_is_active = 1 AND a.arr_status = 'NON-OPERATED' 
                AND date(a.arr_sta) BETWEEN CURDATE() - INTERVAL 3 DAY AND CURDATE() AND a.arr_destination='$cs->code_station'
        ), dep AS (
                SELECT a.dep_id, a.dep_flightkey, a.dep_flightno, a.dep_actype, a.dep_acreg, a.dep_origin, a.dep_destination, a.dep_bay, a.dep_gate, a.dep_std, a.dep_etd, a.dep_atd, a.dep_airborne, a.dep_status, a.dep_season, a.dep_dop, a.dep_source, a.dep_user_created, a.dep_last_update, a.dep_is_active,
                b.airline_terminal as dep_terminal,
                c.acsize as dep_acsize,
                c.actype as master_dep_actype
                FROM sch_dep a
                INNER JOIN tb_airline b on b.flightkey = a.dep_flightkey
                INNER JOIN tb_aircraft c on c.acreg = a.dep_acreg
                WHERE a.dep_status = 'NON-OPERATED' and a.dep_is_active = 1 AND date(a.dep_std) = CURDATE() AND a.dep_origin='$cs->code_station'
        ), count_arr AS (
            SELECT COUNT(1) as carr FROM arr
        ), count_dep AS (
            SELECT COUNT(1) as cdep FROM dep
        )   SELECT (SELECT carr from count_arr) + (SELECT cdep from count_dep) as total")->row();

        return $r->total;
    }

    // // flight donut
    // public function getflightdonutdaily($id_sts, $w)
    // {
    //     $this->db->select('code_station');
    //     $this->db->from('tb_station');
    //     $this->db->where('id_sts', $id_sts);
    //     $cs = $this->db->get()->row();

    //     $r = $this->db->query("SELECT COUNT(*) as ct FROM `fl_schedule` WHERE STR_TO_DATE(a_sch_in, '%Y-%m-%d')=CURDATE() AND a_des_cod_iata ='".$cs->code_station."' AND a_operator_iata='".$w."' ORDER BY a_sch_in ASC")->row();
	// 	return $r->ct;
    // }
}
