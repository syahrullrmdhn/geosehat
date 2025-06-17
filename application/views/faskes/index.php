<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="min-h-screen flex bg-gray-100">
  <main class="flex-1 max-w-6xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-semibold text-gray-800">Master Fasilitas Kesehatan</h2>
        <a href="<?= site_url('faskes/create') ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          Tambah Faskes
        </a>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (empty($faskes)): ?>
              <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data fasilitas kesehatan.</td>
              </tr>
            <?php else: ?>
              <?php foreach ($faskes as $f): ?>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 text-sm text-gray-700"><?= html_escape($f->id) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= html_escape($f->code) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= html_escape($f->name) ?></td>
                  <td class="px-6 py-4 text-sm text-gray-700"><?= html_escape($f->address) ?></td>
                  <td class="px-6 py-4">
                    <a href="<?= site_url('faskes/edit/'.$f->id) ?>" class="text-indigo-600 hover:text-indigo-800 font-medium mr-4">Edit</a>
                    <a href="<?= site_url('faskes/delete/'.$f->id) ?>" class="text-red-600 hover:text-red-800 font-medium delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus fasilitas kesehatan <?= html_escape($f->name) ?>?')">Hapus</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>