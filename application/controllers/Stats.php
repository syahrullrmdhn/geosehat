<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Stats extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_statistic');
        $this->load->model('M_disease');
        $this->load->model('M_region');
        $this->load->helper(['url']);
    }
    public function index() {
        $filters = [
            'disease_code' => $this->input->get('disease_code'),
            'region_code'  => $this->input->get('region_code'),
            'date_from'    => $this->input->get('date_from'),
            'date_to'      => $this->input->get('date_to')
        ];
        $data['trend']     = $this->M_statistic->trend($filters);
        $data['pie']       = $this->M_statistic->pie($filters);
        $data['by_region'] = $this->M_statistic->by_region($filters);
        $data['diseases']  = $this->M_disease->get_all();
        $data['regions']   = $this->M_region->get_all();
        
        $this->load->view('templates/header');
        $this->load->view('stats/index',$data);
        $this->load->view('templates/footer');
    }
}
