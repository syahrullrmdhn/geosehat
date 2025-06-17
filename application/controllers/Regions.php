<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Regions extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_region');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }
    public function index() {
        $data['regions'] = $this->M_region->get_all();
        $this->load->view('regions/index',$data);
    }
    public function store() {
        $rules = [
            ['field'=>'code','label'=>'Code','rules'=>'required'],
            ['field'=>'name','label'=>'Name','rules'=>'required'],
            ['field'=>'lat','label'=>'Lat','rules'=>'required'],
            ['field'=>'lng','label'=>'Lng','rules'=>'required'],
            ['field'=>'level','label'=>'Level','rules'=>'required'],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()===FALSE) return $this->index();
        $this->M_region->insert($this->input->post(NULL,true));
        redirect('regions');
    }
    public function delete($code) {
        $this->M_region->delete($code);
        redirect('regions');
    }
}