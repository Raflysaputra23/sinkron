<div id="mobile-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden lg:hidden"
    onclick="toggleMobileSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="sidebar sidebar-expanded bg-brand-900 text-white z-30 flex flex-col h-full fixed lg:relative transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shadow-xl">
    <div class="h-16 flex items-center justify-between px-4 border-b border-brand-800">
        <div class="flex items-center space-x-3 overflow-hidden">
            <div class="bg-brand-600 rounded-lg p-1.5 shrink-0">
                <i class="ph ph-student text-2xl text-white"></i>
            </div>
            <span class="menu-text font-bold text-xl tracking-wide">SIAKRS</span>
        </div>
        <button class="lg:hidden text-gray-300 hover:text-white" onclick="toggleMobileSidebar()">
            <i class="ph ph-x text-2xl"></i>
        </button>
    </div>

    <nav class="flex-1 flex flex-col items-stretch gap-2 overflow-y-auto overflow-x-hidden py-4">
        <a href="<?= CONSTANT::DIRNAME ?>dashboard"
            class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Dashboard" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
            <i class="ph ph-squares-four text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
            <span class="menu-text ml-4 font-medium">Dashboard</span>
        </a>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
            <a href="<?= CONSTANT::DIRNAME ?>manajemen"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Manajemen Data" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-database text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span class="menu-text ml-4 font-medium">Manajemen Data</span>
            </a>
        <?php endif; ?>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
            <a href="<?= CONSTANT::DIRNAME ?>akademik"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Data Akademik" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-folders text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span class="menu-text ml-4 font-medium">Data Akademik</span>
            </a>
        <?php endif; ?>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] != "admin"): ?>
            <a href="<?= CONSTANT::DIRNAME ?>krs"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "KRS" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-file-text text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span
                    class="menu-text ml-4 font-medium"><?= (isset($_SESSION["role"]) && $_SESSION["role"] == "dosen") ? "Persetujuan KRS" : "KRS" ?></span>
            </a>
        <?php endif; ?>

        <!-- <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "mahasiswa"): ?>
            <a href="<?= CONSTANT::DIRNAME ?>transaksi"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Transaksi" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-credit-card py-0.5 text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span class="menu-text ml-4 font-medium">Transaksi</span>
            </a>

            <a href="<?= CONSTANT::DIRNAME ?>laporan"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Laporan View" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-chart-bar text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span class="menu-text ml-4 font-medium">Laporan View</span>
            </a>
        <?php endif; ?> -->

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
            <a href="<?= CONSTANT::DIRNAME ?>log"
                class="flex items-center rounded-lg px-4 py-3 <?= $data["title"] == "Log Simulasi (PDT)" ? "bg-brand-800 text-white border-l-4 border-blue-700" : "text-gray-300 hover:bg-brand-800 hover:text-white border-l-4 border-transparent hover:border-blue-300" ?> transition-colors group relative">
                <i class="ph ph-clock-counter-clockwise text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
                <span class="menu-text ml-4 font-medium">Log Simulasi (PDT)</span>
            </a>
        <?php endif; ?>

        <a href="<?= CONSTANT::DIRNAME ?>dashboard/logout"
            class="flex mt-auto items-center rounded-lg px-4 py-3 bg-red-500 transition-colors group relative">
            <i class="ph ph-sign-out text-xl shrink-0 group-hover:scale-110 transition-transform"></i>
            <span class="menu-text ml-4 font-medium">Keluar</span>
        </a>
    </nav>

    <div class="h-12 w-8 absolute border rounded-xl top-1/2 -translate-y-1/2 -right-4 border-t border-brand-600 hidden lg:flex items-center justify-center cursor-pointer bg-brand-800 transition-colors"
        onclick="toggleSidebarDesktop()">
        <i id="toggle-icon" class="ph ph-caret-left text-xl text-gray-300"></i>
    </div>
</aside>

<div class="flex-1 flex flex-col h-screen overflow-hidden w-full">
    <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-8 z-10">
        <div class="flex items-center">
            <button class="lg:hidden text-gray-500 hover:text-brand-600 focus:outline-none mr-4"
                onclick="toggleMobileSidebar()">
                <i class="ph ph-list text-2xl"></i>
            </button>
            <button class="text-gray-400 hover:text-brand-600 transition-colors relative">
                <i class="ph ph-bell text-xl"></i>
                <span
                    class="absolute top-0 right-0 -mt-1 -mr-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow">3</span>
            </button>
        </div>

        <div class="flex items-center space-x-4">

            <div class="h-8 w-px bg-gray-200 mx-2"></div>

            <div class="flex items-center space-x-3 cursor-pointer group">
                <div class="hidden sm:block text-right">
                    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
                        <div class="text-sm font-semibold text-gray-800 group-hover:text-brand-600 transition-colors">
                            Admin
                        </div>
                        <div class="text-xs text-gray-500"><?= $data["user"]["username"] ?></div>
                    <?php elseif (isset($_SESSION["role"]) && $_SESSION["role"] == "dosen"): ?>
                        <div class="text-sm font-semibold text-gray-800 group-hover:text-brand-600 transition-colors">
                            <?= $data["user"]["nama_lengkap"] ?>
                        </div>
                        <div class="text-xs text-gray-500">NIP: <?= $data["user"]["nip"] ?></div>
                    <?php else: ?>
                        <div class="text-sm font-semibold text-gray-800 group-hover:text-brand-600 transition-colors">
                            <?= $data["user"]["nama_lengkap"] ?>
                        </div>
                        <div class="text-xs text-gray-500"><?= $data["user"]["nim"] ?> • <?= $data["user"]["jurusan"] ?>
                        </div>
                    <?php endif; ?>
                </div>
                <img src="<?= isset($data["user"]["foto"]) ? $data["user"]["foto"] : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', isset($data["user"]["nama_lengkap"]) ? $data["user"]["nama_lengkap"] : $data["user"]['username']) . '&background=2563eb&color=fff&rounded=true' ?>"
                    alt="foto <?= isset($data["user"]["nama_lengkap"]) ? $data["user"]["nama_lengkap"] : $data["user"]['username'] ?>"
                    class="h-10 w-10 rounded-full shadow-sm border-2 border-transparent group-hover:border-brand-500 transition-all">
            </div>
        </div>
    </header>