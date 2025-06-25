<?php
class M_user extends CI_Model {
    protected $table = 'users';
    public function get_all() {
        return $this->db->order_by('username')->get($this->table)->result();
    }
    public function insert(array $d) {
        return $this->db->insert($this->table,$d);
    }
    public function get($id) {
        return $this->db->where('id',$id)->get($this->table)->row();
    }
    public function update($id, array $d) {
        return $this->db->where('id',$id)->update($this->table,$d);
    }
    public function delete($id) {
        return $this->db->delete($this->table,['id'=>$id]);
    }
}