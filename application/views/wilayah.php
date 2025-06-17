<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Daftar Wilayah Indonesia</h1>
    <div class="space-y-4">
        <?php foreach ($regions as $province): ?>
            <div class="border rounded-lg bg-white shadow-md">
                <button class="w-full text-left p-4 font-semibold text-gray-700 focus:outline-none" 
                        onclick="toggleMenu(this)">
                    <?= $province['provinsi'] ?>
                    <svg class="w-5 h-5 inline-block ml-2 transition-transform duration-300" id="arrow-<?= str_replace(' ', '-', strtolower($province['provinsi'])) ?>">
                        <path d="M7 10l5 5 5-5H7z" fill="currentColor"/>
                    </svg>
                </button>
                <div class="hidden" id="menu-<?= str_replace(' ', '-', strtolower($province['provinsi'])) ?>">
                    <?php foreach ($province['kota_kabupaten'] as $regency): ?>
                        <div class="ml-4 border-t">
                            <button class="w-full text-left p-4 text-gray-600 focus:outline-none" 
                                    onclick="toggleSubMenu(this)">
                                <?= $regency['nama'] ?>
                                <svg class="w-5 h-5 inline-block ml-2 transition-transform duration-300" id="arrow-<?= str_replace(' ', '-', strtolower($province['provinsi'] . '-' . $regency['nama'])) ?>">
                                    <path d="M7 10l5 5 5-5H7z" fill="currentColor"/>
                                </svg>
                            </button>
                            <div class="hidden" id="submenu-<?= str_replace(' ', '-', strtolower($province['provinsi'] . '-' . $regency['nama'])) ?>">
                                <?php foreach ($regency['kecamatan'] as $district): ?>
                                    <div class="ml-8 border-t">
                                        <button class="w-full text-left p-4 text-gray-500 focus:outline-none" 
                                                onclick="toggleSubSubMenu(this)">
                                            <?= $district['nama'] ?>
                                            <svg class="w-5 h-5 inline-block ml-2 transition-transform duration-300" id="arrow-<?= str_replace(' ', '-', strtolower($province['provinsi'] . '-' . $regency['nama'] . '-' . $district['nama'])) ?>">
                                                <path d="M7 10l5 5 5-5H7z" fill="currentColor"/>
                                            </svg>
                                        </button>
                                        <div class="hidden" id="subsubmenu-<?= str_replace(' ', '-', strtolower($province['provinsi'] . '-' . $regency['nama'] . '-' . $district['nama'])) ?>">
                                            <ul class="ml-12 p-2 space-y-1">
                                                <?php foreach ($district['kelurahan'] as $village): ?>
                                                    <li class="text-gray-600"><?= $village ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function toggleMenu(element) {
        const province = element.textContent.trim();
        const menuId = 'menu-' + province.replace(/\s+/g, '-').toLowerCase();
        const arrowId = 'arrow-' + province.replace(/\s+/g, '-').toLowerCase();
        const menu = document.getElementById(menuId);
        const arrow = document.getElementById(arrowId);
        menu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function toggleSubMenu(element) {
        const text = element.textContent.trim();
        const parts = text.split(' ');
        const province = parts.slice(0, -1).join('-').toLowerCase();
        const regency = parts[parts.length - 1].toLowerCase();
        const submenuId = 'submenu-' + province + '-' + regency;
        const arrowId = 'arrow-' + province + '-' + regency;
        const submenu = document.getElementById(submenuId);
        const arrow = document.getElementById(arrowId);
        submenu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }

    function toggleSubSubMenu(element) {
        const text = element.textContent.trim();
        const parts = text.split(' ');
        const province = parts.slice(0, -2).join('-').toLowerCase();
        const regency = parts[parts.length - 2].toLowerCase();
        const district = parts[parts.length - 1].toLowerCase();
        const subsubmenuId = 'subsubmenu-' + province + '-' + regency + '-' + district;
        const arrowId = 'arrow-' + province + '-' + regency + '-' + district;
        const subsubmenu = document.getElementById(subsubmenuId);
        const arrow = document.getElementById(arrowId);
        subsubmenu.classList.toggle('hidden');
        arrow.classList.toggle('rotate-180');
    }
</script>