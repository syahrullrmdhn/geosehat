<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Case_model extends CI_Model {
    protected $table = 'cases';

    public function get_by_date($date)
    {
        return $this->db->where('date_report', $date)->get($this->table)->result();
    }

    public function exists($region_code, $date)
    {
        return $this->db->where('region_code',$region_code)
                        ->where('date_report',$date)
                        ->count_all_results($this->table) > 0;
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Tren penyakit terbanyak (global top5)
     */
    public function get_disease_trend()
    {
        $this->db->select('d.name AS disease_name, COUNT(c.id) AS total_cases');
        $this->db->from($this->table . ' c');
        $this->db->join('diseases d', 'c.disease_code = d.code', 'left');
        $this->db->group_by('c.disease_code');
        $this->db->order_by('total_cases', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return [
            'top5' => $query->result()
        ];
    }

    /**
     * Tren penyakit per level wilayah (optional)
     */
    public function get_disease_trend_by_level($prefix, $level = 'kabupaten', $limit = 5)
    {
        $this->db->select('d.name AS disease_name, COUNT(c.id) AS total_cases');
        $this->db->from($this->table . ' c');
        $this->db->join('diseases d', 'c.disease_code = d.code', 'left');
        $this->db->join('regions r', 'c.region_code = r.code', 'left');
        $this->db->where("r.code LIKE '".$prefix."%'");
        $this->db->where('r.level', $level);
        $this->db->group_by('c.disease_code');
        $this->db->order_by('total_cases', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Ambil lokasi untuk peta & tabel
     */
    public function get_locations($limit = 10, $offset = 0)
    {
        $this->db->select('r.name, r.lat, r.lng, t.warning_date, t.ticket_date, t.status');
        $this->db->from('regions r');
        $this->db->join('last_ticket_view t', 'r.code = t.region_code', 'left');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_locations()
    {
        return $this->db->count_all('regions');
    }
}
