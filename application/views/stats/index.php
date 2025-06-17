<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<main class="flex-1 overflow-y-auto px-6 py-8 bg-gray-100">
  <!-- HEADER -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-3xl font-semibold text-gray-800">Statistik Kasus</h1>
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
      <select id="diseaseFilter" class="block w-full rounded-md border border-gray-300 shadow-sm p-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        <option value="">— Semua Penyakit —</option>
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
        <option value="">— Semua Provinsi —</option>
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
      <button id="resetBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">Reset Filter</button>
      <button id="applyBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition flex items-center">
        <span>Terapkan Filter</span>
        <svg id="loadingSpinner" class="hidden h-5 w-5 ml-2 animate-spin text-white" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>
      </button>
    </div>
  </div>

  <!-- CHARTS -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Tren Kasus -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Tren Kasus Harian</h2>
      <div class="h-80">
        <canvas id="trendChart" class="w-full h-full"></canvas>
      </div>
    </div>
    <!-- Persentase Kasus -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Persentase Kasus per Penyakit</h2>
      <div class="h-80">
        <canvas id="pieChart" class="w-full h-full"></canvas>
      </div>
    </div>
    <!-- Bar per Wilayah -->
    <div class="bg-white p-6 rounded-xl shadow-lg lg:col-span-2">
      <h2 class="text-lg font-semibold text-gray-800 mb-4">Jumlah Kasus per Wilayah</h2>
      <div class="h-80">
        <canvas id="barChart" class="w-full h-full"></canvas>
      </div>
    </div>
  </div>

  <!-- TABEL RINGKASAN & EXPORT CSV -->
  <div class="bg-white p-6 rounded-xl shadow-lg">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-800">Ringkasan Jumlah Kasus</h2>
      <button id="exportCsv" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition">
        Eksport CSV
      </button>
    </div>
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50 sticky top-0">
          <tr>
            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Wilayah</th>
            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Kasus</th>
          </tr>
        </thead>
        <tbody id="summaryTable" class="bg-white divide-y divide-gray-200"></tbody>
      </table>
    </div>
  </div>
