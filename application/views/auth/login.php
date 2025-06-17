<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
<link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/png">
  <title>Login GeoSehat</title>
  <style>
    body { font-family: Arial, Helvetica, sans-serif; }
  </style>
</head>
<body class="bg-gray-50">
  <div class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden w-full max-w-4xl">
      <div class="md:flex">
        <!-- Bagian Kiri: Form Login -->
        <div class="w-full md:w-1/2 p-8">
          <!-- Back to Homepage -->
          <a href="<?= base_url() ?>"
             class="inline-flex items-center text-teal-600 hover:underline mb-6">
            <!-- Arrow Icon (inline SVG) -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7" />
            </svg>
            <span class="ml-2 font-semibold">BACK TO HOMEPAGE</span>
          </a>

          <!-- Logo di Tengah -->
          <div class="flex justify-center mb-6">
            <a href="<?= base_url() ?>">
              <img src="<?= base_url('assets/images/logo.png') ?>"
                   alt="GeoSehat Logo"
                   class="h-16 w-auto">
            </a>
          </div>

          <!-- Tab Login / Register -->
          <div class="flex justify-center mb-6">
            <!-- Tab Login (active dengan gradasi biru‐hijau) -->
            <a href="<?= site_url('login') ?>"
               class="px-6 py-2 bg-gradient-to-r from-teal-400 to-green-400 text-white font-medium rounded-l-lg border border-transparent">
              Login
            </a>
            <!-- Tab Register -->
            <a href="<?= site_url('register') ?>"
               class="px-6 py-2 bg-white text-teal-600 font-medium rounded-r-lg border border-teal-200 hover:bg-teal-50">
              Register
            </a>
          </div>

          <!-- Form Login -->
          <?= form_open('login/submit', ['id' => 'loginForm']) ?>
            <!-- Email -->
            <div class="mb-4">
              <label for="email" class="block text-sm font-medium text-gray-700">
                Email
              </label>
              <input
                type="email"
                id="email"
                name="email"
                value="<?= set_value('email') ?>"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 
                       focus:outline-none focus:ring-teal-500 focus:border-teal-500"
                placeholder="Input Email"
                required
              >
              <?= form_error('email','<small class="text-red-600">','</small>') ?>
            </div>

            <!-- Password dengan ikon show/hide -->
            <div class="mb-4 relative">
              <label for="password" class="block text-sm font-medium text-gray-700">
                Password
              </label>
              <input
                type="password"
                id="password"
                name="password"
                class="mt-1 block w-full border border-gray-300 rounded px-3 py-2 
                       focus:outline-none focus:ring-teal-500 focus:border-teal-500 pr-10"
                placeholder="Input Password"
                required
              >
              <?= form_error('password','<small class="text-red-600">','</small>') ?>
              <!-- Ikon mata (tampilan saja) -->
              <div class="absolute inset-y-1.5 right-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-gray-400 cursor-pointer"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 
                             8.268 2.943 9.542 7-1.274 4.057-5.064 
                             7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
            </div>

            <!-- Forgot Password -->
            <div class="flex justify-end mb-4">
              <a href="<?= site_url('forgot-password') ?>"
                 class="text-sm text-teal-600 font-semibold hover:underline">
                FORGOT PASSWORD?
              </a>
            </div>

            <!-- Checkbox Terms & Conditions -->
            <div class="flex items-center mb-6">
              <input
                type="checkbox"
                id="agree"
                name="agree"
                class="h-4 w-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500"
                onchange="document.getElementById('loginButton').disabled = !this.checked"
              >
              <label for="agree" class="ml-2 block text-sm text-gray-700">
                I have read and agree with the
                <a href="<?= base_url('terms') ?>"
                   class="text-teal-600 hover:underline">Terms & Conditions</a>
                and
                <a href="<?= base_url('privacy') ?>"
                   class="text-teal-600 hover:underline">Privacy Policy</a>.
              </label>
            </div>

            <!-- Tombol Login (disabled sampai checkbox dicentang) -->
            <button
              type="submit"
              id="loginButton"
              disabled
              class="w-full bg-gradient-to-r from-teal-500 to-green-500 text-white font-medium py-2 rounded-lg
                     disabled:opacity-50 hover:disabled:bg-teal-500 transition"
            >
              LOGIN
            </button>
          <?= form_close() ?>

          <!-- Tombol Help di Bawah -->
          <div class="mt-8 text-center">
            <button
              onclick="window.location.href='<?= base_url('help') ?>'"
              class="px-6 py-2 border-2 border-teal-600 text-teal-600 font-medium rounded-lg hover:bg-teal-50 transition"
            >
              DO YOU NEED HELP?
            </button>
          </div>
        </div>

        <!-- Bagian Kanan: Ilustrasi (hanya tampil di layar md ke atas) -->
        <div class="hidden md:block md:w-1/2">
          <img
            src="<?= base_url('assets/images/ilustrasilogin.png') ?>"
            alt="Ilustrasi Login"
            class="h-full w-full object-cover"
          >
        </div>
      </div>
    </div>
  </div>
</body>
</html>
