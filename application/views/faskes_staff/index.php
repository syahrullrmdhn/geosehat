<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="min-h-screen flex bg-gray-100">
  <main class="flex-1 max-w-5xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <h2 class="text-3xl font-semibold mb-6">Tenaga Faskes per Wilayah</h2>
      <form action="<?= site_url('faskes-staff/store') ?>" method="post" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <select name="region_code" class="border rounded p-2">
          <option value="">Pilih Wilayah</option>
          <?php foreach($regions as $r): ?>
          <option value="<?= $r->code ?>"><?= $r->name ?></option>
          <?php endforeach; ?>
        </select>
        <input type="number" name="required_staff" placeholder="Kebutuhan" class="border rounded p-2">
        <input type="number" name="current_staff" placeholder="Tersedia" class="border rounded p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded md:col-span-3">Simpan</button>
      </form>
      <div class="overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wilayah</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kebutuhan</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tersedia</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gap</th>
              <th class="px-6 py-3"></th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php foreach($items as $i): ?>
            <tr>
              <td class="px-6 py-4 text-sm"><?= html_escape($i->region_name) ?></td>
              <td class="px-6 py-4 text-sm"><?= (int)$i->required_staff ?></td>
              <td class="px-6 py-4 text-sm"><?= (int)$i->current_staff ?></td>
              <td class="px-6 py-4 text-sm"><?= (int)$i->required_staff - (int)$i->current_staff ?></td>
              <td class="px-6 py-4 text-sm">
                <a href="<?= site_url('faskes-staff/edit/'.$i->id) ?>" class="text-indigo-600 mr-4">Edit</a>
                <a href="<?= site_url('faskes-staff/delete/'.$i->id) ?>" onclick="return confirm('Hapus data?')" class="text-red-600">Hapus</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
