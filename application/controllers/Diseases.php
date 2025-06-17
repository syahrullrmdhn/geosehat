<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Diseases extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_disease');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
    public function index() {
        $data['diseases'] = $this->M_disease->get_all();
        $this->load->view('diseases/index',$data);
    }
    public function store() {
        $this->form_validation->set_rules('code','Code','required');
        $this->form_validation->set_rules('name','Name','required');
        if ($this->form_validation->run()===FALSE) return $this->index();
        $this->M_disease->insert($this->input->post(NULL,true));
        redirect('diseases');
    }
    public function delete($code) {
        $this->M_disease->delete($code);
        redirect('diseases');
    }
}