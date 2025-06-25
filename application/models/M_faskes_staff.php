<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_faskes_staff extends CI_Model {
    protected $table = 'faskes_staff';

    public function get_all() {
        return $this->db->select('fs.*, r.name as region_name')
                        ->from($this->table.' fs')
                        ->join('regions r', 'r.code = fs.region_code', 'left')
                        ->order_by('r.name','ASC')
                        ->get()->result();
    }

    public function get($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function insert(array $data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, array $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
