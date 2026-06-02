<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
        <!-- DASHBOARD ADMIN -->
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Administrator</h1>
                    <p class="text-sm text-gray-500 mt-1">Sistem Pemantauan Civitas Akademika.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Total Mahasiswa</p>
                        <h3 class="text-3xl font-bold text-gray-900"><?= $data['admin']['total_mahasiswa'] ?></h3>
                    </div>
                    <div class="p-2 bg-blue-50 text-brand-600 rounded-lg"><i class="ph ph-student text-2xl"></i></div>
                </div>
                <div
                    class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Total Dosen</p>
                        <h3 class="text-3xl font-bold text-gray-900"><?= $data['admin']['total_dosen'] ?></h3>
                    </div>
                    <div class="p-2 bg-purple-50 text-purple-600 rounded-lg"><i
                            class="ph ph-chalkboard-teacher text-2xl"></i></div>
                </div>
                <div
                    class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Mata Kuliah Aktif</p>
                        <h3 class="text-3xl font-bold text-gray-900"><?= $data['admin']['total_mk'] ?></h3>
                    </div>
                    <div class="p-2 bg-green-50 text-green-600 rounded-lg"><i class="ph ph-books text-2xl"></i></div>
                </div>
                <div
                    class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 mb-1">Total Kelas</p>
                        <h3 class="text-3xl font-bold text-gray-900"><?= $data['admin']['total_kelas'] ?></h3>
                    </div>
                    <div class="p-2 bg-orange-50 text-orange-600 rounded-lg"><i class="ph ph-door text-2xl"></i></div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <!-- Tabel Dosen -->
                <div
                    class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Dosen Pengajar</h2>
                    </div>
                    <div class="overflow-auto max-h-[400px]">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NIP</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama
                                        Lengkap</th>
                                    <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <?php foreach ($data['users']['dosen'] as $dosen): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3">
                                            <div class="text-sm text-gray-700"><?= $dosen['id'] ?></div>
                                        </td>
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-gray-700 text-sm"><?= $dosen['nama_lengkap'] ?></div>
                                        </td>
                                        <td class="px-5 py-3 text-center"><span
                                                class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-semibold">Aktif</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Mahasiswa -->
                <div
                    class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Mahasiswa</h2>
                    </div>
                    <div class="overflow-auto max-h-[400px]">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 sticky top-0">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">NPM / NIM
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama
                                        Lengkap</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Program
                                        Studi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <?php foreach($data['users']['mahasiswa'] as $mahasiswa): ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-5 py-3 text-sm text-gray-500"><?= $mahasiswa['id'] ?></td>
                                    <td class="px-5 py-3 text-sm font-bold text-gray-900"><?= $mahasiswa['nama_lengkap'] ?></td>
                                    <td class="px-5 py-3 text-sm text-gray-600">Ilmu Komputer</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php elseif (isset($_SESSION["role"]) && $_SESSION["role"] == "dosen"): ?>
        <!-- DASHBOARD DOSEN -->
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard Dosen Pembimbing</h1>
                    <p class="text-sm text-gray-500 mt-1">Selamat datang kembali, <?= $data["user"]["nama_lengkap"] ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-500">Tahun Akademik</p>
                    <p class="text-brand-600 font-bold">2025/2026 Genap</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div class="w-[80%]">
                            <p class="text-sm font-medium text-gray-500 mb-1">Mahasiswa Bimbingan</p>
                            <h3 class="text-3xl font-extrabold text-gray-900">
                                <?= $data['dosen']['total_mahasiswa_bimbingan'] ?>
                            </h3>
                            <p class="text-xs text-gray-400 mt-2">Total Mahasiswa Akademik</p>
                        </div>
                        <div class="text-brand-600 absolute right-0 top-0">
                            <i class="ph ph-users text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-orange-50 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Menunggu ACC KRS</p>
                            <h3 class="text-3xl font-extrabold text-orange-600"><?= $data['dosen']['total_krs_menunggu'] ?>
                            </h3>
                            <p class="text-xs text-orange-400 mt-2">Memerlukan Konfirmasi</p>
                        </div>
                        <div class="text-orange-600 absolute right-0 top-0">
                            <i class="ph ph-file-dashed text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div
                        class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full group-hover:scale-110 transition-transform">
                    </div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Mata Kuliah Diampu</p>
                            <h3 class="text-3xl font-extrabold text-purple-600">
                                <?= $data['dosen']['total_matakuliah_diampu'] ?>
                            </h3>
                            <p class="text-xs text-purple-400 mt-2">Total 12 SKS</p>
                        </div>
                        <div class="text-purple-600 absolute right-0 top-0">
                            <i class="ph ph-chalkboard-teacher text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg flex items-center gap-2 font-bold text-gray-800">
                            <i class="ph ph-calendar text-xl text-blue-500"></i>
                            Jadwal Mengajar Hari Ini
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <?php if (count($data['jadwalDosen']) > 0): ?>
                            <?php foreach ($data['jadwalDosen'] as $jadwal): ?>
                                <div
                                    class="flex items-start gap-4 p-4 rounded-xl border border-gray-100 hover:border-brand-300 hover:bg-brand-50/30 transition-colors cursor-pointer">
                                    <div class="text-center shrink-0 w-16">
                                        <span
                                            class="block text-xl font-bold border-b border-gray-200 pb-1 text-gray-800"><?= $data['hari'][$jadwal['hari']] ?></span>
                                        <span
                                            class="block text-[10px] font-semibold text-gray-500 pt-1"><?= substr($jadwal['jam_mulai'], 0, 5) ?>-<?= substr($jadwal['jam_selesai'], 0, 5) ?></span>
                                    </div>
                                    <div class="border-l-4 border-brand-500 pl-4">
                                        <h3 class="font-bold text-gray-900"><?= $jadwal['nama_mk'] ?> (<?= $jadwal['id_mk'] ?>)</h3>
                                        <p class="text-sm text-gray-500 mt-1"><i class="ph ph-map-pin text-brand-500"></i>
                                            <?= $jadwal['ruangan'] ?> • Kelas <?= substr($jadwal['id_kelas'], 3, 1) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="ph ph-calendar text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500">Tidak ada jadwal mengajar hari ini</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg flex items-center gap-2 font-bold text-gray-800">
                            <i class="ph ph-info text-xl text-blue-500"></i>
                            Informasi
                        </h2>
                    </div>
                    <div class="space-y-4">
                        <?php if ($data['dosen']['total_krs_menunggu'] > 0): ?>
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                                    <i class="ph ph-envelope-simple-open text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm"><?= $data['dosen']['total_krs_menunggu'] ?>
                                        Mahasiswa butuh ACC KRS</h3>
                                    <p class="text-xs text-gray-500 mt-1">Ada beberapa mahasiswa menunggu untuk validasi krs.
                                    </p>
                                    <a href="<?= CONSTANT::DIRNAME ?>krs"
                                        class="text-brand-600 text-xs font-semibold mt-2 inline-block">Tinjau Sekarang
                                        &rarr;</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                    <i class="ph ph-check text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-sm">Semua KRS sudah disetujui</h3>
                                    <p class="text-xs text-gray-500 mt-1">Tidak ada KRS yang menunggu persetujuan.</p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- DASHBOARD MAHASISWA (EXISTING) -->
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Selamat datang, <?= $data["user"]["nama_lengkap"] ?></h1>
                    <p class="text-sm text-gray-500 mt-1">Berikut adalah ringkasan aktivitas akademik Anda.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-500">Semester Aktif</p>
                    <p class="text-brand-600 font-bold">2025/2026 Genap</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">SKS Lulus</p>
                            <h3 class="text-3xl font-bold text-gray-900"><?= $data["user"]["sks"] ?></h3>
                        </div>
                        <div class="p-2 bg-blue-50 text-brand-600 rounded-lg">
                            <i class="ph ph-books text-2xl"></i>
                        </div>
                    </div>

                </div>

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">IPK Saat Ini</p>
                            <h3 class="text-3xl font-bold text-gray-900"><?= $data["user"]["ipk"] ?></h3>
                        </div>
                        <div class="p-2 bg-green-50 text-green-600 rounded-lg">
                            <i class="ph ph-chart-line-up text-2xl"></i>
                        </div>
                    </div>

                </div>

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs font-medium text-gray-500 mb-1">Status KRS</p>
                            <h3 class="text-lg font-bold text-orange-500 mt-2 leading-5 capitalize">
                                <?= $data["user"]["status"] ? $data["user"]["status"] : "Belum Mengisi" ?>
                            </h3>
                        </div>
                        <div class="p-2 bg-orange-50 text-orange-500 rounded-lg">
                            <i class="ph ph-clipboard-text text-2xl"></i>
                        </div>
                    </div>

                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div
                    class="lg:col-span-2 bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-800">Jadwal Kuliah Hari Ini</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Hari</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata
                                        Kuliah</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Ruangan</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">SKS</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Dosen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if (count($data["jadwal"]) > 0): ?>
                                    <?php foreach ($data["jadwal"] as $jadwal): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 font-medium">
                                                <?= substr($jadwal["jam_mulai"], 0, 5) ?> -
                                                <?= substr($jadwal["jam_selesai"], 0, 5) ?>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium  ">
                                                <?= $data['hari'][$jadwal['hari']] ?>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-brand-600">
                                                <?= $jadwal["nama_mk"] ?>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                                <?= $jadwal["ruangan"] ?>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                                <?= $jadwal["sks"] ?>
                                            </td>
                                            <td
                                                class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 flex flex-col gap-2 items-start">
                                                <span>- <?= $jadwal["dosen_koor"] ?></span>
                                                <span><?= isset($jadwal["dosen_pendamping"]) ? "- " . $jadwal["dosen_pendamping"] : "" ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="text-center text-gray-500">
                                        <td colspan="4" class="py-10">Tidak ada jadwal <i class="ph ph-magnifying-glass"></i>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-6">Aktivitas Terbaru</h2>
                    <div class="relative border-l border-gray-200 ml-3 space-y-6">
                        <div class="relative pl-6">
                            <span
                                class="absolute -left-1.5 top-1.5 h-3 w-3 rounded-full bg-brand-500 ring-4 ring-white"></span>
                            <p class="text-sm font-medium text-gray-900">Pembayaran UKT Diterima</p>
                            <p class="text-xs text-gray-500 mt-1">Hari ini, 09:30 AM</p>
                        </div>
                        <div class="relative pl-6">
                            <span
                                class="absolute -left-1.5 top-1.5 h-3 w-3 rounded-full bg-green-500 ring-4 ring-white"></span>
                            <p class="text-sm font-medium text-gray-900">KHS Semester Ganjil Terbit</p>
                            <p class="text-xs text-gray-500 mt-1">Kemarin, 14:15 PM</p>
                        </div>
                        <div class="relative pl-6">
                            <span
                                class="absolute -left-1.5 top-1.5 h-3 w-3 rounded-full bg-gray-400 ring-4 ring-white"></span>
                            <p class="text-sm font-medium text-gray-900">Login dari perangkat baru</p>
                            <p class="text-xs text-gray-500 mt-1">12 Feb, 08:00 AM</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    <?php endif; ?>
</main>