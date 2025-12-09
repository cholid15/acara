function showDetail(id) {
    // tampilkan dulu modal + loading
    document.getElementById("modalDetail").classList.remove("hidden");
    document.getElementById("modalBody").innerHTML =
        "<div class='text-center py-6'>Loading...</div>";

    fetch(`/admin/acara/detail/${id}`)
        .then((res) => res.json())
        .then((res) => {
            if (!res.success) return;

            let acara = res.data;

            let html = `
            <div class="space-y-4">

                <div>
                    <h4 class="font-bold text-lg">${acara.nama_acara}</h4>
                    <p class="text-sm text-gray-500">${acara.tanggal_waktu}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><b>Lokasi:</b> ${acara.lokasi}</div>
                    <div><b>Tipe Audiens:</b> ${acara.tipe_audiens}</div>
                    <div><b>Status:</b> ${acara.status}</div>
                    <div><b>QR Token:</b> ${acara.qr_token}</div>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-lg text-center">
                    <h4 class="font-semibold mb-3">QR Code</h4>
            `;

            // ==============================
            // FIX PENENTUAN URL QR IMAGE
            // ==============================
            if (acara.qr_image_url) {
                // convert ke URL absolut
                let fullUrl = acara.qr_image_url.startsWith("http")
                    ? acara.qr_image_url
                    : window.location.origin +
                      "/" +
                      acara.qr_image_url.replace(/^\/+/, "");

                html += `
                    <img src="${fullUrl}" alt="QR Code"
                         class="w-48 h-48 mx-auto border border-gray-300 rounded" />
                `;
            } else {
                html += `
                <div class="p-6 bg-yellow-50 border border-yellow-200 rounded text-yellow-700 text-sm">
                    <p>⚠️ Tidak ada QR Code</p>
                </div>`;
            }

            html += `
            </div>
            `;

            // Jika tipe khusus → tampilkan undangan
            if (acara.tipe_audiens === "KHUSUS") {
                html += `
                        <div class="mt-6">
                            <h4 class="font-semibold mb-2">Daftar Undangan</h4>
                            <table class="w-full text-sm border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="p-2 border">Nama Pegawai</th>
                                        <th class="p-2 border">Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                            `;

                acara.undangan.forEach((u) => {
                    html += `
                            <tr>
                                <td class="p-2 border">${
                                    u.pegawai?.orang?.nama ?? "-"
                                }</td>
                                <td class="p-2 border">${
                                    u.pegawai?.unit?.nama ?? "-"
                                }</td>
                            </tr>
                            `;
                });

                html += `
                                </tbody>
                            </table>
                        </div>
                        `;
            }

            html += `</div>`;

            document.getElementById("modalBody").innerHTML = html;
        });
}

function closeDetail() {
    document.getElementById("modalDetail").classList.add("hidden");
}

function openEdit(id) {
    // buka modal
    document.getElementById("modalEdit").classList.remove("hidden");

    // tampilkan loading dikit
    document.getElementById("edit_nama_acara").value = "Loading...";
    document.getElementById("edit_lokasi").value = "Loading...";

    fetch(`/admin/acara/edit/${id}`)
        .then((res) => res.json())
        .then((res) => {
            let acara = res.acara;
            let pegawai = res.pegawai;

            // isi form
            document.getElementById("edit_id").value = acara.id;
            document.getElementById("edit_nama_acara").value = acara.nama_acara;
            document.getElementById("edit_lokasi").value = acara.lokasi;

            // select pegawai
            let select = document.getElementById("edit_pegawai");
            select.innerHTML = "";

            pegawai.forEach((p) => {
                let option = document.createElement("option");
                option.value = p.id;
                option.text = `${p.orang?.nama ?? ""} - ${p.unit?.nama ?? ""}`;
                select.appendChild(option);
            });

            // kalau audiens KHUSUS → tampilkan Selectize
            if (acara.tipe_audiens === "KHUSUS") {
                document
                    .getElementById("edit_pegawai_wrapper")
                    .classList.remove("hidden");

                let selectedIDs = acara.undangan.map((u) => u.id_pegawai);

                // harus reset dulu
                if ($("#edit_pegawai")[0].selectize) {
                    $("#edit_pegawai")[0].selectize.destroy();
                }

                $("#edit_pegawai").selectize({
                    plugins: ["remove_button"],
                    persist: false,
                    create: false,
                });

                let sel = $("#edit_pegawai")[0].selectize;
                sel.setValue(selectedIDs);
            }
        });
}

