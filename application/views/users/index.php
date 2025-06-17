<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('templates/header'); ?>

<div class="min-h-screen flex bg-gray-100">
  <main class="flex-1 max-w-5xl mx-auto p-6 md:p-8">
    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8">
      <h2 class="text-3xl font-semibold text-gray-800 mb-6">Kelola Pengguna</h2>

      <!-- Validation Errors -->
      <?php if (validation_errors()): ?>
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
          <?php echo validation_errors(); ?>
        </div>
      <?php endif; ?>

      <!-- Form -->
      <form action="<?= site_url('users/store') ?>" method="post" id="userForm" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
          <input type="text" name="username" id="username" placeholder="Masukkan username" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="username_error">Username harus diisi (3-20 karakter, huruf, angka, atau underscore).</p>
        </div>
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" id="email" placeholder="Masukkan email" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="email_error">Email harus diisi dan valid (contoh: user@domain.com).</p>
        </div>
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input type="password" name="password" id="password" placeholder="Masukkan password" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <p class="mt-1 text-sm text-red-600 hidden" id="password_error">Password harus diisi (minimal 6 karakter).</p>
        </div>
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
          <select name="role" id="role" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <option value="pic">PIC</option>
            <option value="admin_lokal">Admin Lokal</option>
            <option value="admin_provinsi">Admin Provinsi</option>
            <option value="superadmin">Superadmin</option>
          </select>
          <p class="mt-1 text-sm text-red-600 hidden" id="role_error">Role harus dipilih.</p>
        </div>
        <div class="md:col-span-4 flex justify-end">
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">Tambah Pengguna</button>
        </div>
      </form>

      <!-- Table -->
      <div class="bg-white rounded-xl shadow-lg overflow-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
              <th class="p-4 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if (empty($users)): ?>
              <tr>
                <td colspan="5" class="p-4 text-center text-sm text-gray-500">Tidak ada data pengguna.</td>
              </tr>
            <?php else: ?>
              <?php foreach($users as $u): ?>
                <tr class="hover:bg-gray-50">
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($u->id) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape($u->username) ?></td>
                  <td class="p-4 text-sm text-sm text-gray-700"><?= html_escape($u->email) ?></td>
                  <td class="p-4 text-sm text-gray-700"><?= html_escape(ucfirst(str_replace('_', ' ', $u->role))) ?></td>
                  <td class="p-4">
                    <a href="<?= site_url('users/delete/'.$u->id) ?>" class="text-red-600 hover:text-red-800 font-medium delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna <?= html_escape($u->username) ?>?')">Hapus</a>
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
document.getElementById('userForm').addEventListener('submit', function(e) {
  let isValid = true;

  // Reset error messages
  document.querySelectorAll('.text-red-600').forEach(el => el.classList.add('hidden'));

  // Validate fields
  const fields = [
    { id: 'username', errorId: 'username_error', message: 'Username harus diisi (3-20 karakter, huruf, angka, atau underscore).', validate: value => value && /^[a-zA-Z0-9_]{3,20}$/.test(value) },
    { id: 'email', errorId: 'email_error', message: 'Email harus diisi dan valid (contoh: user@domain.com).', validate: value => value && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) },
    { id: 'password', errorId: 'password_error', message: 'Password harus diisi (minimal 6 karakter).', validate: value => value && value.length >= 6 },
    { id: 'role', errorId: 'role_error', message: 'Role harus dipilih.', validate: value => value }
  ];

  fields.forEach(field => {
    const input = document.getElementById(field.id);
    const value = input.value.trim();
    if (!field.validate(value)) {
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