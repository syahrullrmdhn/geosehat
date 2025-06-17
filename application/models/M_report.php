<?php
class M_report extends CI_Model {
    public function make(string $type, array $filters) {
        // Ambil data berdasarkan filter
        $cases = $this->db->get_where('tbl_cases', [
            'jenis_penyakit' => $filters['penyakit'],
            'tgl_diagnosis >=' => $filters['from'],
            'tgl_diagnosis <=' => $filters['to']
        ])->result_array();

        $timestamp = date('Ymd_His');
        if ($type === 'pdf') {
            $filePath = FCPATH . "reports/report_{$timestamp}.pdf";
            // TODO: generate PDF ke $filePath
            return ['path'=>$filePath, 'download_name'=>'Laporan_'.$timestamp.'.pdf'];
        } else {
            $filePath = FCPATH . "reports/report_{$timestamp}.xlsx";
            // TODO: generate Excel ke $filePath
            return ['path'=>$filePath, 'download_name'=>'Laporan_'.$timestamp.'.xlsx'];
        }
    }
}