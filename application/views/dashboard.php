<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<main class="flex-1 overflow-y-auto px-4 sm:px-6 py-6 bg-gray-100">
  <!-- ANIMATED HEADER -->
  <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 to-blue-800 p-6 mb-6 shadow-lg">
    <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-blue-500 opacity-20"></div>
    <div class="absolute -right-5 -top-5 h-20 w-20 rounded-full bg-blue-400 opacity-30"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
      <div>
        <h2 class="text-3xl font-bold text-white tracking-tight">Pemantauan Penyakit</h2>
        <p class="mt-2 text-blue-100 max-w-2xl">Dasbor analitik dan visualisasi geospasial untuk pemantauan penyakit secara real-time</p>
      </div>
      
      <div class="flex items-center space-x-3">
        <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full border border-white/10">
          <svg class="h-5 w-5 text-blue-100 mr-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span class="text-sm text-white">Terakhir diperbarui: 
            <span class="font-medium"><?= html_escape($last_update) ?></span>
          </span>
        </div>
        
        <button onclick="location.reload()" class="p-2 bg-white/20 hover:bg-white/30 text-white rounded-full transition-all duration-300 hover:rotate-180" title="Refresh">
          <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8 8 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8 8 0 01-15.357-2m15.357 2H15"/>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- ANIMATED STATS CARDS -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <?php foreach ([
      ['label' => 'Kasus Aktif', 'value' => $stats['active_cases'], 'color' => 'blue', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'trend' => 'up'],
      ['label' => 'Sembuh', 'value' => $stats['recovered_cases'], 'color' => 'green', 'icon' => 'M5 13l4 4L19 7', 'trend' => 'up'],
      ['label' => 'Kasus Kritis', 'value' => $stats['critical_cases'], 'color' => 'red', 'icon' => 'M6 18L18 6M6 6l12 12', 'trend' => 'down'],
      ['label' => 'Tingkat Pengujian', 'value' => $stats['tests_conducted'], 'color' => 'purple', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'trend' => 'up']
    ] as $c): ?>
      <div class="group relative p-5 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden">
        <!-- Animated background effect -->
        <div class="absolute inset-0 bg-gradient-to-br from-<?= html_escape($c['color']) ?>-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        <div class="relative z-10">
          <div class="flex justify-between items-start">
            <div>
              <p class="text-xs font-medium text-gray-500 uppercase tracking-wider"><?= html_escape($c['label']) ?></p>
              <div class="flex items-center mt-1">
                <span class="text-3xl font-bold text-gray-900"><?= number_format($c['value']) ?></span>
                <?php if ($c['trend'] === 'up'): ?>
                  <span class="ml-2 px-1.5 py-0.5 rounded-full bg-<?= html_escape($c['color']) ?>-100 text-<?= html_escape($c['color']) ?>-800 text-xs flex items-center">
                    <svg class="w-3 h-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                    +2.5%
                  </span>
                <?php else: ?>
                  <span class="ml-2 px-1.5 py-0.5 rounded-full bg-red-100 text-red-800 text-xs flex items-center">
                    <svg class="w-3 h-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    -1.2%
                  </span>
                <?php endif; ?>
              </div>
            </div>
            
            <div class="p-2 bg-<?= html_escape($c['color']) ?>-50 rounded-lg group-hover:bg-<?= html_escape($c['color']) ?>-100 transition-colors duration-300">
              <svg class="h-6 w-6 text-<?= html_escape($c['color']) ?>-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= html_escape($c['icon']) ?>"/>
              </svg>
            </div>
          </div>
          
          <div class="mt-4">
            <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
              <div class="h-full bg-<?= html_escape($c['color']) ?>-500 rounded-full" style="width: <?= min(100, ($c['value'] / max(1, $stats['tests_conducted']) * 100)) ?>%"></div>
            </div>
            <p class="mt-1 text-xs text-gray-500 flex justify-between">
              <span><?= $c['label'] === 'Tingkat Pengujian' ? 'Total tes dilakukan' : 'Kasus dilaporkan' ?></span>
              <span class="font-medium"><?= number_format($c['value']) ?></span>
            </p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- INTERACTIVE MAP & TABLE -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Enhanced Map Container -->
    <div class="lg:col-span-2 relative group">
      <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-white opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl"></div>
      
      <div class="relative z-10">
        <div class="flex justify-between items-center mb-3">
          <h3 class="text-lg font-semibold text-gray-900">Visualisasi Penyebaran Penyakit</h3>
          <div class="flex space-x-2">
            <button id="heatmap-toggle" class="px-3 py-1 text-xs bg-blue-100 hover:bg-blue-200 text-blue-800 rounded-full transition-colors">
              Tampilan Heatmap
            </button>
            <button id="export-btn" class="px-3 py-1 text-xs bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full transition-colors flex items-center">
              <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
              </svg>
              Ekspor
            </button>
          </div>
        </div>
        
        <div id="map" class="h-96 w-full rounded-2xl border border-gray-200 shadow-sm mb-2"></div>
        <div id="map-error" class="hidden text-center text-sm text-red-600 mb-2">Gagal memuat peta: Tidak ada data lokasi atau kesalahan konfigurasi.</div>
        <div class="text-center text-xs text-gray-500 flex justify-between items-center">
          <span>Terakhir diperbarui: <?= html_escape($last_update) ?></span>
          <div class="flex items-center space-x-2">
            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span> Risiko Rendah</span>
            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-yellow-500 mr-1"></span> Risiko Sedang</span>
            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-red-500 mr-1"></span> Risiko Tinggi</span>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Enhanced Table with Search -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
      <div class="p-4 border

