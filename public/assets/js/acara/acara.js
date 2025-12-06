$(document).ready(function () {
    // INIT SELECTIZE
    let pegawaiSelect = $("#pegawaiSelect").selectize({
        plugins: ["remove_button"],
        placeholder: "Pilih pegawai...",
    });
    let pegawaiControl = pegawaiSelect[0].selectize;

    // Tampilkan bagian sesuai tipe audiens
    $("#tipe_audiens").on("change", function () {
        let val = $(this).val();

        $("#section_unit").addClass("hidden");
        $("#section_pegawai").addClass("hidden");

        if (val === "PER_UNIT") {
            $("#section_unit").removeClass("hidden");
        } else if (val === "KHUSUS") {
            $("#section_pegawai").removeClass("hidden");
        }
    });

    // AJAX → Load pegawai by unit
    $("#unitSelect").on("change", function () {
        let unitId = $(this).val();
        if (!unitId) return;

        $.get("/admin/acara/get-pegawai-by-unit/" + unitId, function (res) {
            pegawaiControl.clear();
            pegawaiControl.clearOptions();

            res.forEach(function (item) {
                pegawaiControl.addOption({
                    value: item.value,
                    text: item.text,
                });
            });

            pegawaiControl.refreshOptions();
        });
    });

    // ================================================
    // FORM SUBMIT AJAX + SWEETALERT LOADING 1 DETIK
    // ================================================
    $("#formAcara").on("submit", function (e) {
        e.preventDefault();
        e.stopImmediatePropagation(); // ✅ TAMBAHAN: Stop event bubbling

        // Disable tombol submit untuk mencegah double click
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop("disabled", true);

        let formData = $(this).serialize();

        // SWEETALERT LOADING SPINNER
        Swal.fire({
            title: "Menyimpan...",
            text: "Mohon tunggu sebentar",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            timer: 1000,
        }).then(() => {
            // Setelah 1 detik → Jalankan AJAX
            $.ajax({
                url: "/admin/acara/store",
                type: "POST",
                data: formData,
                success: function () {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Acara berhasil dibuat.",
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = "/admin/acara/create";
                    });
                },
                error: function (xhr) {
                    // Re-enable button jika error
                    submitBtn.prop("disabled", false);

                    // VALIDASI 422
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let msg = "";
                        Object.keys(errors).forEach((key) => {
                            msg += errors[key][0] + "<br>";
                        });
                        Swal.fire({
                            icon: "error",
                            title: "Validasi Gagal!",
                            html: msg,
                        });
                        return;
                    }
                    // ERROR SERVER
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: "Terjadi kesalahan, coba lagi.",
                    });
                },
            });
        });

        return false; // ✅ TAMBAHAN: Extra protection
    });
});
