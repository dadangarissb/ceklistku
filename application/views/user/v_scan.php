<!DOCTYPE html>
<html>
<head>
    <title>Scan QR Code</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>

<h3>Scan QR Code</h3>
<p>Arahkan kamera ke QR Code</p>

<div id="reader" style="width:300px;"></div>

<script>
    const html5Qrcode = new Html5Qrcode("reader");

    html5Qrcode.start(
        { facingMode: "environment" },
        { fps: 10, qrbox: 250 },
        (decodedText, decodedResult) => {
            console.log("Hasil scan:", decodedText);

            // Langsung redirect ke isi QR (harus berupa URL)
            window.location.href = decodedText;
        },
        (errorMessage) => {
            // bisa dikosongkan
        }
    ).catch(err => {
        alert("Gagal membuka kamera: " + err);
    });
</script>

</body>
</html>