</main>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Data dari controller
  let rawTrend = <?= json_encode($trend) ?>;
  let rawPie = <?= json_encode($pie) ?>;
  let rawBar = <?= json_encode($by_region) ?>;
  let rawSummary = rawBar;

  // Chart instances
  let trendChart, pieChart, barChart;

  // Color palette for charts
  const colors = ['#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899', '#14B8A6'];

  // Function to render charts and table
  function renderCharts(trendData, pieData, barData, summaryData) {
    // Destroy existing charts to prevent canvas overlap
    if (trendChart) trendChart.destroy();
    if (pieChart) pieChart.destroy();
    if (barChart) barChart.destroy();

    // Trend Chart (Line)
    trendChart = new Chart(document.getElementById('trendChart'), {
      type: 'line',
      data: {
        labels: trendData.map(r => r.date),
        datasets: [{
          label: 'Kasus',
          data: trendData.map(r => r.count),
          borderColor: colors[0],
          backgroundColor: colors[0] + '33', // 20% opacity
          fill: true,
          tension: 0.3,
          pointRadius: 4,
          pointHoverRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { title: { display: true, text: 'Tanggal', font: { size: 14 } } },
          y: { title: { display: true, text: 'Jumlah Kasus', font: { size: 14 } }, beginAtZero: true }
        },
        plugins: {
          legend: { display: false },
          tooltip: { backgroundColor: '#1F2937', titleFont: { size: 14 }, bodyFont: { size: 12 } }
        }
      }
    });

    // Pie Chart (Doughnut)
    pieChart = new Chart(document.getElementById('pieChart'), {
      type: 'doughnut',
      data: {
        labels: pieData.map(r => r.label),
        datasets: [{
          data: pieData.map(r => r.value),
          backgroundColor: colors,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { position: 'bottom', labels: { boxWidth: 12, padding: 16, font: { size: 12 } } },
          tooltip: {
            backgroundColor: '#1F2937',
            titleFont: { size: 14 },
            bodyFont: { size: 12 },
            callbacks: {
              label: ctx => {
                const v = ctx.parsed;
                const t = ctx.dataset.data.reduce((a, b) => a + b, 0);
                const pct = t ? ((v / t) * 100).toFixed(1) : 0;
                return `${ctx.label}: ${v} (${pct}%)`;
              }
            }
          }
        }
      }
    });

    // Bar Chart (Region)
    barChart = new Chart(document.getElementById('barChart'), {
      type: 'bar',
      data: {
        labels: barData.map(r => r.region),
        datasets: [{
          label: 'Kasus',
          data: barData.map(r => r.value),
          backgroundColor: colors[0] + '80', // 50% opacity
          borderColor: colors[0],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          x: { title: { display: true, text: 'Wilayah', font: { size: 14 } } },
          y: { title: { display: true, text: 'Jumlah Kasus', font: { size: 14 } }, beginAtZero: true }
        },
        plugins: {
          legend: { display: false },
          tooltip: { backgroundColor: '#1F2937', titleFont: { size: 14 }, bodyFont: { size: 12 } }
        }
      }
    });

    // Summary Table
    const tbody = document.getElementById('summaryTable');
    tbody.innerHTML = '';
    if (summaryData.length === 0) {
      tbody.innerHTML = '<tr><td colspan="2" class="px-4 py-3 text-sm text-gray-500 text-center">Tidak ada data.</td></tr>';
    } else {
      summaryData.forEach(r => {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50';
        tr.innerHTML = `
          <td class="px-4 py-3 text-sm text-gray-700">${r.region}</td>
          <td class="px-4 py-3 text-sm text-gray-700 text-right">${r.value}</td>
        `;
        tbody.appendChild(tr);
      });
    }
  }

  // Initial render
  renderCharts(rawTrend, rawPie, rawBar, rawSummary);

  // Export CSV
  document.getElementById('exportCsv').addEventListener('click', () => {
    let csv = 'Wilayah,Kasus\n';
    rawSummary.forEach(r => csv += `"${r.region}",${r.value}\n`);
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'ringkasan_kasus.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Cascading Provinsi → Kab/Kota
  document.getElementById('provFilter').addEventListener('change', async function() {
    const prov = this.value;
    const city = document.getElementById('cityFilter');
    city.innerHTML = '<option>Memuat…</option>';
    city.disabled = true;
    try {
      const res = await fetch(`<?= site_url('regions/get_cities') ?>/${prov}`);
      const list = await res.json();
      city.innerHTML = '<option value="">— Semua Kab/Kota —</option>';
      list.forEach(r => city.add(new Option(r.name, r.code)));
      city.disabled = false;
    } catch (error) {
      city.innerHTML = '<option>Error memuat data</option>';
    }
  });

  // Client-side Filtering
  document.getElementById('applyBtn').addEventListener('click', () => {
    const spinner = document.getElementById('loadingSpinner');
    spinner.classList.remove('hidden');

    const disease = document.getElementById('diseaseFilter').value;
    const from = document.getElementById('dateFrom').value;
    const to = document.getElementById('dateTo').value;
    const prov = document.getElementById('provFilter').value;
    const city = document.getElementById('cityFilter').value;

    // Filter trend data
    const filteredTrend = rawTrend.filter(r => {
      if (disease && r.disease_code !== disease) return false;
      if (from && r.date < from) return false;
      if (to && r.date > to) return false;
      if (prov && r.region_prov !== prov) return false;
      if (city && r.region_city !== city) return false;
      return true;
    });

    // Filter pie data
    const filteredPie = rawPie.filter(r => {
      if (disease && r.disease_code !== disease) return false;
      if (prov && r.region_prov !== prov) return false;
      if (city && r.region_city !== city) return false;
      return true;
    });

    // Filter bar/summary data
    const filteredBar = rawBar.filter(r => {
      if (prov && r.region_prov !== prov) return false;
      if (city && r.region_city !== city) return false;
      return true;
    });

    // Update charts and table
    renderCharts(filteredTrend, filteredPie, filteredBar, filteredBar);
    spinner.classList.add('hidden');
  });

  // Reset Filter
  document.getElementById('resetBtn').addEventListener('click', () => {
    document.getElementById('diseaseFilter').value = '';
    document.getElementById('dateFrom').value = '';
    document.getElementById('dateTo').value = '';
    document.getElementById('provFilter').value = '';
    const city = document.getElementById('cityFilter');
    city.innerHTML = '<option value="">— Pilih Provinsi Dulu —</option>';
    city.disabled = true;
    renderCharts(rawTrend, rawPie, rawBar, rawSummary);
  });
});
</script>

<style>
  /* Scrollable table */
  #summaryTable { display: block; max-height: 300px; overflow-y: auto; }
  #summaryTable tr { display: table; width: 100%; table-layout: fixed; }
  /* Chart containers */
  canvas { max-width: 100%; }
</style>