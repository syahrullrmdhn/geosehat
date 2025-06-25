<?php defined('BASEPATH') OR exit('No direct script access allowed');
class FaskesStaff extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_faskes_staff');
        $this->load->model('M_region');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        $data['items'] = $this->M_faskes_staff->get_all();
        $data['regions'] = $this->M_region->get_by_level('provinsi');
        $this->load->view('faskes_staff/index', $data);
    }

    public function store() {
        $rules = [
            ['field'=>'region_code','label'=>'Region','rules'=>'required'],
            ['field'=>'required_staff','label'=>'Required','rules'=>'required|integer'],
            ['field'=>'current_staff','label'=>'Current','rules'=>'required|integer']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()===FALSE) return $this->index();
        $this->M_faskes_staff->insert($this->input->post(NULL,true));
        redirect('faskes-staff');
    }

    public function edit($id) {
        $data['item'] = $this->M_faskes_staff->get($id);
        $data['regions'] = $this->M_region->get_by_level('provinsi');
        $this->load->view('faskes_staff/edit', $data);
    }

    public function update($id) {
        $rules = [
            ['field'=>'region_code','label'=>'Region','rules'=>'required'],
            ['field'=>'required_staff','label'=>'Required','rules'=>'required|integer'],
            ['field'=>'current_staff','label'=>'Current','rules'=>'required|integer']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()===FALSE) return $this->edit($id);
        $this->M_faskes_staff->update($id, $this->input->post(NULL,true));
        redirect('faskes-staff');
    }

    public function delete($id) {
        $this->M_faskes_staff->delete($id);
        redirect('faskes-staff');
    }
}
