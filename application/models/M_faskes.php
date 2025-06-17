<?php defined('BASEPATH') OR exit('No direct script access allowed');
class M_faskes extends CI_Model {
    protected $table = 'tbl_master_faskes';

    public function get_all() {
        return $this->db->order_by('name')->get($this->table)->result();
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