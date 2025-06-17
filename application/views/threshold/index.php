<?php defined('BASEPATH') OR exit('No direct script access allowed'); $this->load->view('templates/header'); ?>
<div class="h-full flex"><main class="flex-1 p-6 bg-gray-50">
  <h2 class="text-2xl font-bold mb-4">Manage Thresholds</h2>
  <?php echo validation_errors('<div class="text-red-600">','</div>'); ?>
  <form action="<?= site_url('thresholds/update') ?>" method="post" class="grid grid-cols-3 gap-4 bg-white p-6 rounded-lg shadow">
    <div><label>Green Upper</label><input name="green_upper" value="<?= $threshold->green_upper ?>" class="border p-2 rounded"></div>
    <div><label>Yellow Upper</label><input name="yellow_upper" value="<?= $threshold->yellow_upper ?>" class="border p-2 rounded"></div>
    <div><label>Red Upper</label><input name="red_upper" value="<?= $threshold->red_upper ?>" class="border p-2 rounded"></div>
    <button class="col-span-3 bg-green-500 text-white p-2 rounded">Update Thresholds</button>
  </form>
</main></div>
<?php $this->load->view('templates/footer'); ?>