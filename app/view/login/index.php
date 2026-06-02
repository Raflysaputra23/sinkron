<div
    class="flex min-h-dvh overflow-y-auto items-center justify-center py-4 px-6 bg-linear-to-br from-brand-50 to-brand-100">
    <div
        class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl">
        <div>
            <div
                class="mx-auto h-20 w-20 bg-brand-600 rounded-full flex items-center justify-center shadow-lg transform transition hover:scale-110 duration-300">
                <i class="ph ph-graduation-cap text-4xl text-white"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 tracking-tight">
                Portal Mahasiswa
            </h2>
            <p class="mt-2 text-center text-sm text-gray-500">
                Sistem Informasi KRS Terpadu (SIAKRS)
            </p>
        </div>
        <form class="mt-8 space-y-6" action="<?= CONSTANT::DIRNAME ?>login/login" method="POST">
            <div class="space-y-5">
                <div>
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Mahasiswa/Dosen
                        (NIM/NIP)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ph ph-user text-gray-400 text-xl"></i>
                        </div>
                        <input id="nim" name="username" type="text" required
                            class="appearance-none rounded-lg block w-full px-3 py-3 pl-11 border border-gray-300 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-200"
                            placeholder="Masukkan NIM Anda">
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
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox"
                        class="h-4 w-4 text-brand-600 focus:ring-brand-500 border-gray-300 rounded cursor-pointer transition duration-200">
                    <label for="remember-me" class="ml-2 block text-sm text-gray-700 cursor-pointer">
                        Ingat sesi saya
                    </label>
                </div>

                <div class="text-sm">
                    <a href="#" class="font-medium text-brand-600 hover:text-brand-500 transition duration-200">
                        Lupa password?
                    </a>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative cursor-pointer w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-brand-600 hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-all duration-300 shadow hover:shadow-lg transform hover:-translate-y-0.5">
                    <i
                        class="order-2 ph ph-sign-in text-brand-300 group-hover:text-white transition ease-in-out duration-300 text-xl"></i>
                    <span class="order-1">Masuk ke Dashboard</span>
                </button>
            </div>

            <div class="text-sm text-center mt-4">
                <span class="text-gray-600">Belum punya akun?</span>
                <a href="<?= CONSTANT::DIRNAME ?>register"
                    class="font-medium text-brand-600 hover:text-brand-500 transition duration-200 ml-1">
                    Daftar di sini
                </a>
            </div>
        </form>
    </div>
</div>