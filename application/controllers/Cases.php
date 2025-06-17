<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Cases extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_case');
        $this->load->model('M_disease');
        $this->load->model('M_region');
        $this->load->library(['form_validation','session']);
        $this->load->helper('url');
    }

    public function index() {
        $data['cases'] = $this->M_case->get_all();
        $this->load->view('cases/index', $data);
    }

    public function create() {
        $data['diseases'] = $this->M_disease->get_all();
        $data['regions']  = $this->M_region->get_all();
        $this->load->view('cases/create', $data);
    }

    public function store() {
        $this->form_validation->set_rules('region_code','Region','required');
        $this->form_validation->set_rules('disease_code','Disease','required');
        $this->form_validation->set_rules('date_report','Date Report','required|regex_match[/\d{4}-\d{2}-\d{2}/]');
        $fields = ['confirmed','suspected','recovered','deaths'];
        foreach ($fields as $f) {
            $this->form_validation->set_rules($f, ucfirst($f),'required|integer');
        }

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }

        $input = $this->input->post(NULL, true);
        $input['user_id'] = $this->session->userdata('id');

        $this->M_case->insert($input);
        $this->session->set_flashdata('success','Case saved successfully');
        redirect('cases');
    }

    public function delete($id) {
        $this->M_case->delete($id);
        $this->session->set_flashdata('success','Case deleted');
        redirect('cases');
    }
}