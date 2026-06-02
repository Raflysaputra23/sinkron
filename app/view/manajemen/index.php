<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
<?php if(isset($_SESSION["role"]) && $_SESSION["role"] == "admin"): ?>
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Data Akademik</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pembuatan referensi kelas dan mata kuliah baru.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Form Tambah Mata Kuliah -->
            <div class="order-2 bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden h-fit">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2"><i class="ph ph-books text-brand-600"></i> Form Tambah Mata Kuliah</h2>
                </div>
                <div class="p-6">
                    <form action="<?= CONSTANT::DIRNAME ?>manajemen/tambah_mk" method="POST" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Kuliah</label>
                            <input type="text" name="nama_mk" placeholder="Contoh: Pemrograman Web" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bobot SKS</label>
                            <input type="number" name="sks" min="1" max="6" placeholder="Contoh: 3" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow">
                        </div>
                        <div class="pt-4">
                            <button  type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg transition-colors cursor-pointer flex justify-center items-center gap-2 shadow-sm">
                                <i class="ph ph-check-circle text-lg"></i> Simpan Mata Kuliah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Tambah Kelas -->
            <div class="order-1 bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2"><i class="ph ph-chalkboard-teacher text-purple-600"></i> Form Tambah Kelas</h2>
                </div>
                <div class="p-6">
                    <form action="<?= CONSTANT::DIRNAME ?>manajemen/tambah_kelas" method="POST" class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Kelas</label>
                                <input type="text" name="id_kelas" placeholder="A" class="w-full uppercase bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Pilih Mata Kuliah</label>
                                <select name="id_mk" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                    <option value="">Pilih Mata Kuliah</option>
                                    <?php foreach($data['mk'] as $mk) : ?>
                                        <option value="<?= $mk['id_mk'] ?>"><?= $mk['id_mk'] ?> - <?= $mk['nama_mk'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Dosen Koordinator</label>
                                <select name="id_dosen_koor" onchange="handlePilihDosen(this)" data-dosen='<?= json_encode($data['dosen']) ?>' class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                    <option value="">Pilih Dosen</option>
                                    <?php foreach($data['dosen'] as $dosen) : ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nip'] ?> - <?= $dosen['nama_lengkap'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Dosen Pendamping <span class="text-xs text-gray-500">(Opsional)</span></label>
                                <select id="dosen-pendamping" name="id_dosen_pendamping" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                    <option value="">Dosen Pendamping</option>
                                    <?php foreach($data['dosen'] as $dosen) : ?>
                                        <option value="<?= $dosen['nip'] ?>"><?= $dosen['nip'] ?> - <?= $dosen['nama_lengkap'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                                <select name="hari" class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                    <option value="0">Senin</option><option value="1">Selasa</option><option value="2">Rabu</option><option value="3">Kamis</option><option value="4">Jumat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="w-full bg-white border border-gray-300 rounded-lg px-2 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ruangan</label>
                                <input type="text" name="ruangan" placeholder="Gedung C - Lt 2" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Mahasiswa</label>
                                <input type="number" min="1" name="kuota" placeholder="Maksimal Kapasitas" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow">
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-bold py-2.5 rounded-lg transition-colors cursor-pointer flex justify-center items-center gap-2 shadow-sm">
                                <i class="ph ph-check-circle text-lg"></i> Simpan Kelas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Plotting Dosen Pembimbing -->
            <div class="order-3 bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden h-fit">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2"><i class="ph ph-users-three text-blue-600"></i> Plotting Dosen Pembimbing</h2>
                </div>
                <div class="p-6">
                    <form action="<?= CONSTANT::DIRNAME ?>manajemen/tambah_pembimbing" method="POST" class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Pilih Mahasiswa</label>
                            <select name="nim" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                <option value="">-- Mahasiswa Tanpa Pembimbing --</option>
                                <?php if(empty($data['mahasiswa_no_pembimbing'])): ?>
                                    <option value="" disabled>Semua mahasiswa sudah memiliki pembimbing</option>
                                <?php else: ?>
                                    <?php foreach($data['mahasiswa_no_pembimbing'] as $mhs) : ?>
                                        <option value="<?= $mhs['nim'] ?>"><?= $mhs['nim'] ?> - <?= $mhs['nama_lengkap'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1 required-input">Pilih Dosen Pembimbing</label>
                            <select name="nip_pembimbing" required class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-brand-500 focus:border-brand-500 outline-none transition-shadow cursor-pointer">
                                <option value="">-- Pilih Dosen --</option>
                                <?php foreach($data['dosen'] as $dosen) : ?>
                                    <option value="<?= $dosen['nip'] ?>"><?= $dosen['nip'] ?> - <?= $dosen['nama_lengkap'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="pt-4">
                            <button type="submit" <?= empty($data['mahasiswa_no_pembimbing']) ? 'disabled' : '' ?> class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition-colors cursor-pointer flex justify-center items-center gap-2 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="ph ph-user-plus text-lg"></i> Simpan Pembimbing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="flex items-center justify-center h-full">
        <div class="text-center">
            <i class="ph ph-lock-key text-6xl text-red-500 mb-4 inline-block"></i>
            <h2 class="text-2xl font-bold text-gray-800">Akses Ditolak</h2>
            <p class="text-gray-500 mt-2">Halaman ini hanya dapat diakses oleh Administrator Sistem.</p>
        </div>
    </div>
<?php endif; ?>
</main>

<script>
    const handlePilihDosen = (el) => {
        const dataDosen = el.dataset.dosen ? JSON.parse(el.dataset.dosen) : [];
        console.log(dataDosen);
        const selectNip = el.value;
        const selectPendamping = document.getElementById('dosen-pendamping');

        selectPendamping.innerHTML = '<option value="">Pilih Dosen</option>';

        dataDosen.forEach(dosen => {
            if(dosen.nip !== selectNip) {
                const option = document.createElement('option');
                option.value = dosen.nip;
                option.textContent = dosen.nip + ' - ' + dosen.nama_lengkap;
                selectPendamping.appendChild(option);
            }
        });
    }
</script>
