<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header'); ?>

<div class="min-h-screen flex bg-gray-100">
  <main class="flex-1 max-w-5xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Master Wilayah</h2>

      <!-- Validation Errors -->
      <?php if (validation_errors()): ?>
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form action="<?= site_url('regions/store') ?>" method="post" id="regionForm" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div>
          <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Wilayah</label>
          <input type="text" name="code" id="code" placeholder="Masukkan kode wilayah" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="code_error">Kode wilayah harus diisi.</p>
        </div>
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Wilayah</label>
          <input type="text" name="name" id="name" placeholder="Masukkan nama wilayah" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="name_error">Nama wilayah harus diisi.</p>
        </div>
        <div>
          <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
          <select name="level" id="level" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="provinsi">Provinsi</option>
            <option value="kabupaten">Kabupaten</option>
            <option value="kecamatan">Kecamatan</option>
            <option value="kelurahan">Kelurahan</option>
          </select>
          <p class="mt-1 text-sm text-red-600 hidden" id="level_error">Level harus dipilih.</p>
        </div>
        <div>
          <label for="lat" class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
          <input type="number" step="any" name="lat" id="lat" placeholder="Masukkan latitude" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="lat_error">Latitude harus diisi dan valid (contoh: -6.2088).</p>
        </div>
        <div>
          <label for="lng" class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
          <input type="number" step="any" name="lng" id="lng" placeholder="Masukkan longitude" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="lng_error">Longitude harus diisi dan valid (contoh: 106.8456).</p>
        </div>
        <div class="md:col-span-3 flex justify-end">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">Tambah</button>
        </div>
      </form>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Kode</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Level</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Latitude</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Longitude</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (empty($regions)): ?>
              <tr>
                <td colspan="6" class="p-4 text-center text-sm text-gray-500">Tidak ada data wilayah.</td>
              </tr>
            <?php else: ?>
              <?php foreach($regions as $r): ?>
                <tr class="hover:bg-gray-50">
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($r->code) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($r->name) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape(ucfirst($r->level)) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($r->lat) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($r->lng) ?></td>
                  <td class="p-4">
                    <a href="<?= site_url('regions/delete/'.$r->code) ?>" class="text-red-600 hover:text-red-800 font-medium delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus wilayah <?= html_escape($r->name) ?>?')">Hapus</a>
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
document.getElementById('regionForm').addEventListener('submit', function(e) {
  let isValid = true;

  // Reset error messages
  document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

  // Validate fields
  const fields = [
    { id: 'code', errorId: 'code_error', message: 'Kode wilayah harus diisi.' },
    { id: 'name', errorId: 'name_error', message: 'Nama wilayah harus diisi.' },
    { id: 'level', errorId: 'level_error', message: 'Level harus dipilih.' },
    { id: 'lat', errorId: 'lat_error', message: 'Latitude harus diisi dan valid (contoh: -6.2088).', validate: value => value && !isNaN(value) && value >= -90 && value <= 90 },
    { id: 'lng', errorId: 'lng_error', message: 'Longitude harus diisi dan valid (contoh: 106.8456).', validate: value => value && !isNaN(value) && value >= -180 && value <= 180 }
  ];

  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    if (!value || (field.validate && !field.validate(value))) {
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