let html5QrCode = null;

        document.addEventListener('alpine:init', () => {
            // Saat modal dibuka
            window.addEventListener('open-modal', event => {
                if (event.detail?.id === 'scanModal') {
                    const readerEl = document.getElementById('reader');
                    const resultInput = document.getElementById('scan-result');
                    readerEl.innerHTML = "";
                    resultInput.value = "Menyalakan kamera...";

                    html5QrCode = new Html5Qrcode("reader");
                    const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                    Html5Qrcode.getCameras().then(devices => {
                        if (devices && devices.length) {
                            const cameraId = devices[devices.length - 1].id; // kamera belakang HP
                            html5QrCode.start(
                                cameraId,
                                config,
                                qrCodeMessage => {
                                    // Saat kode berhasil terbaca
                                    alert("Kode Terbaca: " + qrCodeMessage);

                                    // Isi ke input (opsional)
                                    resultInput.value = qrCodeMessage;

                                    // Hentikan kamera
                                    html5QrCode.stop().then(() => {
                                        console.log("Kamera dihentikan otomatis setelah scan.");
                                    });
                                },
                                errorMessage => {
                                    // abaikan error kecil
                                }
                            );
                        } else {
                            resultInput.value = "Tidak ada kamera terdeteksi.";
                        }
                    }).catch(err => {
                        resultInput.value = "Gagal mengakses kamera.";
                        console.error(err);
                    });
                }
            });

            // Saat modal ditutup
            window.addEventListener('close-modal', event => {
                if (event.detail?.id === 'scanModal') {
                    if (html5QrCode) {
                        html5QrCode.stop().then(() => {
                            console.log("Kamera dimatikan saat modal ditutup.");
                        }).catch(() => {});
                    }
                }
            });
        });