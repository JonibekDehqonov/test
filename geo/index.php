<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foydalanuvchi joylashuvi xaritada</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha384-rxxQ03iDAE3czsFipDPIxGDEKLOXTyHdP+IeHht6MmUEnSRAKKnROwU+DzPC1x8k" crossorigin=""/>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        #map {
            height: 90vh;
            width: 100%;
        }
        #info {
            margin: 20px;
        }
    </style>
</head>
<body>
    <h1>Foydalanuvchingiz joylashuvi xaritada</h1>
    <div id="info">Geo-lokatsiyani olish uchun ruxsat bering...</div>
    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha384-nw4MzLwMiAaNmL4FRFB00u33wh9OM2B+QNi2XPG7xwQfJzAS/W/w4CkZBYbr2pDL" crossorigin=""></script>
    <script>
        // Xarita o'rnatish uchun boshlang'ich sozlamalar
        const map = L.map('map').setView([51.505, -0.09], 13); // Standart markazlashuv (o'zgartiriladi)

        // Xarita qatlami
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Foydalanuvchi geolokatsiyasini olish
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Xaritada foydalanuvchi joylashuvini ko'rsatish
                const userMarker = L.marker([latitude, longitude]).addTo(map)
                    .bindPopup("<b>Sizning joylashuvingiz!</b>").openPopup();

                map.setView([latitude, longitude], 13); // Xarita markazini o'rnatish

                // Joylashuvni info blokida ko'rsatish
                document.getElementById('info').innerHTML = `
                    <p><strong>Kenglik:</strong> ${latitude}</p>
                    <p><strong>Uzunlik:</strong> ${longitude}</p>
                `;

                // PHP serverga ma'lumotlarni yuborish
                fetch('save_location.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ latitude, longitude })
                }).then(response => response.text())
                  .then(data => console.log(data))
                  .catch(error => console.error('Xatolik:', error));
            }, error => {
                alert("Geo-lokatsiyani olishga ruxsat bermadingiz.");
            });
        } else {
            alert("Brauzeringiz geolokatsiyani qo'llab-quvvatlamaydi.");
        }
    </script>
</body>
</html>
