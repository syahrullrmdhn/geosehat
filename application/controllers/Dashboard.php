<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_case');
        $this->load->model('M_region');
        $this->load->helper('url');
    }

    public function index() {
        // 1. Statistik utama
        $data['stats'] = [
            'active_cases'     => $this->M_case->sumColumn('confirmed'),
            'recovered_cases'  => $this->M_case->sumColumn('recovered'),
            'critical_cases'   => $this->M_case->sumColumn('deaths'),
            'tests_conducted'  => $this->M_case->sumColumn('suspected'),
        ];

        // 2. Data kasus per wilayah
        $raw = $this->M_case->get_by_region();
        $locations = [];
        foreach ($raw as $r) {
            $region = $this->M_region->get($r->label);
            $locations[] = (object)[
                'id'           => $r->label,
                'name'         => $region ? $region->name : $r->label,
                'active_cases' => (int)$r->value,
                // tambahkan population agar view bisa mengaksesnya
                'population'   => $region ? (int)$region->population : 0,
            ];
        }
        $data['locations']   = $locations;

        // 3. Timestamp terakhir (WIB)
        date_default_timezone_set('Asia/Jakarta');
        $data['last_update'] = date('Y-m-d H:i:s');

        // 4. Render views
        $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('templates/footer');
    }
}
