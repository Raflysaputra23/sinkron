<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
    <div class="container mx-auto px-6 py-8">
        
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Sinkronisasi & Backup</h1>
            <p class="text-sm text-gray-500 mt-1">Silakan pilih metode pencadangan berkala untuk database sistem Anda.</p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <div class="xl:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <form action="<?= CONSTANT::DIRNAME; ?>backup/proses" method="POST">
                        
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-3">Pilih Mode Pencadangan:</label>
                            
                            <label for="manual" class="block p-4 mb-3 border border-gray-200 rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-teal-500 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="mode_backup" id="manual" value="manual" <?= ($data['config']['mode'] ?? 'manual') == 'manual' ? 'checked' : ''; ?> class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                    </div>
                                    <div class="ms-3 text-sm">
                                        <span class="block font-bold text-gray-800">📦 Manual Backup (Sekarang)</span>
                                        <span class="block text-gray-500 text-xs mt-0.5">Sistem langsung melakukan sinkronisasi dump data ke file format .sql saat ini juga.</span>
                                    </div>
                                </div>
                            </label>
                            
                            <label for="otomatis" class="block p-4 border border-gray-200 rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 hover:border-teal-500 transition duration-200">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="radio" name="mode_backup" id="otomatis" value="otomatis" <?= ($data['config']['mode'] ?? '') == 'otomatis' ? 'checked' : ''; ?> class="h-4 w-4 text-teal-600 border-gray-300 focus:ring-teal-500">
                                    </div>
                                    <div class="ms-3 text-sm">
                                        <span class="block font-bold text-gray-800">⏳ Otomatis (Berdasarkan Waktu)</span>
                                        <span class="block text-gray-500 text-xs mt-0.5">Sistem akan melakukan penjadwalan backup otomatis di background berdasarkan rentang waktu yang dipilih.</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="input-interval" class="<?= ($data['config']['mode'] ?? '') == 'otomatis' ? '' : 'hidden opacity-0'; ?> mb-6 transition-all duration-300 transform">
                            <label for="interval" class="block text-gray-700 font-semibold mb-2">Pilih Interval Waktu:</label>
                            <select name="interval" id="interval" class="w-full bg-white border border-gray-300 text-gray-700 py-2.5 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-sm">
                                <option value="setiap_jam" <?= ($data['config']['interval_waktu'] ?? '') == 'setiap_jam' ? 'selected' : ''; ?>>⏰ Setiap Jam</option>
                                <option value="harian" <?= ($data['config']['interval_waktu'] ?? 'harian') == 'harian' ? 'selected' : ''; ?>>📅 Setiap Hari (Tengah Malam)</option>
                                <option value="mingguan" <?= ($data['config']['interval_waktu'] ?? '') == 'mingguan' ? 'selected' : ''; ?>>📆 Setiap Minggu</option>
                                <option value="bulanan" <?= ($data['config']['interval_waktu'] ?? '') == 'bulanan' ? 'selected' : ''; ?>>🗓️ Setiap Bulan</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-black font-semibold px-5 py-2.5 rounded-lg shadow-sm transition duration-200 text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                Simpan & Jalankan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

            <div class="xl:col-span-1">
                <div class="bg-teal-50 border border-teal-100 rounded-xl p-5 text-teal-900">
                    <h5 class="font-bold flex items-center mb-2">
                        <i class="ph ph-info text-lg me-2"></i>
                        Informasi Sistem
                    </h5>
                    <p class="text-xs leading-relaxed opacity-90">
                        File hasil backup manual akan langsung diekspor ke dalam folder direktori proyek Anda pada jalur: <br>
                        <code class="bg-white/70 px-1 py-0.5 rounded text-teal-950 font-mono block mt-1 break-all">/public/backups/</code>
                    </p>
                </div>
            </div>

        </div> </div> </main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radioManual = document.getElementById('manual');
        const radioOtomatis = document.getElementById('otomatis');
        const divInterval = document.getElementById('input-interval');

        function toggleInterval() {
            if (radioOtomatis.checked) {
                divInterval.classList.remove('hidden');
                setTimeout(function() {
                    divInterval.classList.remove('opacity-0');
                }, 50);
            } else {
                divInterval.classList.add('opacity-0');
                setTimeout(function() {
                    divInterval.classList.add('hidden');
                }, 300);
            }
        }

        radioManual.addEventListener('change', toggleInterval);
        radioOtomatis.addEventListener('change', toggleInterval);
    });
</script>