<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<main class="flex-1 overflow-y-auto px-6 py-8">
  <!-- Header -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Notifikasi</h1>
    <a href="<?= site_url('dashboard') ?>"
       class="inline-flex items-center text-gray-600 hover:text-gray-800">
      <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M15 19l-7-7 7-7" />
      </svg>
      Kembali ke Dashboard
    </a>
  </div>

  <!-- Flash message -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
      <?= $this->session->flashdata('success') ?>
    </div>
  <?php endif; ?>

  <!-- Form -->
  <div class="bg-white p-6 rounded-lg shadow-sm">
    <?= form_open('settings/save_notifications', ['class'=>'space-y-6']) ?>

      <div class="flex items-center">
        <input type="checkbox" name="email" id="email"
               value="1"
               <?= set_value('email', $prefs['email']) ? 'checked' : '' ?>
               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
        <label for="email" class="ml-3 block text-sm font-medium text-gray-700">
          Email Notifications
        </label>
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="sms" id="sms"
               value="1"
               <?= set_value('sms', $prefs['sms']) ? 'checked' : '' ?>
               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
        <label for="sms" class="ml-3 block text-sm font-medium text-gray-700">
          SMS Notifications
        </label>
      </div>

      <div class="flex items-center">
        <input type="checkbox" name="browser" id="browser"
               value="1"
               <?= set_value('browser', $prefs['browser']) ? 'checked' : '' ?>
               class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
        <label for="browser" class="ml-3 block text-sm font-medium text-gray-700">
          Browser Push Notifications
        </label>
      </div>

      <!-- Error messages (jika ada) -->
      <?php if (validation_errors()): ?>
        <div class="text-red-600 text-sm">
          <?= validation_errors('<p>','</p>') ?>
        </div>
      <?php endif; ?>

      <div class="pt-4">
        <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
          Simpan
        </button>
        <a href="<?= site_url('dashboard') ?>"
           class="ml-4 px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
          Batal
        </a>
      </div>

    <?= form_close() ?>
  </div>
</main>
