<?php class M_master_wilayah extends CI_Model {
    protected $table = 'tbl_master_wilayah';

    public function get_provinces() {
        $this->db->distinct();
        $this->db->select('province');
        return $this->db->get($this->table)->result();
    }

    public function get_cities(string $province) {
        return $this->db->where('province', $province)
                        ->distinct()
                        ->select('city')
                        ->get($this->table)
                        ->result();
    }
}