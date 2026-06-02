<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8 flex flex-col justify-between items-start gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Simulasi Deadlock</h1>
                <p class="text-sm text-gray-500 mt-1">Uji sistem ketika dua mahasiswa mengambil kelas yang sama secara
                    bersamaan.</p>
            </div>

            <button onclick="startDeadlockSimulation()" id="btnSimulasi"
                class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-lg font-bold flex items-center gap-2 transition-colors cursor-pointer text-sm shadow-sm">
                <i class="ph ph-lightning block"></i> Simulasikan Transaksi Deadlock
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- User A -->
            <div
                class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-blue-50/50 flex justify-between items-center">
                    <div class="w-full">
                        <label class="text-xs font-bold text-blue-700 uppercase tracking-wider mb-1 block"><i
                                class="ph ph-user text-sm"></i> Simulasi Mahasiswa A</label>
                        <select id="selectUserA" onchange="syncDropdowns()"
                            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Mahasiswa --</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto max-h-[300px]">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-6 py-3 text-left w-12"><input type="checkbox"
                                        onchange="toggleAll('userA', this)"
                                        class="rounded w-4 h-4 border-gray-300 text-brand-600 focus:ring-brand-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode Kelas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata
                                    Kuliah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100" id="listUserA">
                            <tr class="text-center text-gray-500">
                                <td colspan="3" class="py-4">Silakan pilih mahasiswa terlebih dahulu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">Pilih beberapa kelas. Array
                    data akan dilemparkan ke Backend.</div>
            </div>

            <!-- User B -->
            <div
                class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden">
                <div class="p-4 border-b border-gray-100 bg-orange-50/50 flex justify-between items-center">
                    <div class="w-full">
                        <label class="text-xs font-bold text-orange-700 uppercase tracking-wider mb-1 block"><i
                                class="ph ph-user text-sm"></i> Simulasi Mahasiswa B</label>
                        <select id="selectUserB" onchange="syncDropdowns()"
                            class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="">-- Pilih Mahasiswa --</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto max-h-[300px]">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th class="px-6 py-3 text-left w-12"><input type="checkbox"
                                        onchange="toggleAll('userB', this)"
                                        class="rounded w-4 h-4 border-gray-300 text-orange-600 focus:ring-orange-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kode Kelas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata
                                    Kuliah</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100" id="listUserB">
                            <tr class="text-center text-gray-500">
                                <td colspan="3" class="py-4">Silakan pilih mahasiswa terlebih dahulu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500">Pilih kelas yang sama dengan
                    urutan terbaik agar bisa intervensi antar transaksi DB.</div>
            </div>
        </div>

        <div
            class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden font-mono flex flex-col h-[400px]">
            <div class="bg-gray-800 px-4 py-3 flex items-center justify-between border-b border-gray-700">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                    <div class="ml-2 text-xs text-gray-400 font-semibold tracking-wider">TERMINAL LOG REAL-TIME</div>
                </div>
            </div>
            <div class="p-5 overflow-y-auto flex-1 space-y-2.5 text-[13px] leading-relaxed relative" id="terminalLog">
                <div class="text-gray-500">Belum ada proses simulasi...</div>
            </div>
        </div>
    </div>
</main>

