<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login()
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login' , ['page_title' => 'Login']);;
    }

    public function login_submit()
    {
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Password','required');

        if ($this->form_validation->run() == FALSE) {
            $this->login();
            return;
        }

        $email    = $this->input->post('email', TRUE);
        $password = $this->input->post('password', TRUE);
        $user = $this->User_model->get_by_email($email);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata('user', [
                'id'       => $user->id,
                'username' => $user->username,
                'role'     => $user->role,
                'email'    => $user->email
            ]);
            redirect('dashboard');
        } else {
            $data['error'] = 'Email atau password salah.';
            $this->load->view('templates/header', ['page_title' => 'Login']);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        }
    }

    public function register()
    {
        if ($this->session->userdata('user')) {
            redirect('dashboard');
        }

        $this->load->view('auth/register',['page_title' => 'Register']);

    }

    public function register_submit()
    {
        $this->form_validation->set_rules('username','Username','required|min_length[3]');
        $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        $this->form_validation->set_rules('password_confirm','Confirm Password','required|matches[password]');
        $this->form_validation->set_rules('agree','Agreement','required');

        if ($this->form_validation->run() == FALSE) {
            $this->register();
            return;
        }

        $data = [
            'username' => $this->input->post('username', TRUE),
            'email'    => $this->input->post('email', TRUE),
            'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
            'role'     => 'pic'
        ];
        $this->User_model->insert($data);
        redirect('login');
    }

    public function logout()
    {
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
        redirect('login');
    }
}
