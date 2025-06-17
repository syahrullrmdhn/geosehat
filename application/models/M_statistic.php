<?php

class M_statistic extends CI_Model {
    public function trend(array $filters=[]) {
        $this->db->select('date_report AS date, SUM(confirmed) AS confirmed, SUM(recovered) AS recovered, SUM(deaths) AS deaths');
        $this->db->from('cases');
        if (!empty($filters['disease_code'])) $this->db->where('disease_code',$filters['disease_code']);
        if (!empty($filters['date_from']))     $this->db->where('date_report >=',$filters['date_from']);
        if (!empty($filters['date_to']))       $this->db->where('date_report <=',$filters['date_to']);
        $this->db->group_by('date_report');
        return $this->db->order_by('date_report','ASC')->get()->result();
    }
    public function pie(array $filters=[]) {
        $this->db->select('disease_code AS label, SUM(confirmed) AS value');
        $this->db->from('cases');
        if (!empty($filters['date_from'])) $this->db->where('date_report >=',$filters['date_from']);
        if (!empty($filters['date_to']))   $this->db->where('date_report <=',$filters['date_to']);
        $this->db->group_by('disease_code');
        return $this->db->get()->result();
    }
    public function by_region(array $filters=[]) {
        $this->db->select('region_code AS label, SUM(confirmed) AS value');
        $this->db->from('cases');
        if (!empty($filters['date_from'])) $this->db->where('date_report >=',$filters['date_from']);
        if (!empty($filters['date_to']))   $this->db->where('date_report <=',$filters['date_to']);
        $this->db->group_by('region_code');
        return $this->db->get()->result();
    }
}