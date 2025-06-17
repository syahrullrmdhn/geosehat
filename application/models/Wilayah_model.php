<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wilayah_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_regions() {
        $this->db->select('id, parent_id, level, name');
        $this->db->from('region');
        $this->db->order_by('level, name');
        $query = $this->db->get();
        $results = $query->result_array();

        return $this->build_hierarchy($results);
    }

    private function build_hierarchy($flat_data) {
        $hierarchy = [];
        $indexed = [];

        foreach ($flat_data as $row) {
            $indexed[$row['id']] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'level' => $row['level'],
                'parent_id' => $row['parent_id'],
                'children' => []
            ];
        }

        foreach ($indexed as $id => &$node) {
            if ($node['parent_id'] === NULL) {
                $hierarchy[] = &$node;
            } else {
                $indexed[$node['parent_id']]['children'][] = &$node;
            }
        }

        return $this->transform_hierarchy($hierarchy);
    }

    private function transform_hierarchy($hierarchy) {
        $result = [];
        foreach ($hierarchy as $provinsi) {
            $provinsi_data = [
                'provinsi' => $provinsi['name'],
                'kota_kabupaten' => []
            ];
            foreach ($provinsi['children'] as $kota) {
                $kota_data = [
                    'nama' => $kota['name'],
                    'kecamatan' => []
                ];
                foreach ($kota['children'] as $kecamatan) {
                    $kecamatan_data = [
                        'nama' => $kecamatan['name'],
                        'kelurahan' => []
                    ];
                    foreach ($kecamatan['children'] as $kelurahan) {
                        $kecamatan_data['kelurahan'][] = $kelurahan['name'];
                    }
                    $kota_data['kecamatan'][] = $kecamatan_data;
                }
                $provinsi_data['kota_kabupaten'][] = $kota_data;
            }
            $result[] = $provinsi_data;
        }
        return $result;
    }
}