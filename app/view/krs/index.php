<?php 
$showRollback = false;
$rollbackId = "";
if (isset($_SESSION["rollback_krs_id"])) {
    $showRollback = true;
    $rollbackId = $_SESSION["rollback_krs_id"];
    unset($_SESSION["rollback_krs_id"]);
}
?>
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8 relative">
    <?php if ($showRollback): ?>
    <div id="rollbackKrsPopup" class="fixed bottom-8 right-8 z-50 bg-white border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.12)] rounded-xl p-4 flex items-center gap-4 transition-all duration-300 transform translate-y-0 opacity-100 no-print" style="width: 320px;">
        <div class="flex-1">
            <h4 class="text-sm font-bold text-gray-800 mb-0.5">Batalkan ambil KRS?</h4>
            <p class="text-xs text-gray-500 mb-2">Anda dapat membatalkan aksi ini.</p>
            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                <div class="bg-brand-500 h-1.5 rounded-full w-full origin-left transition-all duration-75" id="rollbackProgressBar"></div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="closeRollbackKrs()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-colors cursor-pointer">
                <i class="ph ph-x text-lg"></i>
            </button>
            <a href="<?= CONSTANT::DIRNAME ?>krs/hapusKrs/<?= $rollbackId ?>" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-50 text-green-600 hover:bg-green-600 hover:text-white transition-colors cursor-pointer">
                <i class="ph ph-check text-lg"></i>
            </a>
        </div>
    </div>
    <script>
        let rollbackTime = 5;
        let rollbackInterval = setInterval(() => {
            rollbackTime -= 0.05;
            document.getElementById('rollbackProgressBar').style.width = (rollbackTime / 5) * 100 + '%';
            if (rollbackTime <= 0) {
                closeRollbackKrs();
            }
        }, 50);

        function closeRollbackKrs() {
            clearInterval(rollbackInterval);
            const popup = document.getElementById('rollbackKrsPopup');
            if (popup) {
                popup.classList.add('opacity-0', 'translate-y-4');
                setTimeout(() => popup.remove(), 300);
            }
        }
    </script>
    <?php endif; ?>
    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "dosen"): ?>
        <!-- VIEW DOSEN -->
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Persetujuan KRS Mahasiswa</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola dan setujui Kartu Rencana Studi (KRS) mahasiswa bimbingan
                        akademik Anda.</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors cursor-pointer text-sm shadow-sm flex items-center gap-2">
                        <i class="ph ph-funnel"></i> Filter Status
                    </button>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Menunggu Persetujuan</h2>
                    <span
                        class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-0.5 rounded-full"><?= count(array_filter($data['krsDosen'], fn($krs) => $krs['status'] == 'menunggu')); ?>
                        Perlu
                        Proses</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Mahasiswa</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    NIM</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Semester</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Total SKS</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (count($data["krsDosen"]) > 0): ?>
                                <?php foreach ($data["krsDosen"] as $krs): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs ring-2 ring-white">
                                                    <?= str_replace(" ", "", substr($krs["nama_mahasiswa"], 0, 1)) ?>
                                                </div>
                                                <div class="text-sm font-medium text-gray-900"><?= $krs["nama_mahasiswa"] ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $krs["nim"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">4</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                            <?= $krs["total_sks"] ?> SKS
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span
                                                class="<?= $krs['status'] == 'disetujui' ? 'bg-green-50 text-green-600 border-green-100' : '' ?> <?= $krs['status'] == 'ditolak' ? 'bg-red-50 text-red-600 border-red-100' : '' ?> <?= $krs['status'] == 'menunggu' ? 'bg-orange-50 text-orange-600 border-orange-100' : '' ?> px-2 py-1 rounded text-xs font-medium border capitalize"><?= $krs["status"] ?></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="<?= CONSTANT::DIRNAME ?>krs/validasiKrs/<?= $krs['nim'] ?>/disetujui"
                                                    class="bg-green-100 text-green-700 hover:bg-green-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex "><i
                                                        class="ph ph-check m-auto"></i></a>
                                                <a href="<?= CONSTANT::DIRNAME ?>krs/validasiKrs/<?= $krs['nim'] ?>/ditolak"
                                                    class="bg-red-100 text-red-700 hover:bg-red-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex"><i
                                                        class="ph ph-x m-auto"></i></a>
                                                <button data-nama='<?= $krs["nama_mahasiswa"] ?>'
                                                    data-total-sks="<?= $krs['total_sks'] ?> " data-nim='<?= $krs["nim"] ?>'
                                                    data-krs='<?= json_encode($krs["krs"]) ?>' onclick="openModalDetailKrs(this)"
                                                    class="bg-brand-100 text-brand-600 hover:bg-brand-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex"><i
                                                        class="ph ph-eye m-auto"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center text-gray-500">
                                    <td colspan="6" class="py-10">Tidak ada krs yang menunggu persetujuan <i
                                            class="ph ph-magnifying-glass"></i>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Detail Matkul Mahasiswa -->
        <div id="modalDetailKrs" class="fixed inset-0 z-50 hidden no-print" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModalDetailKrs()">
            </div>
            <div class="fixed inset-0 z-10 overflow-y-auto w-full">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-4xl border border-gray-100">
                        <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold leading-6 text-gray-900">Detail KRS Mahasiswa</h3>
                                <p class="text-sm text-gray-500 mt-2">Daftar mata kuliah yang diambil oleh <span
                                        class="font-bold text-gray-800" id="detailKrsName">Nama</span> (<span
                                        id="detailKrsNim">NIM</span>)</p>
                            </div>
                            <button onclick="closeModalDetailKrs()"
                                class="mt-1 text-gray-400 hover:text-gray-600 cursor-pointer transition">
                                <i class="ph ph-x text-2xl"></i>
                            </button>
                        </div>

                        <div class="p-0 overflow-x-auto max-h-[50vh] bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Kode</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Mata Kuliah</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            SKS</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Kelas</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyModalKrs" class="bg-white divide-y divide-gray-100">
                                    <tr class="text-center text-gray-500">
                                        <td colspan="5" class="py-10">Belum ada krs yang dipilih <i
                                                class="ph ph-magnifying-glass"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-2xl border-t border-gray-100">
                            <div class="text-sm font-medium text-gray-700">Estimasi SKS: <span
                                    class="font-bold text-brand-600" id="totalSksModal">8 SKS</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- VIEW MAHASISWA -->
        <div class="max-w-7xl mx-auto" id="printable-krs">
            <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900" id="krs-title">Kartu Rencana Studi (KRS)</h1>
                    <p class="text-sm text-gray-500 mt-1 no-print">Pilih dan kelola mata kuliah Anda untuk semester ini.</p>
                    <div class="hidden print:block mt-4 mb-2 text-sm">
                        <p><strong>Nama:</strong> <?= $data['user']['nama_lengkap'] ?></p>
                        <p><strong>NIM:</strong> <?= $data['user']['nim'] ?></p>
                        <p><strong>Program Studi:</strong> <?= $data['user']['jurusan'] ?></p>
                    </div>
                </div>
                <div class="flex gap-2 no-print">
                    <button onclick="window.print()"
                        class="bg-blue-500/10 border border-blue-500 text-blue-500 hover:bg-blue-500/30 px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-colors shadow-sm cursor-pointer">
                        <i class="ph ph-printer text-xl"></i> Cetak PDF
                    </button>
                    <button onclick="openModalKrs()"
                        class="bg-brand-600 cursor-pointer hover:bg-brand-700 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2 transition-colors shadow-sm">
                        <i class="ph ph-plus-circle text-xl"></i> Tambah Matkul
                    </button>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Mata Kuliah Diambil</h2>
                    <div class="text-sm">
                        <span class="text-gray-500">Total SKS:</span>
                        <span class="font-bold text-brand-600 ml-1 text-lg"><?= $data["jumlahSks"]["jumlah_sks"] ?>
                            SKS</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Kode</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Mata Kuliah</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    SKS</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Dosen Pengampu</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider no-print">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <!-- Row 1 -->
                            <?php if (count($data["myKrs"]) > 0): ?>
                                <?php foreach ($data["myKrs"] as $krs): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?= $krs["id_mk"] ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700"><?= $krs["nama_mk"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?= $krs["sks"] ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center gap-2">
                                            <img src="https://ui-avatars.com/api/?name=<?= str_replace(' ', '+', $krs["nama_dosen"]) ?>&background=random"
                                                class="w-6 h-6 rounded-full no-print" alt="Dosen">
                                            <?= $krs["nama_dosen"] ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center no-print">
                                            <a href="<?= CONSTANT::DIRNAME ?>krs/hapusKrs/<?= $krs["id_kelas"] ?>"
                                                class="text-red-500 rounded-lg inline-flex items-center justify-center bg-red-500/30 hover:bg-red-500/40 transition-colors p-1.5 cursor-pointer"
                                                title="Hapus"><i class="ph ph-trash text-lg"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center text-gray-500">
                                    <td colspan="6" class="py-10">Belum ada krs yang diambil <i
                                            class="ph ph-magnifying-glass"></i>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Area Cetak PDF -->
                <div class="hidden print:flex justify-between items-start mt-12 px-8 pb-8">
                    <div class="text-center">
                        <p class="mb-16 text-sm text-gray-700">Dosen Pembimbing Akademik</p>
                        <p class="font-bold text-gray-900"><?= isset($data['dosenPembimbing']['nama_lengkap']) ? $data['dosenPembimbing']['nama_lengkap'] : 'Dosen pembimbing belum ada' ?></p>
                        <p class="text-xs text-gray-500">NIP. <?= isset($data['dosenPembimbing']['nip']) ? $data['dosenPembimbing']['nip'] : 'NIP pembimbing belum ada' ?></p>
                    </div>
                    <div class="text-center">
                        <p class="mb-1 text-sm text-gray-700">Bandar Lampung, <?= date('d F Y') ?></p>
                        <p class="mb-14 text-sm text-gray-700">Mahasiswa,</p>
                        <p class="font-bold text-gray-900"><?= $data['user']['nama_lengkap'] ?></p>
                        <p class="text-xs text-gray-500">NPM. <?= $data['user']['nim'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Matkul (War KRS) -->
        <div id="modalKrs" class="fixed inset-0 z-50 hidden no-print" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModalKrs()"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto w-full">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div
                        class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-5xl border border-gray-100">
                        <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-start justify-between">
                            <div>
                                <h3 class="text-xl font-bold leading-6 text-gray-900" id="modal-title">Katalog Mata Kuliah
                                    (War KRS)</h3>
                                <p class="text-sm text-gray-500 mt-2">Daftar mata kuliah yang ditawarkan untuk semester ini.
                                    Perhatikan sisa kuota kelas.</p>
                            </div>
                            <button onclick="closeModalKrs()"
                                class="mt-1 text-gray-400 hover:text-gray-600 cursor-pointer transition">
                                <i class="ph ph-x text-2xl"></i>
                            </button>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex gap-4">
                            <div class="relative flex-1">
                                <i
                                    class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" placeholder="Cari mata kuliah..." onkeyup="handleSearch(this)"
                                    class="w-full bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                            </div>

                        </div>

                        <div class="p-0 overflow-x-auto max-h-[50vh] bg-white">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Kode</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Mata Kuliah</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            SKS</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Kelas / Dosen</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Kuota</th>
                                        <th
                                            class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyKrs" class="bg-white divide-y divide-gray-100">
                                    <?php if (count($data["krs"]) > 0): ?>
                                        <?php foreach ($data["krs"] as $krs): ?>
                                            <tr class="hover:bg-blue-50/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <?= $krs["id_kelas"] ?>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700 font-medium"><?= $krs["nama_mk"] ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">3</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div class="font-medium text-gray-800">Kelas <?= substr($krs['id_kelas'], 3, 1) ?></div>
                                                    <div class="text-xs"><?= $krs["nama_dosen"] ?></div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                                    <span class="text-xs text-gray-500 font-semibold"><?= $krs['sisa_kuota']?> dari <?= $krs['kuota']?></span>
                                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                                                        <div class="bg-brand-700 h-1.5 rounded-full"
                                                            style="width: <?= ($krs["kuota"] / $krs["sisa_kuota"]) * 100 ?>%"></div>
                                                    </div>
                                                    <span class="text-xs text-blue-700 font-semibold">Tersisa
                                                        <?= $krs["sisa_kuota"] ?> kursi</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                                    <?php if ($krs["status"] == 'belum diambil'): ?>
                                                        <a href="<?= CONSTANT::DIRNAME ?>krs/ambilKrs/<?= $krs["id_kelas"] ?>"
                                                            class="bg-brand-100 text-brand-700 hover:bg-brand-600 hover:text-white px-3 py-1.5 rounded-md transition-colors cursor-pointer text-xs font-bold">Ambil</a>
                                                    <?php else: ?>
                                                        <span
                                                            class="bg-red-500 rounded-md text-xs px-3 py-1.5 font-bold text-white">sudah
                                                            diambil</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr class="text-center text-gray-500">
                                            <td colspan="6" class="py-10">Belum ada krs yang tersedia <i
                                                    class="ph ph-magnifying-glass"></i>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<script>
    function openModalKrs() {
        document.getElementById('modalKrs').classList.remove('hidden');
    }

    function closeModalKrs() {
        document.getElementById('modalKrs').classList.add('hidden');
    }

    function openModalDetailKrs(el) {
        const nama = el.dataset.nama;
        const nim = el.dataset.nim;
        const krs = JSON.parse(el.dataset.krs);
        const totalSks = el.dataset.totalSks;
        const body = document.getElementById('bodyModalKrs');
        const hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        document.getElementById('detailKrsName').textContent = nama;
        document.getElementById('detailKrsNim').textContent = nim;
        document.getElementById('totalSksModal').textContent = totalSks;
        document.getElementById('modalDetailKrs').classList.remove('hidden');
        let template = ``;

        if (krs.length > 0) {
            krs.forEach((krs, i) => {
                template += `
                <tr class="hover:bg-blue-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${i + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${krs.id_kelas}</td>
                    <td class="px-6 py-4 text-sm text-gray-700 font-medium">${krs.nama_mk}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">${krs.sks}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${hari[krs.hari]}</td>
                </tr>
                `;
            });
        } else {
            template += `
             <tr class="text-center text-gray-500">
                <td colspan="5" class="py-10">Belum ada krs yang dipilih <i
                        class="ph ph-magnifying-glass"></i>
                </td>
            </tr>
            `;
        }
        body.innerHTML = template;
    }

    const closeModalDetailKrs = () => {
        document.getElementById('modalDetailKrs').classList.add('hidden');
    }

    const handleSearch = async (el) => {
        const res = await fetch(`<?= CONSTANT::DIRNAME ?>krs/search`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ search: el.value, id_user: "<?= $_SESSION['id_user'] ?>" })
        });
        const data = await res.json();
        const body = document.getElementById('bodyKrs');
        let template = ``;
        if (data.length > 0) {
            data.forEach((krs, i) => {
                template += `
            <tr class="hover:bg-blue-50/50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    ${krs.id_kelas}
                </td>
                <td class="px-6 py-4 text-sm text-gray-700 font-medium">${krs.nama_mk}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">3</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="font-medium text-gray-800">Kelas A</div>
                    <div class="text-xs">${krs.nama_dosen}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1">
                        <div class="bg-orange-500 h-1.5 rounded-full"
                            style="width: ${(krs.kuota / krs.sisa_kuota) * 100}%"></div>
                    </div>
                    <span class="text-xs text-orange-600 font-semibold">Tersisa
                        ${krs.sisa_kuota} kursi</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                    ${krs.status != 'menunggu' ? `<a href="<?= CONSTANT::DIRNAME ?>krs/ambilKrs/${krs.id_kelas}"
                            class="bg-brand-100 text-brand-700 hover:bg-brand-600 hover:text-white px-3 py-1.5 rounded-md transition-colors cursor-pointer text-xs font-bold">Ambil</a>` : `<span
                            class="bg-red-500 rounded-md text-xs px-3 py-1.5 font-bold text-white">sudah
                            diambil</span>`}
                </td>
            </tr>
            `;
            });
        } else {
            template += `
            <tr class="text-center text-gray-500">
                <td colspan="6" class="py-10">Nama mata kuliah tidak ditemukan <i
                        class="ph ph-magnifying-glass"></i>
                </td>
            </tr>
            `;
        }

        body.innerHTML = template;
    }
</script>