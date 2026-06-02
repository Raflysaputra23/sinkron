<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
    <?php if (isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
        <div class="max-w-7xl mx-auto" id="printable-krs">
            <div class="mb-8 flex flex-col justify-between items-start gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Data Master Akademik</h1>
                    <p class="text-sm text-gray-500 mt-1">Kelola data Mata Kuliah dan Kelas (KRS) secara menyeluruh.</p>
                </div>
            </div>

            <!-- TABEL KELAS (KRS) -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-blue-50/50">
                    <h2 class="text-lg font-bold text-brand-700 flex items-center gap-2">
                        <i class="ph ph-chalkboard-teacher text-xl"></i> Data Katalog Kelas (KRS)
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mata Kuliah</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">SKS</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas / Dosen</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Kuota</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (count($data["kelas"]) > 0): ?>
                                <?php foreach ($data["kelas"] as $krs): ?>
                                    <tr class="hover:bg-blue-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"><?= $krs["id_kelas"] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-700 font-medium"><?= $krs["nama_mk"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?= $krs["sks"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="font-bold text-gray-800 flex items-center gap-2">
                                                <span>Kelas <?= substr($krs['id_kelas'], 3, 1) ?></span>
                                                <span class="text-xs font-normal px-2 py-0.5 bg-gray-100 text-gray-600 rounded">
                                                    <?= ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"][$krs['hari']] ?? '' ?> 
                                                    <?= substr($krs['jam_mulai'],0,5) ?>-<?= substr($krs['jam_selesai'],0,5) ?>
                                                </span>
                                            </div>
                                            <div class="text-xs text-gray-600 mt-1"><?= $krs["nama_dosen"] ?> <?= $krs["nama_dosen_pendamping"] ? ' & '.$krs["nama_dosen_pendamping"] : '' ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="text-xs text-gray-500 font-semibold"><?= $krs['sisa_kuota'] ?> dari <?= $krs['kuota'] ?></span>
                                            <div class="w-full bg-gray-200 rounded-full h-1.5 mb-1 mt-1">
                                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: <?= ($krs["kuota_terisi"] / $krs["kuota"]) * 100 ?>%"></div>
                                            </div>
                                            <span class="text-xs text-blue-600 font-semibold">Tersisa <?= $krs["sisa_kuota"] ?> kursi</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='openEditKelas(<?= json_encode($krs) ?>)' class="bg-amber-100 text-amber-700 hover:bg-amber-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex" title="Edit Kelas">
                                                    <i class="ph ph-pencil-simple m-auto"></i>
                                                </button>
                                                <button onclick="confirmHapusKelas('<?= $krs['id_kelas'] ?>')" class="bg-red-100 text-red-700 hover:bg-red-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex" title="Hapus Kelas">
                                                    <i class="ph ph-trash m-auto"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center text-gray-500">
                                    <td colspan="6" class="py-10">Belum ada kelas yang tersedia <i class="ph ph-magnifying-glass"></i></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL MATA KULIAH -->
            <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-orange-50/50">
                    <h2 class="text-lg font-bold text-orange-800 flex items-center gap-2">
                        <i class="ph ph-books text-xl"></i> Data Mata Kuliah
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Kode MK</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Mata Kuliah</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">SKS</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (count($data["mk"]) > 0): ?>
                                <?php foreach ($data["mk"] as $mk): ?>
                                    <tr class="hover:bg-orange-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900"><?= $mk["id_mk"] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-700 font-medium"><?= $mk["nama_mk"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center font-bold"><?= $mk["sks"] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='openEditMk(<?= json_encode($mk) ?>)' class="bg-amber-100 text-amber-700 hover:bg-amber-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex" title="Edit Matkul">
                                                    <i class="ph ph-pencil-simple m-auto"></i>
                                                </button>
                                                <button onclick="confirmHapusMk('<?= $mk['id_mk'] ?>')" class="bg-red-100 text-red-700 hover:bg-red-600 hover:text-white rounded-md transition-colors cursor-pointer text-xs font-bold w-8 h-8 flex" title="Hapus Matkul">
                                                    <i class="ph ph-trash m-auto"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr class="text-center text-gray-500">
                                    <td colspan="4" class="py-10">Belum ada mata kuliah yang tersedia <i class="ph ph-magnifying-glass"></i></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- MODAL EDIT MATKUL -->
    <div id="modalEditMk" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModalEditMk()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto w-full">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-lg border border-gray-100">
                    <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold leading-6 text-gray-900">Edit Mata Kuliah</h3>
                            <p class="text-sm text-gray-500 mt-2">Perbarui informasi mata kuliah <span id="labelEditMk" class="font-bold text-orange-600"></span></p>
                        </div>
                        <button onclick="closeModalEditMk()" class="mt-1 text-gray-400 hover:text-gray-600 cursor-pointer transition">
                            <i class="ph ph-x text-2xl"></i>
                        </button>
                    </div>
                    <form action="<?= CONSTANT::DIRNAME ?>akademik/edit_mk" method="POST">
                        <div class="p-6 space-y-4">
                            <input type="hidden" name="id_mk" id="edit_mk_id">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Kuliah</label>
                                <input type="text" name="nama_mk" id="edit_mk_nama" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-orange-500 focus:border-orange-500 outline-none transition-shadow">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bobot SKS</label>
                                <input type="number" name="sks" id="edit_mk_sks" min="1" max="6" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-orange-500 focus:border-orange-500 outline-none transition-shadow">
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                            <button type="button" onclick="closeModalEditMk()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg font-bold hover:bg-orange-700 transition-colors cursor-pointer flex items-center gap-2"><i class="ph ph-floppy-disk"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT KELAS -->
    <div id="modalEditKelas" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeModalEditKelas()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto w-full">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full max-w-xl border border-gray-100">
                    <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-start justify-between">
                        <div>
                            <h3 class="text-xl font-bold leading-6 text-gray-900">Edit Data Kelas</h3>
                            <p class="text-sm text-gray-500 mt-2">Sesuaikan jadwal dan dosen untuk <span id="labelEditKelas" class="font-bold text-blue-600"></span></p>
                        </div>
                        <button onclick="closeModalEditKelas()" class="mt-1 text-gray-400 hover:text-gray-600 cursor-pointer transition">
                            <i class="ph ph-x text-2xl"></i>
                        </button>
                    </div>
                    <form action="<?= CONSTANT::DIRNAME ?>akademik/edit_kelas" method="POST">
                        <div class="p-6 space-y-4">
                            <input type="hidden" name="id_kelas" id="edit_kelas_id">
                            
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Dosen Koordinator</label>
                                    <select name="id_dosen_koor" id="edit_kelas_koor" onchange="handleEditPilihDosenKoor(this)" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow cursor-pointer">
                                        <option value="">Pilih Dosen</option>
                                        <?php foreach($data['dosen'] as $dosen) : ?>
                                            <option value="<?= $dosen['nip'] ?>"><?= $dosen['nip'] ?> - <?= $dosen['nama_lengkap'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pendamping <span class="text-xs text-gray-500">(Opsional)</span></label>
                                    <select name="id_dosen_pendamping" id="edit_kelas_pendamping" onchange="handleEditPilihDosenPendamping(this)" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow cursor-pointer">
                                        <option value="">Tidak ada Dosen Pendamping</option>
                                        <?php foreach($data['dosen'] as $dosen) : ?>
                                            <option value="<?= $dosen['nip'] ?>"><?= $dosen['nip'] ?> - <?= $dosen['nama_lengkap'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                                    <select name="hari" id="edit_kelas_hari" required class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow cursor-pointer">
                                        <option value="0">Senin</option><option value="1">Selasa</option><option value="2">Rabu</option><option value="3">Kamis</option><option value="4">Jumat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" id="edit_kelas_mulai" required class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow cursor-pointer">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" id="edit_kelas_selesai" required class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow cursor-pointer">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ruangan</label>
                                    <input type="text" name="ruangan" id="edit_kelas_ruangan" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Mahasiswa</label>
                                    <input type="number" min="1" name="kuota" id="edit_kelas_kuota" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 outline-none transition-shadow">
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end gap-3 rounded-b-2xl">
                            <button type="button" onclick="closeModalEditKelas()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700 transition-colors cursor-pointer flex items-center gap-2"><i class="ph ph-floppy-disk"></i> Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // MATA KULIAH
    function openEditMk(data) {
        document.getElementById('labelEditMk').textContent = data.id_mk;
        document.getElementById('edit_mk_id').value = data.id_mk;
        document.getElementById('edit_mk_nama').value = data.nama_mk;
        document.getElementById('edit_mk_sks').value = data.sks;
        document.getElementById('modalEditMk').classList.remove('hidden');
    }
    function closeModalEditMk() {
        document.getElementById('modalEditMk').classList.add('hidden');
    }
    function confirmHapusMk(id_mk) {
        Swal.fire({
            title: 'Hapus Mata Kuliah?',
            text: "Data " + id_mk + " akan dihapus permanen jika tidak digunakan oleh kelas manapun.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= CONSTANT::DIRNAME ?>akademik/hapus_mk/${id_mk}`;
            }
        })
    }

    // KELAS 
    function openEditKelas(data) {
        document.getElementById('labelEditKelas').textContent = data.id_kelas + ' - ' + data.nama_mk;
        document.getElementById('edit_kelas_id').value = data.id_kelas;
        document.getElementById('edit_kelas_koor').value = data.id_dosen_koor;
        document.getElementById('edit_kelas_pendamping').value = data.id_dosen_pendamping || '';
        document.getElementById('edit_kelas_hari').value = data.hari;
        document.getElementById('edit_kelas_mulai').value = data.jam_mulai;
        document.getElementById('edit_kelas_selesai').value = data.jam_selesai;
        document.getElementById('edit_kelas_ruangan').value = data.ruangan;
        document.getElementById('edit_kelas_kuota').value = data.kuota;
        
        handleEditPilihDosenKoor(document.getElementById('edit_kelas_koor'));
        handleEditPilihDosenPendamping(document.getElementById('edit_kelas_pendamping'));
        
        document.getElementById('modalEditKelas').classList.remove('hidden');
    }
    function closeModalEditKelas() {
        document.getElementById('modalEditKelas').classList.add('hidden');
    }
    function confirmHapusKelas(id_kelas) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: "Data Kelas " + id_kelas + " akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= CONSTANT::DIRNAME ?>akademik/hapus_kelas/${id_kelas}`;
            }
        })
    }

    function handleEditPilihDosenKoor(el) {
        const val = el.value;
        const pendamping = document.getElementById('edit_kelas_pendamping');
        for(let i=0; i<pendamping.options.length; i++) {
            if(pendamping.options[i].value !== '') {
                if(pendamping.options[i].value === val && val !== "") {
                    pendamping.options[i].disabled = true;
                    // Jika terlanjur terpilih, reset pendamping
                    if(pendamping.value === val) pendamping.value = "";
                } else {
                    pendamping.options[i].disabled = false;
                }
            }
        }
    }
    
    function handleEditPilihDosenPendamping(el) {
        const val = el.value;
        const koor = document.getElementById('edit_kelas_koor');
        for(let i=0; i<koor.options.length; i++) {
            if(koor.options[i].value !== '') {
                if(koor.options[i].value === val && val !== "") {
                    koor.options[i].disabled = true;
                } else {
                    koor.options[i].disabled = false;
                }
            }
        }
    }
</script>
