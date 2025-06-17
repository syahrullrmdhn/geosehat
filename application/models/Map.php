<?php
class Map extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_case');
        $this->load->model('M_master_wilayah');
    }

    public function index() {
        $filters = [
            'penyakit' => $this->input->get('jenis_penyakit'),
            'from'     => $this->input->get('from'),
            'to'       => $this->input->get('to'),
            'province' => $this->input->get('province'),
            'city'     => $this->input->get('city')
        ];
        $data['cases']     = $this->M_case->get_all($filters);
        $data['provinces'] = $this->M_master_wilayah->get_provinces();
        $data['cities']    = !empty($filters['province'])
                             ? $this->M_master_wilayah->get_cities($filters['province'])
                             : [];
        $this->load->view('map/index', $data);
    }
}