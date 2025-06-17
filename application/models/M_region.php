<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_region extends CI_Model {
    protected $table = 'regions';

    /**
     * Ambil semua region tanpa filter
     */
    public function get_all() {
        return $this->db
                    ->order_by('name', 'ASC')
                    ->get($this->table)
                    ->result();
    }

    /**
     * Ambil region berdasarkan level tertentu
     * @param string $level  'provinsi' | 'kabupaten' | 'kecamatan' | 'kelurahan'
     */
    public function get_by_level(string $level) {
        return $this->db
                    ->where('level', $level)
                    ->order_by('name', 'ASC')
                    ->get($this->table)
                    ->result();
    }

    /**
     * Ambil semua kabupaten/kota di bawah provinsi $prov_code
     * untuk dropdown cascading
     */
    public function get_cities(string $prov_code) {
        return $this->db
                    ->where('level', 'kabupaten')
                    ->where('parent_code', $prov_code)
                    ->order_by('name', 'ASC')
                    ->get($this->table)
                    ->result();
    }

    /**
     * Ambil satu region berdasarkan code
     */
    public function get(string $code) {
        return $this->db
                    ->where('code', $code)
                    ->get($this->table)
                    ->row();
    }

    /**
     * Insert new region
     */
    public function insert(array $d) {
        return $this->db->insert($this->table, $d);
    }

    /**
     * Hapus region by code
     */
    public function delete(string $code) {
        return $this->db->delete($this->table, ['code' => $code]);
    }
}
