<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Thresholds extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_threshold');
        $this->load->library(['form_validation','session']);
        $this->load->helper('url');
    }
    public function index() {
        $data['threshold'] = $this->M_threshold->get(1);
        $this->load->view('thresholds/index',$data);
    }
    public function update() {
        $this->form_validation->set_rules('green_upper','Green','required|decimal');
        $this->form_validation->set_rules('yellow_upper','Yellow','required|decimal');
        $this->form_validation->set_rules('red_upper','Red','required|decimal');
        if ($this->form_validation->run()===FALSE) return $this->index();
        $this->M_threshold->update(1,$this->input->post(NULL,true));
        $this->session->set_flashdata('success','Threshold updated');
        redirect('thresholds');
    }
}