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
        e.stopImmediatePropagation();

        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop("disabled", true);

        let formData = $(this).serialize();

        // Mulai timer 1 detik
        let startTime = Date.now();

        Swal.fire({
            title: "Menyimpan...",
            text: "Mohon tunggu sebentar",
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        // Jalankan AJAX SEGERA
        $.ajax({
            url: "/admin/acara/store",
            type: "POST",
            data: formData,
            success: function () {
                // Hitung sisa waktu agar total minimal 1 detik
                let elapsed = Date.now() - startTime;
                let remaining = Math.max(0, 1000 - elapsed);

                setTimeout(() => {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: "Acara berhasil dibuat.",
                        timer: 2000,
                        showConfirmButton: false,
                    }).then(() => {
                        window.location.href = "/admin/acara/create";
                    });
                }, remaining);
            },

            error: function (xhr) {
                submitBtn.prop("disabled", false);

                let elapsed = Date.now() - startTime;
                let remaining = Math.max(0, 1000 - elapsed);

                setTimeout(() => {
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
                }, remaining);
            },
        });

        return false;
    });
});
