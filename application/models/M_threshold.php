<?php
class M_threshold extends CI_Model {
    protected $table = 'thresholds';
    public function get($id) {
        return $this->db->get_where($this->table,['id'=>$id])->row();
    }
    public function update($id,array $d) {
        return $this->db->update($this->table,$d,['id'=>$id]);
    }
}