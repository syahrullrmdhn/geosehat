<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['users'] = $this->M_user->get_all();
        $this->load->view('admin/users/index', $data);
    }

    public function store() {
        $this->form_validation->set_rules('username','Username','required');
        $this->form_validation->set_rules('password','Password','required');
        $this->form_validation->set_rules('passconf','Konfirmasi Password','required|matches[password]');
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('role','Peran','required');

        if ($this->form_validation->run()===FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('admin/users');
        }
        $input = [
            'username' => $this->input->post('username', true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'nama'     => $this->input->post('nama', true),
            'email'    => $this->input->post('email', true),
            'role'     => $this->input->post('role', true),
            'status'   => $this->input->post('status')
        ];
        $this->M_user->insert($input);
        $this->session->set_flashdata('success','Pengguna berhasil ditambahkan');
        redirect('admin/users');
    }

    public function edit($id) {
        $data['user'] = $this->M_user->get($id);
        $this->load->view('admin/users/edit', $data);
    }

    public function update($id) {
        $rules = [
            ['field'=>'username','label'=>'Username','rules'=>'required'],
            ['field'=>'email','label'=>'Email','rules'=>'required|valid_email'],
            ['field'=>'role','label'=>'Peran','rules'=>'required'],
            ['field'=>'status','label'=>'Status','rules'=>'required'],
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run()===FALSE) {
            $this->session->set_flashdata('errors', validation_errors());
            redirect('admin/users/edit/'.$id);
        }
        $input = [
            'username'=> $this->input->post('username', true),
            'nama'    => $this->input->post('nama', true),
            'email'   => $this->input->post('email', true),
            'role'    => $this->input->post('role', true),
            'status'  => $this->input->post('status')
        ];
        if ($this->input->post('password')) {
            $input['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }
        $this->M_user->update($id, $input);
        $this->session->set_flashdata('success','Pengguna berhasil diperbarui');
        redirect('admin/users');
    }

    public function delete($id) {
        $this->M_user->delete($id);
        $this->session->set_flashdata('success','Pengguna berhasil dihapus');
        redirect('admin/users');
    }

    public function toggle_status($id) {
        $user = $this->M_user->get($id);
        $newStatus = ($user->status === 'Aktif') ? 'Tidak Aktif' : 'Aktif';
        $this->M_user->update($id, ['status'=>$newStatus]);
        $this->session->set_flashdata('success','Status pengguna diubah');
        redirect('admin/users');
    }

    public function reset_password($id) {
        $newPass = 'default123';
        $this->M_user->update($id, ['password'=>password_hash($newPass, PASSWORD_DEFAULT)]);
        $this->session->set_flashdata('success','Password direset ke: '.$newPass);
        redirect('admin/users');
    }
}
