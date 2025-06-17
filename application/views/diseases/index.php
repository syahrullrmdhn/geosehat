<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header'); ?>

<div class="min-h-screen flex bg-gray-100">
  <main class="flex-1 max-w-4xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Master Penyakit</h2>

      <!-- Validation Errors -->
      <?php if (validation_errors()): ?>
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form action="<?= site_url('diseases/store') ?>" method="post" id="diseaseForm" class="mb-8 flex flex-col sm:flex-row sm:items-end space-y-4 sm:space-y-0 sm:space-x-4">
        <div class="flex-1">
          <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Penyakit</label>
          <input type="text" name="code" id="code" placeholder="Masukkan kode penyakit" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="code_error">Kode penyakit harus diisi.</p>
        </div>
        <div class="flex-1">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Penyakit</label>
          <input type="text" name="name" id="name" placeholder="Masukkan nama penyakit" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="name_error">Nama penyakit harus diisi.</p>
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition sm:w-auto">Tambah</button>
      </form>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (empty($diseases)): ?>
              <tr>
                <td colspan="3" class="p-4 text-center text-sm text-gray-500">Tidak ada data penyakit.</td>
              </tr>
            <?php else: ?>
              <?php foreach($diseases as $d): ?>
                <tr class="hover:bg-gray-50">
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($d->code) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($d->name) ?></td>
                  <td class="p-4">
                    <a href="<?= site_url('diseases/delete/'.$d->code) ?>" class="text-red-600 hover:text-red-800 font-medium delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus penyakit <?= html_escape($d->name) ?>?')">Hapus</a>
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

<!-- JavaScript for Client-Side Validation -->
<script>
document.getElementById('diseaseForm').addEventListener('submit', function(e) {
  let isValid = true;

  // Reset error messages
  document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

  // Validate fields
  const fields = [
    { id: 'code', errorId: 'code_error', message: 'Kode penyakit harus diisi.' },
    { id: 'name', errorId: 'name_error', message: 'Nama penyakit harus diisi.' }
  ];

  fields.forEach(field => {
    const input = document.getElementById(field.id);
    if (!input.value.trim()) {
      document.getElementById(field.errorId).classList.remove('hidden');
      isValid = false;
    }
  });

  if (!isValid) {
    e.preventDefault();
  }
});
</script>

<?php $this->load->view('templates/footer'); ?>