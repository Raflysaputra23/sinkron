<div class="flex min-h-dvh justify-center items-center py-4 px-6 bg-linear-to-br from-brand-50 to-brand-100">
    <div
        class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl">
        <div>
            <div
                class="mx-auto h-20 w-20 bg-brand-600 rounded-full flex items-center justify-center shadow-lg transform transition hover:scale-110 duration-300">
                <i class="ph ph-user-plus text-4xl text-white"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 tracking-tight">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-500">
                Daftar untuk mengakses SIAKRS
            </p>
        </div>
        <form class="mt-8 space-y-6" action="<?= CONSTANT::DIRNAME ?>register/register" method="POST">
            <div class="space-y-4">
                <div id="input-nama">
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-identification-card text-gray-400 text-xl"></i>
                        </div>
                        <input id="nama" name="nama_lengkap" type="text"
                            class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200"
                            placeholder="Nama Lengkap">
                    </div>
                </div>
                <div id="input-nim">
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Mahasiswa / Dosen
                        (NIM/NIP)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-user text-gray-400 text-xl"></i>
                        </div>
                        <input id="nim" name="username" type="text"
                            class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200"
                            placeholder="Masukkan NIM/NIP Anda" required>
                    </div>
                </div>
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-users text-gray-400 text-xl"></i>
                        </div>
                        <select name="role" id="role" onchange="handleSelect(this)" class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-xl"></i>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200"
                            placeholder="••••••••">
                    </div>
                </div>
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                        Password</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-lock-key text-gray-400 text-xl"></i>
                        </div>
                        <input id="password_confirm" name="password2" type="password" required
                            class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative cursor-pointer w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-0.5">
                    <i
                        class="order-2 ph ph-user-plus text-brand-300 group-hover:text-white transition ease-in-out duration-300 text-xl"></i>
                    <span class="order-1">Daftar Sekarang</span>
                </button>
            </div>

            <div class="text-sm text-center mt-4">
                <span class="text-gray-600">Sudah punya akun?</span>
                <a href="<?= CONSTANT::DIRNAME ?>login"
                    class="font-medium text-brand-600 hover:text-brand-500 transition duration-200 ml-1">
                    Masuk di sini
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const handleSelect = (el) => {
        const value = el.value;
        const inputNama = document.getElementById('input-nama');
        if(value == 'admin') {
            inputNama.classList.add('hidden');
        } else {
            inputNama.classList.remove('hidden');
        }
    }
</script>