<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php date_default_timezone_set('Asia/Jakarta'); $last_update = date('Y-m-d H:i:s'); ?>
<?php $this->load->view('templates/header', ['last_update' => $last_update]); ?>

<main class="flex-1 overflow-y-auto px-6 py-8 bg-gray-100">
  <!-- HEADER -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-semibold text-gray-800">Peta Kasus</h1>
    <a href="<?= site_url('dashboard') ?>" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali ke Dashboard
    </a>
  </div>

  <!-- FILTER BAR -->
  <div class="bg-white p-6 rounded-xl shadow-lg mb-6 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
    <!-- Jenis Penyakit -->
    <div>
      <label for="diseaseFilter" class="block text-sm font-medium text-gray-700 mb-2">Jenis Penyakit</label>
      <select id="diseaseFilter" multiple class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <?php foreach($diseases as $d): ?>
          <option value="<?= html_escape($d->code) ?>"><?= html_escape($d->name) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Tanggal Dari -->
    <div>
      <label for="dateFrom" class="block text-sm font-medium text-gray-700 mb-2">Dari</label>
      <input type="date" id="dateFrom" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
    </div>

    <!-- Tanggal Sampai -->
    <div>
      <label for="dateTo" class="block text-sm font-medium text-gray-700 mb-2">Sampai</label>
      <input type="date" id="dateTo" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" />
    </div>

    <!-- Provinsi -->
    <div>
      <label for="provFilter" class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
      <select id="provFilter" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">— Pilih Provinsi —</option>
        <?php foreach($provinces as $p): ?>
          <option value="<?= html_escape($p->code) ?>"><?= html_escape($p->name) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Kab/Kota -->
    <div>
      <label for="cityFilter" class="block text-sm font-medium text-gray-700 mb-2">Kab/Kota</label>
      <select id="cityFilter" disabled class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">— Pilih Provinsi Dulu —</option>
      </select>
    </div>

    <!-- Tombol Filter -->
    <div class="col-span-full flex justify-end space-x-3">
      <button id="resetFilterBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">Reset</button>
      <button id="applyFilterBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition flex items-center">
        <span>Terapkan</span>
        <svg id="loadingSpinner" class="hidden h-5 w-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- MAP & SIDEBAR LIST -->
  <div class="flex space-x-6">
    <!-- MAP -->
    <div class="flex-1 relative bg-white rounded-xl shadow-lg overflow-hidden">
      <div id="map" style="height: 600px;"></div>
      <div class="absolute bottom-4 right-4 bg-white bg-opacity-90 text-xs text-gray-600 px-3 py-1 rounded-md shadow">
        Last update: <?= $last_update ?>
      </div>
    </div>

    <!-- LIST SIDEBAR -->
    <div x-data="{ open: true }" class="w-96">
      <button @click="open = !open" class="mb-3 px-4 py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition w-full flex justify-between items-center">
        <span x-text="open ? 'Tutup Daftar' : 'Buka Daftar'"></span>
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" x-bind:d="open ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7'" />
        </svg>
      </button>
      <div x-show="open" x-transition class="bg-white rounded-xl shadow-lg p-6 overflow-y-auto" style="max-height: 600px;">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Kasus</h2>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pasien</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Penyakit</th>
              <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tgl</th>
            </tr>
          </thead>
          <tbody id="caseList" class="bg-white divide-y divide-gray-200">
            <!-- diisi JS -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- LEAFLET & MARKERCLUSTER -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<!-- Alpine.js for sidebar toggle -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Initialize map
  const map = L.map('map').setView([-2.548926, 118.0148634], 5);
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap contributors © CARTO'
  }).addTo(map);

  // Initialize marker cluster
  const markers = L.markerClusterGroup({
    maxClusterRadius: 40,
    iconCreateFunction: cluster => {
      return L.divIcon({
        html: `<div class="bg-indigo-600 text-white rounded-full h-8 w-8 flex items-center justify-center">${cluster.getChildCount()}</div>`,
        className: 'custom-cluster',
        iconSize: L.point(40, 40)
      });
    }
  });

  let raw = <?= json_encode($cases) ?>;

  function render(data) {
    markers.clearLayers();
    document.getElementById('caseList').innerHTML = '';
    if (data.length === 0) {
      document.getElementById('caseList').innerHTML = '<tr><td colspan="3" class="px-3 py-2 text-sm text-gray-500 text-center">Tidak ada data kasus.</td></tr>';
      return;
    }

    data.forEach(c => {
      // Marker & popup
      const m = L.marker([c.lat, c.lng]).bindPopup(`
        <div class="p-2">
          <strong class="text-lg">${c.patient_name}</strong><br>
          Penyakit: ${c.disease_name}<br>
          Tgl: ${c.date_report}<br>
          Faskes: ${c.facility_name}<br>
          <em>${c.notes || ''}</em><br>
          <a href="<?= site_url('cases/history') ?>/${c.id}" class="text-indigo-600 hover:underline">Riwayat</a>
        </div>
      `);
      markers.addLayer(m);

      // Table row
      const tr = document.createElement('tr');
      tr.className = 'hover:bg-gray-50 cursor-pointer';
      tr.innerHTML = `
        <td class="px-3 py-2 text-sm text-gray-700">${c.patient_name}</td>
        <td class="px-3 py-2 text-sm text-gray-700">${c.disease_name}</td>
        <td class="px-3 py-2 text-sm text-gray-700">${c.date_report}</td>
      `;
      tr.onclick = () => map.setView([c.lat, c.lng], 12);
      document.getElementById('caseList').appendChild(tr);
    });
  }

  map.addLayer(markers);
  render(raw);
  if (markers.getLayers().length) map.fitBounds(markers.getBounds().pad(0.2));

  // Cascading Provinsi → Kab/Kota
  document.getElementById('provFilter').onchange = async function() {
    const prov = this.value;
    const city = document.getElementById('cityFilter');
    city.innerHTML = '<option>Memuat…</option>';
    city.disabled = true;
    try {
      const res = await fetch(`<?= site_url('regions/get_cities') ?>/${prov}`);
      const list = await res.json();
      city.innerHTML = '<option value="">— Pilih Kab/Kota —</option>';
      list.forEach(r => city.add(new Option(r.name, r.code)));
      city.disabled = false;
    } catch (error) {
      city.innerHTML = '<option>Error memuat data</option>';
    }
  };

  // Apply Filter
  document.getElementById('applyFilterBtn').onclick = async () => {
    const spinner = document.getElementById('loadingSpinner');
    spinner.classList.remove('hidden');
    
    const selD = Array.from(document.getElementById('diseaseFilter').selectedOptions).map(o => o.value);
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    const prov = document.getElementById('provFilter').value;
    const city = document.getElementById('cityFilter').value;

    const filt = raw.filter(c => {
      if (selD.length && !selD.includes(c.disease_code)) return false;
      if (from && c.date_report < from) return false;
      if (to && c.date_report > to) return false;
      if (prov && c.region_prov !== prov) return false;
      if (city && c.region_city !== city) return false;
      return true;
    });

    render(filt);
    if (markers.getLayers().length) map.fitBounds(markers.getBounds().pad(0.2));
    spinner.classList.add('hidden');
  };

  // Reset Filter
  document.getElementById('resetFilterBtn').onclick = () => {
    document.getElementById('diseaseFilter').selectedIndex = -1;
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('provFilter').value = '';
    document.getElementById('cityFilter').innerHTML = '<option>— Pilih Provinsi Dulu —</option>';
    document.getElementById('cityFilter').disabled = true;
    render(raw);
    if (markers.getLayers().length) map.fitBounds(markers.getBounds().pad(0.2));
  };
});
</script>

<style>
  /* Custom cluster styling */
  .custom-cluster { background: transparent; }
  .custom-cluster div { font-weight: bold; }
  /* Ensure scrollable table */
  #caseList { display: block; max-height: 500px; overflow-y: auto; }
  #caseList tr { display: table; width: 100%; table-layout: fixed; }
  /* Map container */
  #map { height: 100%; width: 100%; }
</style>
