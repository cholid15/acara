let html5QrCode = null;
let isScanning = false;

$(document).ready(function () {
    // Klik SEMUA tombol Scan QR
    $(document).on("click", ".btn-scan-qr", function (e) {
        e.preventDefault();

        if (isScanning) return;
        isScanning = true;

        $("#modal-scan").removeClass("hidden").addClass("flex");

        if (!html5QrCode) {
            html5QrCode = new Html5Qrcode("qr-reader");
        }

        Html5Qrcode.getCameras()
            .then((cameras) => {
                if (!cameras || !cameras.length) {
                    alert("Kamera tidak ditemukan");
                    stopScanner();
                    return;
                }

                html5QrCode.start(
                    cameras[0].id, // kamera laptop
                    {
                        fps: 10,
                        qrbox: 250,
                    },
                    (decodedText) => {
                        stopScanner();
                        window.location.href = decodedText;
                    },
                    (error) => {
                        // silent
                    }
                );
            })
            .catch(() => {
                alert("Gagal mengakses kamera");
                stopScanner();
            });
    });

    // Tutup modal
    $("#close-scan").on("click", function () {
        stopScanner();
    });

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
            });
        }
        isScanning = false;
        $("#modal-scan").addClass("hidden").removeClass("flex");
    }
});
