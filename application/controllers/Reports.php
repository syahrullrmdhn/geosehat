<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('M_case');
        $this->load->helper(['url','download']);
    }
    public function index() {
        $this->load->view('reports/index');
    }
    public function export_csv() {
        $filters = $this->input->get(NULL,true);
        $cases = $this->M_case->get_all($filters);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="cases_'.date('Ymd').'.csv"');
        $out = fopen('php://output','w');
        fputcsv($out, ['ID','Region','Disease','Date','Confirmed','Suspected','Recovered','Deaths']);
        foreach ($cases as $c) {
            fputcsv($out, [
                $c->id, $c->region, $c->disease, $c->date_report,
                $c->confirmed, $c->suspected, $c->recovered, $c->deaths
            ]);
        }
        fclose($out);
    }
}