-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-semibold text-gray-900">Data Kasus Wilayah</h3>
        <div class="mt-2 relative">
          <input type="text" placeholder="Cari wilayah..." class="w-full pl-8 pr-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" id="region-search">
          <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>
      
      <div class="overflow-x-auto max-h-96 overflow-y-auto">
        <table class="min-w-full divide-y divide-gray-200" id="region-table">
          <thead class="bg-gray-50 sticky top-0">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wilayah</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktif</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tren</th>
              <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <?php if (empty($locations)): ?>
              <tr>
                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">Tidak ada data wilayah.</td>
              </tr>
            <?php else: ?>
              <?php foreach($locations as $loc): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-4 py-3 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                      </div>
                      <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900"><?= html_escape($loc->name) ?></p>
                        <p class="text-xs text-gray-500"><?= $loc->population ? number_format($loc->population) : 'T/A' ?> populasi</p>
                      </div>
                    </div>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                      <?= $loc->active_cases > 100 ? 'bg-red-100 text-red-800' : ($loc->active_cases > 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') ?>">
                      <?= number_format($loc->active_cases) ?>
                    </span>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap">
                    <?php $trend = rand(0,1) ? 'up' : 'down'; ?>
                    <div class="flex items-center">
                      <?php if($trend === 'up'): ?>
                        <svg class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                        <span class="ml-1 text-xs text-gray-500">+<?= rand(1,10) ?>%</span>
                      <?php else: ?>
                        <svg class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span class="ml-1 text-xs text-gray-500">-<?= rand(1,5) ?>%</span>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                    <a href="<?= site_url('region/details/'.$loc->id) ?>" class="text-blue-600 hover:text-blue-900 transition-colors">Detail →</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>

<!-- Enhanced Map Visualization -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" integrity="sha512-6S+Ok0bVAl9BGmWV7N2j2H5qG3R1T2TKC5Q69eix2kRVRoENoP7E/PU1tBhw/+3W3TJ13xSc+4JSLr5At6uMwoQ==" crossorigin="anonymous"/>
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" integrity="sha512-fRmR7hV1bE6m1g2JLL4iH5qB1+8wb0jO2kB3A2T1oZYZXz2rRPLNN7MmQ4N+PUtTFKRBkMZ+YZXvAzChg1oLzw==" crossorigin="anonymous"/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js" integrity="sha512-OFs3WJD4O3DIyRG6we4kT6MUhO2o9TjdC2XiW7Q2A0o/6vZYe5v7Ex+2pK0ha7c+2iG+2G2c2TfMxtQ/V8ylgA==" crossorigin="anonymous"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Initialize map with explicit size
  const mapContainer = document.getElementById('map');
  mapContainer.style.height = '384px'; // Ensure height is set (equivalent to h-96)
  mapContainer.style.width = '100%';

  const map = L.map('map', {
    zoomControl: false,
    attributionControl: true
  }).setView([-2.548926, 118.0148634], 5);

  // Add modern map tiles
  L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
    maxZoom: 19,
    subdomains: 'abcd',
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
  }).addTo(map);

  // Add zoom control
  L.control.zoom({ position: 'topright' }).addTo(map);

  // Handle locations data
  const locs = <?= json_encode(array_map(function($l) {
    return [
      'id' => $l->id,
      'lat' => floatval($l->lat),
      'lng' => floatval($l->lng),
      'name' => $l->name,
      'active' => $l->active_cases,
      'risk' => $l->active_cases > 100 ? 'high' : ($l->active_cases > 50 ? 'medium' : 'low')
    ];
  }, $locations)) ?>;

  const errorDiv = document.getElementById('map-error');

  if (!locs || locs.length === 0) {
    errorDiv.classList.remove('hidden');
    console.warn('No location data available for the map.');
    return;
  }

  // Validate location data
  const validLocs = locs.filter(loc => {
    if (!loc.lat || !loc.lng || isNaN(loc.lat) || isNaN(loc.lng)) {
      console.warn(`Invalid coordinates for location: ${loc.name} (lat: ${loc.lat}, lng: ${loc.lng})`);
      return false;
    }
    return true;
  });

  if (validLocs.length === 0) {
    errorDiv.classList.remove('hidden');
    console.warn('No valid coordinates found in location data.');
    return;
  }

  // Create heatmap data
  const heatData = validLocs.map(loc => {
    const intensity = loc.active / 100; // Adjust based on data scale
    return [loc.lat, loc.lng, Math.min(intensity, 1)];
  });

  const heatLayer = L.heatLayer(heatData, {
    radius: 25,
    blur: 15,
    maxZoom: 17,
    max: 1.0,
    gradient: { 0.4: 'blue', 0.6: 'lime', 0.8: 'yellow', 1.0: 'red' }
  });

  // Create clustered markers with custom icons
  const markers = L.markerClusterGroup({
    iconCreateFunction: function(cluster) {
      const childCount = cluster.getChildCount();
      let size = childCount > 20 ? 'large' : childCount > 10 ? 'medium' : 'small';
      return L.divIcon({
        html: `<div class="cluster-marker ${size}">${childCount}</div>`,
        className: 'marker-cluster-custom',
        iconSize: L.point(40, 40, true)
      });
    },
    spiderfyOnMaxZoom: true,
    showCoverageOnHover: false,
    zoomToBoundsOnClick: true
  });

  // Add markers with risk-based styling
  validLocs.forEach(loc => {
    let iconColor = loc.risk === 'high' ? 'red' : loc.risk === 'medium' ? 'orange' : 'green';
    const marker = L.marker([loc.lat, loc.lng], {
      icon: L.divIcon({
        html: `<div class="custom-marker ${iconColor}">${loc.active}</div>`,
        className: '',
        iconSize: [30, 30]
      })
    }).bindPopup(`
      <div class="p-3">
        <h4 class="font-bold text-lg">${htmlEscape(loc.name)}</h4>
        <div class="mt-2 grid grid-cols-2 gap-2">
          <div class="text-sm"><span class="font-medium">Kasus Aktif:</span> ${loc.active}</div>
          <div class="text-sm"><span class="font-medium">Risiko:</span> <span class="capitalize">${loc.risk}</span></div>
        </div>
        <a href="<?= site_url('region/details/') ?>${loc.id}" class="mt-2 inline-block text-sm text-blue-600 hover:underline">Lihat detail</a>
      </div>
    `);
    markers.addLayer(marker);
  });

  // Add markers by default
  map.addLayer(markers);
  map.fitBounds(markers.getBounds().pad(0.2));

  // Toggle between heatmap and markers
  const heatmapToggle = document.getElementById('heatmap-toggle');
  let heatmapActive = false;

  heatmapToggle.addEventListener('click', () => {
    if (heatmapActive) {
      map.removeLayer(heatLayer);
      map.addLayer(markers);
      heatmapToggle.textContent = 'Tampilan Heatmap';
    } else {
      map.removeLayer(markers);
      map.addLayer(heatLayer);
      heatmapToggle.textContent = 'Tampilan Cluster';
    }
    heatmapActive = !heatmapActive;
  });

  // Export functionality
  document.getElementById('export-btn').addEventListener('click', () => {
    let csv = 'Wilayah,Kasus Aktif,Risiko\n';
    validLocs.forEach(loc => {
      csv += `"${loc.name}",${loc.active},${loc.risk}\n`;
    });
    const blob = new Blob([csv], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'data_kasus_wilayah.csv';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
  });

  // Search functionality for table
  const searchInput = document.getElementById('region-search');
  searchInput.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#region-table tbody tr');
    rows.forEach(row => {
      const regionName = row.querySelector('td:first-child p:first-child').textContent.toLowerCase();
      row.style.display = regionName.includes(term) ? '' : 'none';
    });
  });

  // Animation on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-fadeInUp');
      }
    });
  }, { threshold: 0.1 });

  document.querySelectorAll('.grid > div').forEach(el => observer.observe(el));

  // JavaScript-based HTML escape function
  function htmlEscape(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
});
</script>

<style>
/* Custom marker clusters */
.marker-cluster-custom {
  background-color: rgba(37, 99, 235, 0.2);
  border-radius: 50%;
  text-align: center;
  font-weight: bold;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
}
.marker-cluster-custom.small { width: 40px !important; height: 40px !important; font-size: 12px; background-color: rgba(37, 99, 235, 0.4); }
.marker-cluster-custom.medium { width: 50px !important; height: 50px !important; font-size: 14px; background-color: rgba(37, 99, 235, 0.6); }
.marker-cluster-custom.large { width: 60px !important; height: 60px !important; font-size: 16px; background-color: rgba(37, 99, 235, 0.8); }

/* Custom markers */
.custom-marker {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: white;
  border: 2px solid;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 12px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
.custom-marker.red { border-color: #ef4444; color: #ef4444; }
.custom-marker.orange { border-color: #f59e0b; color: #f59e0b; }
.custom-marker.green { border-color: #10b981; color: #10b981; }

/* Animations */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeInUp { animation: fadeInUp 0.6s ease-out forwards; }

/* Map styling */
#map { min-height: 384px; transition: box-shadow 0.3s ease; }
#map:hover { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); }
</style>

<?php $this->load->view('templates/footer'); ?>