<?php $mahasiswaJSON = json_encode($data['mahasiswa']); ?>
<script>
    const allMahasiswa = <?= $mahasiswaJSON ?>;


    document.addEventListener("DOMContentLoaded", () => {
        populateDropdowns();
    });

    function populateDropdowns() {
        const selectA = document.getElementById('selectUserA');
        const selectB = document.getElementById('selectUserB');

        allMahasiswa.forEach(mhs => {
            selectA.add(new Option(mhs.nama_lengkap + ' (' + mhs.nim + ')', mhs.nim));
            selectB.add(new Option(mhs.nama_lengkap + ' (' + mhs.nim + ')', mhs.nim));
        });
    }

    async function syncDropdowns() {
        const selectA = document.getElementById('selectUserA');
        const selectB = document.getElementById('selectUserB');

        const valA = selectA.value;
        const valB = selectB.value;

     
        Array.from(selectA.options).forEach(opt => {
            if (opt.value !== "") {
                opt.disabled = (opt.value === valB);
            }
        });

        Array.from(selectB.options).forEach(opt => {
            if (opt.value !== "") {
                opt.disabled = (opt.value === valA);
            }
        });

        // Fetch classes untuk A
        const listA = document.getElementById('listUserA');
        if (valA) {
            const krsDataA = await fetchClasses(valA);
            renderTable(listA, krsDataA, 'A');
        } else {
            listA.innerHTML = '<tr class="text-center text-gray-500"><td colspan="3" class="py-4">Silakan pilih mahasiswa terlebih dahulu</td></tr>';
        }

        const listB = document.getElementById('listUserB');
        if (valB) {
            const krsDataB = await fetchClasses(valB);
            renderTable(listB, krsDataB, 'B');
        } else {
            listB.innerHTML = '<tr class="text-center text-gray-500"><td colspan="3" class="py-4">Silakan pilih mahasiswa terlebih dahulu</td></tr>';
        }
    }

    async function fetchClasses(nim) {
        try {
            const res = await fetch(`<?= CONSTANT::DIRNAME ?>krs/search`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ search: '', id_user: nim })
            });
            return await res.json();
        } catch (e) {
            console.error(e);
            return [];
        }
    }

    function renderTable(tbody, data, slot) {
        if (!data || data.length === 0) {
            tbody.innerHTML = '<tr class="text-center text-gray-500"><td colspan="3" class="py-4">Tidak ada data kelas tersedia</td></tr>';
            return;
        }

        let html = '';
        data.forEach(krs => {
            let color = slot === 'A' ? 'brand' : 'orange';
            let bgHover = slot === 'A' ? 'blue' : 'orange';

            let disabledAttr = krs.status !== 'belum diambil' ? 'disabled' : '';
            let statusBadge = krs.status !== 'belum diambil' ? `<span class="bg-red-100 text-red-600 px-2 py-0.5 rounded text-xs ml-2">${krs.status}</span>` : '';

            html += `
            <tr class="hover:bg-${bgHover}-50/50 transition-colors ${disabledAttr === '' ? 'cursor-pointer' : 'opacity-70 cursor-not-allowed'}" 
                ${disabledAttr === '' ? `onclick="toggleCheckbox('checkbox${slot}_${krs.id_kelas}')"` : ''}>
                <td class="px-6 py-3">
                    <input type="checkbox" ${disabledAttr} id="checkbox${slot}_${krs.id_kelas}" value="${krs.id_kelas}" class="user${slot}-cb rounded w-4 h-4 border-gray-300 text-${color}-600 focus:ring-${color}-500" onclick="event.stopPropagation()">
                </td>
                <td class="px-6 py-3 text-sm font-bold text-gray-900">${krs.id_kelas}</td>
                <td class="px-6 py-3 text-sm text-gray-700">${krs.nama_mk} ${statusBadge}</td>
            </tr>`;
        });
        tbody.innerHTML = html;
    }

    function toggleCheckbox(id) {
        const el = document.getElementById(id);
        el.checked = !el.checked;
    }
    function toggleAll(userClassName, masterCheckbox) {
        const checkboxes = document.querySelectorAll('.' + userClassName + '-cb');
        checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
    }

    function appendLog(data) {
        const term = document.getElementById('terminalLog');
        const line = document.createElement('div');

        let colorClass = 'text-gray-300';
        if (data.type === 'info') colorClass = 'text-blue-400';
        if (data.type === 'success') colorClass = 'text-green-400';
        if (data.type === 'warning') colorClass = 'text-yellow-400';
        if (data.type === 'error') colorClass = 'text-red-400 font-bold';

        let userBadge = '';
        if (data.userSlot === 'A') {
            const shortName = data.userName ? data.userName.split(' ')[0] : 'USER A';
            userBadge = `<span class="bg-blue-900/50 border border-blue-800 text-blue-300 px-1.5 py-0.5 rounded text-xs mr-2 relative -top-px whitespace-nowrap overflow-hidden text-ellipsis max-w-[100px] inline-block align-bottom" title="${data.userName}">${shortName}</span>`;
        }
        if (data.userSlot === 'B') {
            const shortName = data.userName ? data.userName.split(' ')[0] : 'USER B';
            userBadge = `<span class="bg-orange-900/50 border border-orange-800 text-orange-300 px-1.5 py-0.5 rounded text-xs mr-2 relative -top-px whitespace-nowrap overflow-hidden text-ellipsis max-w-[100px] inline-block align-bottom" title="${data.userName}">${shortName}</span>`;
        }
        if (data.userSlot === '-') {
            userBadge = '<span class="bg-gray-800 border border-gray-700 text-gray-400 px-1.5 py-0.5 rounded text-xs mr-2 relative -top-px">SYSTEM</span>';
        }

        line.innerHTML = `<span class="text-gray-500 mr-2">[${data.time}]</span> ${userBadge} <span class="${colorClass}">${data.message}</span>`;
        if (data.type === 'error') {
            line.classList.add('bg-red-900/20', 'py-1', 'px-2', '-mx-2', 'rounded');
        }

        term.appendChild(line);
        term.scrollTop = term.scrollHeight;
    }

    async function startStream(userSlot, userNim, userName, classes) {
        try {
            const response = await fetch(`<?= CONSTANT::DIRNAME ?>log/streamDeadlock`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ userSlot, userNim, userName, classes })
            });

            const reader = response.body.getReader();
            const decoder = new TextDecoder("utf-8");

            while (true) {
                const { value, done } = await reader.read();
                if (done) break;

                const chunk = decoder.decode(value, { stream: true });
                const lines = chunk.split('\n');
                for (let line of lines) {
                    if (line.trim().length > 0) {
                        try {
                            const data = JSON.parse(line.trim());
                            appendLog(data);
                        } catch (e) {
                            console.error("JSON parse error:", line);
                        }
                    }
                }
            }
        } catch (error) {
            appendLog({ time: new Date().toLocaleTimeString('id-ID', { hour12: false }), userSlot, userName, type: 'error', message: 'Koneksi terputus: ' + error.message });
        }
    }

    function startDeadlockSimulation() {
        const btn = document.getElementById('btnSimulasi');

        const selectA = document.getElementById('selectUserA');
        const selectB = document.getElementById('selectUserB');

        const classesA = Array.from(document.querySelectorAll('.userA-cb:checked')).map(cb => cb.value);
        const classesB = Array.from(document.querySelectorAll('.userB-cb:checked')).map(cb => cb.value);

        if (classesA.length > 0 && !selectA.value) {
            flasher("info","Pilih mahasiswa untuk Slot A!");
            return;
        }
        if (classesB.length > 0 && !selectB.value) {
            flasher("info","Pilih mahasiswa untuk Slot B!");
            return;
        }

        if (classesA.length === 0 && classesB.length === 0) {
            flasher("info","Pilih minimal 1 kelas untuk salah satu user.");
            return;
        }

        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');

        const terminalLog = document.getElementById('terminalLog');
        terminalLog.innerHTML = `<div class="text-gray-500 mb-2">~ Memulai simulasi transaksi serentak database pada ${new Date().toLocaleTimeString('id-ID', { hour12: false })}</div>`;

        const promises = [];
        if (classesA.length > 0) {
            const nameA = selectA.options[selectA.selectedIndex].text.split(' (')[0];
            promises.push(startStream('A', selectA.value, nameA, classesA));
        }
        if (classesB.length > 0) {
            const nameB = selectB.options[selectB.selectedIndex].text.split(' (')[0];
            promises.push(startStream('B', selectB.value, nameB, classesB));
        }

        Promise.all(promises).then(() => {
            appendLog({ time: new Date().toLocaleTimeString('id-ID', { hour12: false }), userSlot: '-', type: 'info', message: 'Mekanisme simulasi deadlock selesai.' });
            flasher("success","Simulasi deadlock selesai.")
        }).catch((e) => {
            appendLog({ time: new Date().toLocaleTimeString('id-ID', { hour12: false }), userSlot: '-', type: 'error', message: 'Mekanisme terkendala: ' + e });
            flasher("error","Simulasi deadlock gagal.")
        }).finally(() => {
            btn.disabled = false;
            btn.classList.remove('opacity-50', 'cursor-not-allowed');
        });
    }

    const flasher = (type, pesan) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: type,
            title: pesan
        });
    }
</script>