<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Zona Risiko</title>
    <!-- Tailwind CSS (you can use CDN or your local build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map { 
            height: 384px; /* matches h-96 */
            width: 100%;
            z-index: 1;
        }
        
        .leaflet-control-attribution {
            font-size: 9px;
        }
        
        .risk-marker {
            border-radius: 50%;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        
        /* Custom popup styling */
        .leaflet-popup-content {
            margin: 8px 12px;
        }
        
        .leaflet-popup-content-wrapper {
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-xl rounded-xl p-6 font-sans">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-blue-800">Dashboard Zona Risiko</h2>
                    <p class="text-gray-500">Monitoring real-time penyebaran kasus per wilayah</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Welcome back,</span>
                    <span class="font-semibold text-blue-700">Admin</span>
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Risk Zone Indicators -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-xl border border-green-200 transition-all hover:shadow-md hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                        <span class="text-sm font-medium text-gray-700">Green Zone</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">IR &lt; 1.0</p>
                    <div class="mt-2 text-right">
                        <span class="text-2xl font-bold text-green-600">Safe</span>
                    </div>
                </div>
                
                <div class="p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl border border-yellow-200 transition-all hover:shadow-md hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                        <span class="text-sm font-medium text-gray-700">Yellow Zone</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">IR &lt; 5.0</p>
                    <div class="mt-2 text-right">
                        <span class="text-2xl font-bold text-yellow-600">Warning</span>
                    </div>
                </div>
                
                <div class="p-4 bg-gradient-to-br from-red-50 to-red-100 rounded-xl border border-red-200 transition-all hover:shadow-md hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-red-500 mr-2"></div>
                        <span class="text-sm font-medium text-gray-700">Red Zone</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">IR &lt; 10.0</p>
                    <div class="mt-2 text-right">
                        <span class="text-2xl font-bold text-red-600">Danger</span>
                    </div>
                </div>
                
                <div class="p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl border border-gray-200 transition-all hover:shadow-md hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-gray-800 mr-2"></div>
                        <span class="text-sm font-medium text-gray-700">Black Zone</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">IR ≥ 10.0</p>
                    <div class="mt-2 text-right">
                        <span class="text-2xl font-bold text-gray-800">Critical</span>
                    </div>
                </div>
            </div>

            <!-- Interactive Map Section -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Peta Sebaran Kasus</h3>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export
                        </button>
                        <button class="px-3 py-1 text-xs bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                            Options
                        </button>
                    </div>
                </div>
                <div id="map" class="border rounded-xl h-96 bg-gray-50"></div>
                <div class="mt-2 flex justify-between text-xs text-gray-500">
                    <span>Last updated: <?= date('d M Y H:i') ?></span>
                    <span>Zoom: <span id="zoom-level">-</span></span>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Today's Cases -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Kasus Hari Ini</p>
                            <h3 class="mt-1 text-3xl font-bold text-blue-800">24</h3>
                        </div>
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">vs yesterday</span>
                            <span class="font-medium text-green-600">+2.5%</span>
                        </div>
                    </div>
                </div>
                
                <!-- Red Zones -->
                <div class="bg-white border border-gray-200 rounded-xl p-5 hover:shadow-lg transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Zona Merah Saat Ini</p>
                            <h3 class="mt-1 text-3xl font-bold text-red-600">5</h3>
                        </div>
                        <div class="p-2 bg-red-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between text-xs">
                            <span class="text-gray-500">vs last week</span>
                            <span class="font-medium text-red-600">+2</span>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl p-5">
                    <p class="text-sm font-medium text-blue-700">Quick Actions</p>
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <button class="p-2 bg-white rounded-lg text-blue-600 text-xs font-medium hover:bg-blue-50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Add Case
                        </button>
                        <button class="p-2 bg-white rounded-lg text-blue-600 text-xs font-medium hover:bg-blue-50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Report
                        </button>
                        <button class="p-2 bg-white rounded-lg text-blue-600 text-xs font-medium hover:bg-blue-50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </button>
                        <button class="p-2 bg-white rounded-lg text-blue-600 text-xs font-medium hover:bg-blue-50 transition-colors flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Timeline
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    
    <!-- Leaflet Heatmap Plugin (optional) -->
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    
    <script>
        // Sample data - replace with your actual data from backend
        const regionsData = [
            {
                name: "Jakarta Pusat",
                code: "JKT-PST",
                coordinates: [-6.1862, 106.8346],
                population: 1000000,
                confirmed: 1250,
                incidenceRate: 1.25,
                riskLevel: "yellow",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Jakarta Selatan",
                code: "JKT-SEL",
                coordinates: [-6.2615, 106.8106],
                population: 1500000,
                confirmed: 8500,
                incidenceRate: 5.67,
                riskLevel: "red",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Jakarta Barat",
                code: "JKT-BAR",
                coordinates: [-6.1676, 106.7673],
                population: 1200000,
                confirmed: 480,
                incidenceRate: 0.4,
                riskLevel: "green",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Jakarta Timur",
                code: "JKT-TIM",
                coordinates: [-6.2250, 106.9004],
                population: 1800000,
                confirmed: 21000,
                incidenceRate: 11.67,
                riskLevel: "black",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Jakarta Utara",
                code: "JKT-UT",
                coordinates: [-6.1389, 106.8623],
                population: 900000,
                confirmed: 7200,
                incidenceRate: 8.0,
                riskLevel: "red",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Bogor",
                code: "BGR",
                coordinates: [-6.5971, 106.8060],
                population: 1100000,
                confirmed: 3300,
                incidenceRate: 3.0,
                riskLevel: "yellow",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Depok",
                code: "DPK",
                coordinates: [-6.4025, 106.7942],
                population: 950000,
                confirmed: 1900,
                incidenceRate: 2.0,
                riskLevel: "yellow",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Tangerang",
                code: "TGR",
                coordinates: [-6.1783, 106.6319],
                population: 1300000,
                confirmed: 6500,
                incidenceRate: 5.0,
                riskLevel: "red",
                lastUpdated: "15 Jun 2023"
            },
            {
                name: "Bekasi",
                code: "BKS",
                coordinates: [-6.2383, 106.9756],
                population: 1400000,
                confirmed: 4200,
                incidenceRate: 3.0,
                riskLevel: "yellow",
                lastUpdated: "15 Jun 2023"
            }
        ];

        // Initialize the map when the DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Create the map centered on Indonesia
            const map = L.map('map').setView([-6.1754, 106.8272], 9);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18,
            }).addTo(map);
            
            // Update zoom level display
            map.on('zoomend', function() {
                document.getElementById('zoom-level').textContent = map.getZoom();
            });
            
            // Initial zoom level
            document.getElementById('zoom-level').textContent = map.getZoom();
            
            // Define colors for each risk level
            const riskColors = {
                green: '#10B981',
                yellow: '#F59E0B',
                red: '#EF4444',
                black: '#1F2937'
            };
            
            // Define marker sizes based on case count
            function getMarkerSize(confirmed) {
                if (confirmed === 0) return 0;
                return Math.min(Math.max(Math.log(confirmed + 1) * 8, 40);
            }
            
            // Create a feature group to hold our markers
            const markers = L.featureGroup().addTo(map);
            
            // Add markers for each region
            regionsData.forEach(region => {
                if (region.coordinates[0] === 0 && region.coordinates[1] === 0) return;
                
                const size = getMarkerSize(region.confirmed);
                if (size === 0) return;
                
                const marker = L.circleMarker(region.coordinates, {
                    radius: size,
                    fillColor: riskColors[region.riskLevel] || '#999',
                    color: '#fff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.8
                }).addTo(markers);
                
                // Add popup with region info
                marker.bindPopup(`
                    <div class="font-sans">
                        <h4 class="font-bold text-lg mb-1">${region.name}</h4>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <span class="text-gray-500">Kasus:</span>
                                <span class="font-medium">${region.confirmed.toLocaleString()}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Populasi:</span>
                                <span class="font-medium">${region.population.toLocaleString()}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">IR:</span>
                                <span class="font-medium">${region.incidenceRate.toFixed(2)}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="font-medium capitalize" style="color: ${riskColors[region.riskLevel]}">${region.riskLevel}</span>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-gray-400">Terakhir update: ${region.lastUpdated}</div>
                    </div>
                `);
            });
            
            // Fit map to show all markers
            if (Object.keys(markers._layers).length > 0) {
                map.fitBounds(markers.getBounds().pad(0.2));
            }
            
            // Add legend
            const legend = L.control({position: 'bottomright'});
            
            legend.onAdd = function(map) {
                const div = L.DomUtil.create('div', 'bg-white p-3 rounded-lg shadow-lg border border-gray-200');
                div.innerHTML = `
                    <h4 class="font-bold mb-2 text-sm">Keterangan Zona Risiko</h4>
                    <div class="space-y-1 text-xs">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background:${riskColors.green}"></div>
                            <span>Green Zone (IR < 1.0)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background:${riskColors.yellow}"></div>
                            <span>Yellow Zone (IR < 5.0)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background:${riskColors.red}"></div>
                            <span>Red Zone (IR < 10.0)</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full mr-2" style="background:${riskColors.black}"></div>
                            <span>Black Zone (IR ≥ 10.0)</span>
                        </div>
                    </div>
                `;
                return div;
            };
            
            legend.addTo(map);
            
            // Optional: Add heatmap layer
            const heatmapPoints = regionsData
                .filter(region => region.confirmed > 0)
                .map(region => [region.coordinates[0], region.coordinates[1], region.confirmed/100]);
            
            if (heatmapPoints.length > 0) {
                L.heatLayer(heatmapPoints, {
                    radius: 25,
                    blur: 15,
                    maxZoom: 17,
                    gradient: {0.4: 'blue', 0.6: 'lime', 0.7: 'yellow', 0.8: 'red'}
                }).addTo(map);
            }
        });
    </script>
</body>
</html>