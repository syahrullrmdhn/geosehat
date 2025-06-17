<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Faskes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_faskes');
        $this->load->library('form_validation');
        $this->load->helper('url');
    }

    public function index() {
        $data['faskes'] = $this->M_faskes->get_all();
        $this->load->view('templates/header');
        // $this->load->view('templates/sidebar');
        $this->load->view('faskes/index', $data);
        $this->load->view('templates/footer');
    }

    public function create() {
        $this->load->view('templates/header');
        // $this->load->view('templates/sidebar');
        $this->load->view('faskes/create');
        $this->load->view('templates/footer');
    }

    public function store() {
        $this->form_validation->set_rules('code','Code','required');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('address','Address','required');

        if ($this->form_validation->run() === FALSE) {
            return $this->create();
        }
        $input = $this->input->post(NULL, true);
        $this->M_faskes->insert($input);
        redirect('faskes');
    }

    public function edit($id) {
        $data['item'] = $this->M_faskes->get($id);
        $this->load->view('templates/header');
        // $this->load->view('templates/sidebar');
        $this->load->view('faskes/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update($id) {
        $this->form_validation->set_rules('code','Code','required');
        $this->form_validation->set_rules('name','Name','required');
        $this->form_validation->set_rules('address','Address','required');

        if ($this->form_validation->run() === FALSE) {
            return $this->edit($id);
        }
        $input = $this->input->post(NULL, true);
        $this->M_faskes->update($id, $input);
        redirect('faskes');
    }

    public function delete($id) {
        $this->M_faskes->delete($id);
        redirect('faskes');
    }
}
