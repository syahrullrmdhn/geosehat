<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_case');
        $this->load->model('M_region');
        $this->load->model('M_disease');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index() {
        // 1) Data semua kasus beserta nama penyakit, faskes, wilayah, dll
        $data['cases'] = $this->M_case->get_all_with_details();
        // 2) Daftar penyakit untuk filter
        $data['diseases']  = $this->M_disease->get_all();
        // 3) Daftar provinsi untuk filter
        $data['provinces'] = $this->M_region->get_by_level('provinsi');
        // 4) Timestamp update terakhir
        $data['last_update'] = date('Y-m-d H:i:s');

        // 5) Render halaman
        // $this->load->view('templates/header',  $data);
        // $this->load->view('templates/sidebar', $data);
        $this->load->view('map/index',              $data);
        $this->load->view('templates/footer');
    }
}
