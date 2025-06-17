<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_case extends CI_Model {
    protected $table = 'cases';

    /**
     * Fetch cases with optional filters: disease_code, date_from, date_to, region_code
     */
    public function get_all(array $filters = []) {
        $this->db->select('c.*, d.name AS disease, r.name AS region, r.lat, r.lng');
        $this->db->from('cases c');
        $this->db->join('diseases d','c.disease_code=d.code');
        $this->db->join('regions r','c.region_code=r.code');

        if (!empty($filters['disease_code'])) {
            $this->db->where('c.disease_code', $filters['disease_code']);
        }
        if (!empty($filters['region_code'])) {
            $this->db->where('c.region_code', $filters['region_code']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('c.date_report >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('c.date_report <=', $filters['date_to']);
        }

        return $this->db->order_by('c.date_report','DESC')
                        ->get()
                        ->result();
    }

    /**
     * Fetch all cases with joined details for map view
     */
    public function get_all_with_details(array $filters = []) {
        $this->db->select([
            'c.id',
            'c.disease_code',
            'd.name AS disease_name',
            'c.region_code',
            'r.name AS region_name',
            'r.lat',
            'r.lng',
            'c.date_report',
            'c.confirmed',
            'c.suspected',
            'c.recovered',
            'c.deaths'
        ]);
        $this->db->from($this->table . ' c');
        $this->db->join('diseases d', 'c.disease_code = d.code');
        $this->db->join('regions r',  'c.region_code  = r.code');

        // jika diperlukan, terapkan filter yang sama seperti get_all()
        if (!empty($filters['disease_code'])) {
            $this->db->where('c.disease_code', $filters['disease_code']);
        }
        if (!empty($filters['region_code'])) {
            $this->db->where('c.region_code', $filters['region_code']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('c.date_report >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('c.date_report <=', $filters['date_to']);
        }

        return $this->db
                    ->order_by('c.date_report', 'DESC')
                    ->get()
                    ->result();
    }

    public function insert(array $data) {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function sumColumn(string $col) {
        $res = $this->db
                    ->select_sum($col)
                    ->get($this->table)
                    ->row_array();
        return (int)($res[$col] ?? 0);
    }

    /**
     * Ambil total confirmed per region (dipakai di Dashboard)
     */
    public function get_by_region() {
        return $this->db
            ->select('region_code AS label, SUM(confirmed) AS value')
            ->from($this->table)
            ->group_by('region_code')
            ->order_by('value','DESC')
            ->get()
            ->result();
    }
}
