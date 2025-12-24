let html5QrCode = null;
let isScanning = false;

$(document).ready(function () {
    $(document).on("click", ".btn-scan-qr", function (e) {
        e.preventDefault();
        if (isScanning) return;

        isScanning = true;
        $("#modal-scan").removeClass("hidden").addClass("flex");

        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }

        Html5Qrcode.getCameras().then((cameras) => {
            html5QrCode.start(
                cameras[0].id,
                { fps: 10, qrbox: 250 },
                (decodedText) => {
                    stopScanner();

                    let token = decodedText.split("/").pop();

                    $.ajax({
                        url: `/acara/qr/${token}`,
                        method: "POST",
                        data: {
                            _token: $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (res) {
                            if (res.status === "error") {
                                alert(res.message);
                                return;
                            }

                            // Isi modal info
                            $("#info-nama").text(res.acara.nama_acara);
                            $("#info-tanggal").text(res.acara.tanggal_waktu);
                            $("#info-lokasi").text(res.acara.lokasi);
                            $("#info-status").text(
                                res.status === "success"
                                    ? "Hadir"
                                    : "Sudah Hadir"
                            );

                            $("#modal-info")
                                .removeClass("hidden")
                                .addClass("flex");
                        },
                        error: function () {
                            alert("Gagal memproses absensi");
                        },
                    });
                }
            );
        });
    });

    $("#close-scan").on("click", stopScanner);

    $("#close-info").on("click", function () {
        $("#modal-info").addClass("hidden").removeClass("flex");
    });

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => html5QrCode.clear());
        }
        isScanning = false;
        $("#modal-scan").addClass("hidden").removeClass("flex");
    }
});
