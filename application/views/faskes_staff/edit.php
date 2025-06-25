<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="h-full flex">
  <main class="flex-1 p-6 bg-gray-50">
    <h2 class="text-2xl font-bold mb-4">Edit Tenaga Faskes</h2>
    <?php echo validation_errors('<div class="text-red-600 mb-4">','</div>'); ?>
    <form action="<?= site_url('faskes-staff/update/'.$item->id) ?>" method="post" class="bg-white p-6 rounded-lg shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label>Wilayah</label>
          <select name="region_code" class="mt-1 block w-full border-gray-300 rounded">
            <?php foreach($regions as $r): ?>
            <option value="<?= $r->code ?>" <?= $item->region_code==$r->code?'selected':'' ?>><?= $r->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label>Kebutuhan</label>
          <input type="number" name="required_staff" value="<?= $item->required_staff ?>" class="mt-1 block w-full border-gray-300 rounded">
        </div>
        <div>
          <label>Tersedia</label>
          <input type="number" name="current_staff" value="<?= $item->current_staff ?>" class="mt-1 block w-full border-gray-300 rounded">
        </div>
      </div>
      <div class="mt-6 flex space-x-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="<?= site_url('faskes-staff') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</a>
      </div>
    </form>
  </main>
</div>
