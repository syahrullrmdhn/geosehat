<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library(['form_validation','session']);
        $this->load->helper('url');
    }
    public function index() {
        $data['users'] = $this->M_user->get_all();
        $this->load->view('users/index',$data);
    }
    public function store() {
        $rules=[
            ['field'=>'username','label'=>'Username','rules'=>'required'],
            ['field'=>'email','label'=>'Email','rules'=>'required|valid_email'],
            ['field'=>'password','label'=>'Password','rules'=>'required'],
            ['field'=>'role','label'=>'Role','rules'=>'required']
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()===FALSE) return $this->index();
        $d = $this->input->post(NULL,true);
        $d['password'] = password_hash($d['password'],PASSWORD_DEFAULT);
        $this->M_user->insert($d);
        $this->session->set_flashdata('success','User added');
        redirect('users');
    }
    public function delete($id) {
        $this->M_user->delete($id);
        redirect('users');
    }
}