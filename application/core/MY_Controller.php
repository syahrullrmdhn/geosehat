<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        // Jika belum login, redirect ke login
        if (! $this->session->userdata('user')) {
            redirect('login');
        }
    }

    // Render layout lengkap: header, sidebar, konten, footer
    protected function render($view, $data = array())
    {
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer');
    }
}
