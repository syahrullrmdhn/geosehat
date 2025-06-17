<?php defined('BASEPATH') OR exit('No direct script access allowed'); $this->load->view('templates/header'); ?>
<div class="h-full flex"><main class="flex-1 p-6 bg-gray-50">
  <h2 class="text-2xl font-bold mb-4">Generate Laporan</h2>
  <form action="<?= site_url('reports/export_csv') ?>" method="get" class="grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow">
    <!-- filters -->
    <button class="col-span-3 bg-green-500 text-white p-2 rounded">Export CSV</button>
  </form>
</main></div>
<?php $this->load->view('templates/footer'); ?>