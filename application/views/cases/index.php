<?php defined('BASEPATH') OR exit('No direct script access allowed'); date_default_timezone_set('Asia/Jakarta'); $last_update = date('Y-m-d H:i:s'); ?>
<?php $this->load->view('templates/header', ['last_update'=>$last_update]); ?>
<div class="h-full flex">
  <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
    <h2 class="text-2xl font-bold mb-4">Daftar Kasus</h2>
    <?php if($this->session->flashdata('success')): ?>
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>
    <a href="<?= site_url('cases/create') ?>" class="mb-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Tambah Kasus</a>
    <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3">ID</th><th class="px-6 py-3">Region</th><th class="px-6 py-3">Disease</th><th class="px-6 py-3">Date</th><th class="px-6 py-3">Confirmed</th><th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php foreach($cases as $c): ?>
            <tr>
              <td class="px-6 py-4"><?= $c->id ?></td>
              <td class="px-6 py-4"><?= html_escape($c->region) ?></td>
              <td class="px-6 py-4"><?= html_escape($c->disease) ?></td>
              <td class="px-6 py-4"><?= $c->date_report ?></td>
              <td class="px-6 py-4"><?= $c->confirmed ?></td>
              <td class="px-6 py-4"><a href="<?= site_url('cases/delete/'.$c->id) ?>" class="text-red-600">Hapus</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php $this->load->view('templates/footer'); ?>