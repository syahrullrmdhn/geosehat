<?php

class M_disease extends CI_Model {
    protected $table = 'diseases';
    public function get_all() {
        return $this->db->order_by('name')->get($this->table)->result();
    }
    public function insert(array $d) {
        return $this->db->insert($this->table,$d);
    }
    public function delete($code) {
        return $this->db->delete($this->table, ['code'=>$code]);
    }
}