<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php date_default_timezone_set('Asia/Jakarta'); $last_update = date('Y-m-d H:i:s'); ?>
<?php $this->load->view('templates/header', ['last_update' => $last_update]); ?>

<div class="min-h-screen bg-gray-100 flex">
  <main class="flex-1 max-w-4xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Input Data Kasus</h2>
      
      <!-- Validation Errors -->
      <?php if (validation_errors()): ?>
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif; ?>

      <form action="<?= site_url('cases/store') ?>" method="post" id="caseForm" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Region -->
          <div>
            <label for="region_code" class="block text-sm font-medium text-gray-700">Region</label>
            <select name="region_code" id="region_code" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">-- Pilih Region --</option>
              <?php foreach($regions as $r): ?>
                <option value="<?= $r->code ?>"><?= $r->name ?></option>
              <?php endforeach; ?>
            </select>
            <p class="mt-1 text-sm text-red-600 hidden" id="region_code_error">Region harus dipilih.</p>
          </div>

          <!-- Disease -->
          <div>
            <label for="disease_code" class="block text-sm font-medium text-gray-700">Penyakit</label>
            <select name="disease_code" id="disease_code" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">-- Pilih Penyakit --</option>
              <?php foreach($diseases as $d): ?>
                <option value="<?= $d->code ?>"><?= $d->name ?></option>
              <?php endforeach; ?>
            </select>
            <p class="mt-1 text-sm text-red-600 hidden" id="disease_code_error">Penyakit harus dipilih.</p>
          </div>

          <!-- Date Report -->
          <div>
            <label for="date_report" class="block text-sm font-medium text-gray-700">Tanggal Laporan</label>
            <input type="date" name="date_report" id="date_report" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-sm text-red-600 hidden" id="date_report_error">Tanggal laporan harus diisi.</p>
          </div>

          <!-- Confirmed -->
          <div>
            <label for="confirmed" class="block text-sm font-medium text-gray-700">Terkonfirmasi</label>
            <input type="number" name="confirmed" id="confirmed" min="0" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-sm text-red-600 hidden" id="confirmed_error">Jumlah terkonfirmasi harus diisi dan tidak boleh negatif.</p>
          </div>

          <!-- Suspected -->
          <div>
            <label for="suspected" class="block text-sm font-medium text-gray-700">Diduga</label>
            <input type="number" name="suspected" id="suspected" min="0" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-sm text-red-600 hidden" id="suspected_error">Jumlah diduga harus diisi dan tidak boleh negatif.</p>
          </div>

          <!-- Recovered -->
          <div>
            <label for="recovered" class="block text-sm font-medium text-gray-700">Sembuh</label>
            <input type="number" name="recovered" id="recovered" min="0" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-sm text-red-600 hidden" id="recovered_error">Jumlah sembuh harus diisi dan tidak boleh negatif.</p>
          </div>

          <!-- Deaths -->
          <div>
            <label for="deaths" class="block text-sm font-medium text-gray-700">Meninggal</label>
            <input type="number" name="deaths" id="deaths" min="0" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
            <p class="mt-1 text-sm text-red-600 hidden" id="deaths_error">Jumlah meninggal harus diisi dan tidak boleh negatif.</p>
          </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
          <a href="<?= site_url('cases') ?>" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Batal</a>
          <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Simpan</button>
        </div>
      </form>
    </div>
  </main>
</div>

<!-- JavaScript for Client-Side Validation -->
<script>
document.getElementById('caseForm').addEventListener('submit', function(e) {
  let isValid = true;
  
  // Reset error messages
  document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

  // Validate fields
  const fields = [
    { id: 'region_code', errorId: 'region_code_error', message: 'Region harus dipilih.' },
    { id: 'disease_code', errorId: 'disease_code_error', message: 'Penyakit harus dipilih.' },
    { id: 'date_report', errorId: 'date_report_error', message: 'Tanggal laporan harus diisi.' },
    { id: 'confirmed', errorId: 'confirmed_error', message: 'Jumlah terkonfirmasi harus diisi dan tidak boleh negatif.' },
    { id: 'suspected', errorId: 'suspected_error', message: 'Jumlah diduga harus diisi dan tidak boleh negatif.' },
    { id: 'recovered', errorId: 'recovered_error', message: 'Jumlah sembuh harus diisi dan tidak boleh negatif.' },
    { id: 'deaths', errorId: 'deaths_error', message: 'Jumlah meninggal harus diisi dan tidak boleh negatif.' }
  ];

  fields.forEach(field => {
    const input = document.getElementById(field.id);
    if (!input.value || (input.type === 'number' && input.value < 0)) {
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