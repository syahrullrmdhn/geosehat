<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Region_model extends CI_Model {
    protected $table = 'regions';

    public function get_all()
    {
        return $this->db->order_by('name','ASC')->get($this->table)->result();
    }
}
