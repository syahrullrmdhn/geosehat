<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="flex-1 overflow-y-auto p-8">
  <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-semibold text-teal-700 mb-4">Pengaturan Threshold Zona</h2>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm"><?= $error ?></div>
    <?php endif; ?>

    <?= form_open('settings/threshold/update') ?>
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div>
          <label for="green_upper" class="block text-sm font-medium text-gray-700">Green Upper (IR &lt;)</label>
          <input type="number" step="0.01" name="green_upper" id="green_upper"
                 class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 
                        focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                 value="<?= set_value('green_upper', $threshold->green_upper) ?>" required>
          <?= form_error('green_upper','<small class="text-red-600">','</small>') ?>
        </div>
        <div>
          <label for="yellow_upper" class="block text-sm font-medium text-gray-700">Yellow Upper (IR &lt;)</label>
          <input type="number" step="0.01" name="yellow_upper" id="yellow_upper"
                 class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 
                        focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                 value="<?= set_value('yellow_upper', $threshold->yellow_upper) ?>" required>
          <?= form_error('yellow_upper','<small class="text-red-600">','</small>') ?>
        </div>
        <div>
          <label for="red_upper" class="block text-sm font-medium text-gray-700">Red Upper (IR &lt;)</label>
          <input type="number" step="0.01" name="red_upper" id="red_upper"
                 class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 
                        focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                 value="<?= set_value('red_upper', $threshold->red_upper) ?>" required>
          <?= form_error('red_upper','<small class="text-red-600">','</small>') ?>
        </div>
      </div>

      <button type="submit"
              class="w-full bg-gradient-to-r from-teal-500 to-green-500 text-white font-medium py-2 rounded-lg hover:opacity-90 transition">
        Simpan Pengaturan
      </button>
    <?= form_close() ?>
  </div>
</div>