// Submit update
document.getElementById("formEdit").addEventListener("submit", function (e) {
    e.preventDefault();

    let id = document.getElementById("edit_id").value;
    let data = new FormData();

    data.append("nama_acara", document.getElementById("edit_nama_acara").value);
    data.append("lokasi", document.getElementById("edit_lokasi").value);
    data.append("status", document.getElementById("edit_status").value);

    let pegawaiSelectize = $("#edit_pegawai")[0]?.selectize;
    if (pegawaiSelectize) {
        let values = pegawaiSelectize.getValue();
        values.forEach((v) => data.append("pegawai[]", v));
    }

    fetch(`/admin/acara/update/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: data,
    })
        .then((res) => res.json())
        .then((res) => {
            // ❌ gagal
            if (!res.success) {
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text:
                        res.message ?? "Terjadi kesalahan saat menyimpan data.",
                    confirmButtonColor: "#d33",
                });
                return;
            }

            // ✅ berhasil
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Data acara berhasil diperbarui.",
                timer: 1500,
                showConfirmButton: false,
            }).then(() => {
                closeEdit(); // tutup modal
                location.reload(); // reload halaman
            });
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Tidak dapat terhubung ke server.",
                confirmButtonColor: "#d33",
            });
        });
});

function closeEdit() {
    document.getElementById("modalEdit").classList.add("hidden");
}

// Pastikan SweetAlert2 sudah tersedia (kamu sudah load file sweetalert2.min.js)
// Fungsi openQr(id) -> fetch detail and show QR modal
function openQr(id) {
    // show modal + loading
    document.getElementById("modalQr").classList.remove("hidden");
    document.getElementById("modalQrLoading").classList.remove("hidden");
    document.getElementById("modalQrContent").classList.add("hidden");
    document.getElementById("modalQrImage").src = "";

    fetch(`/admin/acara/detail/${id}`)
        .then((r) => r.json())
        .then((res) => {
            if (!res.success) {
                document.getElementById("modalQrLoading").innerHTML =
                    "<div class='text-yellow-600'>Data tidak ditemukan</div>";
                return;
            }

            const acara = res.data;
            const qrUrl = acara.qr_image_url; // controller harus mengirim absolute URL (see earlier)
            if (!qrUrl) {
                document.getElementById("modalQrLoading").innerHTML =
                    "<div class='text-yellow-600'>⚠️ Tidak ada QR Code</div>";
                return;
            }

            // set image src dan download link
            const img = document.getElementById("modalQrImage");
            img.src = qrUrl;
            img.onload = function () {
                document
                    .getElementById("modalQrLoading")
                    .classList.add("hidden");
                document
                    .getElementById("modalQrContent")
                    .classList.remove("hidden");
            };
            img.onerror = function () {
                document.getElementById("modalQrLoading").innerHTML =
                    "<div class='text-red-600'>Gagal memuat gambar</div>";
            };

            // set download link
            const downloadLink = document.getElementById("modalQrDownload");
            // buat nama file yang ramah
            const filename = (acara.qr_token ? acara.qr_token : "qr") + ".png";
            downloadLink.href = qrUrl;
            downloadLink.setAttribute("download", filename);
        })
        .catch((err) => {
            document.getElementById("modalQrLoading").innerHTML =
                "<div class='text-red-600'>Terjadi kesalahan</div>";
            console.error(err);
        });
}

function closeQr() {
    document.getElementById("modalQr").classList.add("hidden");
    document.getElementById("modalQrLoading").classList.remove("hidden");
    document.getElementById("modalQrContent").classList.add("hidden");
    document.getElementById("modalQrImage").src = "";
}

// ===== Delete with SweetAlert and AJAX =====
function deleteWithConfirm(id) {
    // tampilkan konfirmasi
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data acara dan QR akan dihapus permanen.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Batal",
        confirmButtonColor: "#d33",
    }).then((result) => {
        if (!result.isConfirmed) return;

        // kirim request DELETE ke server
        fetch(`/admin/acara/${id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                Accept: "application/json",
            },
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Terhapus",
                        text: data.message ?? "Acara berhasil dihapus",
                        timer: 1200,
                        showConfirmButton: false,
                    }).then(() => {
                        // opsi: reload halaman atau hapus baris tabel via DOM
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: data.message ?? "Gagal menghapus acara",
                    });
                }
            })
            .catch((err) => {
                console.error(err);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Terjadi kesalahan koneksi",
                });
            });
    });
}
