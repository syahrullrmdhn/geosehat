<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Threshold_model extends CI_Model {
    protected $table = 'thresholds';

    public function get_latest()
    {
        return $this->db->order_by('id','DESC')->limit(1)->get($this->table)->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }
}
