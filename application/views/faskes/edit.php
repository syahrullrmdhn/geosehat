<div class="h-full flex">
  <main class="flex-1 p-6 bg-gray-50">
    <h2 class="text-2xl font-bold mb-4">Edit Faskes</h2>
    <?php echo validation_errors('<div class="text-red-600 mb-4">','</div>'); ?>
    <form action="<?= site_url('faskes/update/'.$item->id) ?>" method="post" class="bg-white p-6 rounded-lg shadow">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label>Code</label><input name="code" value="<?= $item->code ?>" class="mt-1 block w-full border-gray-300 rounded"></div>
        <div><label>Name</label><input name="name" value="<?= $item->name ?>" class="mt-1 block w-full border-gray-300 rounded"></div>
        <div class="md:col-span-2"><label>Address</label>
          <textarea name="address" class="mt-1 block w-full border-gray-300 rounded"><?= $item->address ?></textarea>
        </div>
      </div>
      <div class="mt-6 flex space-x-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
        <a href="<?= site_url('faskes') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</a>
      </div>
    </form>
  </main>
</div>