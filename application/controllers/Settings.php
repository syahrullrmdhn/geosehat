<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // jika butuh model untuk menyimpan/load preferensi:
        // $this->load->model('M_notification');
        $this->load->helper('url');
    }

    /**
     * Tampilkan halaman Pengaturan Notifikasi
     */
    public function notifications() {
        // ambil data notifikasi dari model (jika ada)
        // $data['prefs'] = $this->M_notification->get_prefs( $this->session->userdata('id') );
        // untuk demo kita hard-code default:
        $data['prefs'] = [
            'email'   => true,
            'sms'     => false,
            'browser' => true,
        ];

        // render
        $this->load->view('templates/header', $data);
        // $this->load->view('templates/sidebar', $data);
        $this->load->view('settings/notifications', $data);
        $this->load->view('templates/footer');
    }

    /**
     * Simpan preferensi notifikasi
     */
    public function save_notifications() {
        // validasi input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email',   'Email Notification',   'in_list[0,1]');
        $this->form_validation->set_rules('sms',     'SMS Notification',     'in_list[0,1]');
        $this->form_validation->set_rules('browser', 'Browser Notification', 'in_list[0,1]');

        if ($this->form_validation->run() === FALSE) {
            // kembalikan ke form dengan error
            $this->notifications();
            return;
        }

        // ambil input
        $prefs = [
            'email'   => $this->input->post('email')   ? 1 : 0,
            'sms'     => $this->input->post('sms')     ? 1 : 0,
            'browser' => $this->input->post('browser') ? 1 : 0,
        ];

        // simpan ke DB via model
        // $this->M_notification->save_prefs($this->session->userdata('id'), $prefs);

        // beri flashdata sukses
        $this->session->set_flashdata('success', 'Preferensi notifikasi berhasil disimpan.');
        redirect('settings/notifications');
    }
}
