<?php?>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <script>
            var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                'attribution': 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            });

            var map = new L.Map('map', {
                'center': [39.46975, -0.37739],
                'zoom': 14,
                'layers': [tileLayer]
            });

            function markerColor(color) {
                var markerColor = L.icon({
                    iconUrl: 'images/marker' + color + '.png',
                    iconSize: [40, 40]
                });

                return markerColor;
            }

            var greenSNR = Array();
            var blueSNR = Array();
            var yellowSNR = Array();
            var orangeSNR = Array();
            var redSNR = Array();


            function SNRmarkers(lat, long, snr, rssi, time, gateway, gLat, gLong) {
                console.log(lat, long, snr, gateway, gLat, gLong);
                if (snr <= 3) {
                    var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // greenSNR.push(marker.getLatLng());
                    // greenSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 3 && snr <= 5) {
                    var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // blueSNR.push(marker.getLatLng());
                    // blueSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 5 && snr <= 7) {
                    var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // console.log(marker.getLatLng());
                    // yellowSNR.push(marker.getLatLng());
                    // yellowSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr > 7 && snr <= 9) {
                    var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // orangeSNR.push(marker.getLatLng());
                    // orangeSNR.push(({lat: gLat, lng: gLong}));
                } else {
                    var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // redSNR.push(marker.getLatLng());
                    // redSNR.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenSNR, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueSNR, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowSNR, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeSNR, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redSNR, {color: 'red', fillColor: 'red'}).addTo(map);

                // console.log(yellowSNR);
            }

            var greenRSSI = Array();
            var blueRSSI = Array();
            var yellowRSSI = Array();
            var orangeRSSI = Array();
            var redRSSI = Array();

            function RSSImarkers(lat, long, snr, rssi, gateway, gLat, gLong) {
                if (Math.abs(rssi) <= 10) {
                    var marker = L.marker([lat, long], {icon: markerColor("Green")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // greenRSSI.push(marker.getLatLng());
                    // greenRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 10 && Math.abs(rssi) <= 32) {
                    var marker = L.marker([lat, long], {icon: markerColor("Blue")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // blueRSSI.push(marker.getLatLng());
                    // blueRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 32 && Math.abs(rssi) <= 60) {
                    var marker = L.marker([lat, long], {icon: markerColor("Yellow")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi)
                        .openPopup();
                    // yellowRSSI.push(marker.getLatLng());
                    // yellowRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) > 60 && Math.abs(rssi) <= 80) {
                    var marker = L.marker([lat, long], {icon: markerColor("Orange")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // orangeRSSI.push(marker.getLatLng());
                    // orangeRSSI.push(({lat: gLat, lng: gLong}));
                } else {
                    var marker = L.marker([lat, long], {icon: markerColor("Red")}).addTo(map)
                        .bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                        .openPopup();
                    // redRSSI.push(marker.getLatLng());
                    // redRSSI.push(({lat: gLat, lng: gLong}));
                }
                var polyline = L.polyline(greenRSSI, {color: 'green', fillColor: 'green'}).addTo(map);
                var polyline = L.polyline(blueRSSI, {color: 'blue', fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowRSSI, {color: 'yellow', fillColor: 'yellow'}).addTo(map);
                var polyline = L.polyline(orangeRSSI, {color: 'orange', fillColor: 'orange'}).addTo(map);
                var polyline = L.polyline(redRSSI, {color: 'red', fillColor: 'red'}).addTo(map);
            }

            function gateways(lat, long, name) {
                console.log(lat, long, name);
                L.marker([lat, long]).addTo(map)
                .bindPopup('Name: ' + name)
                .openPopup();
            }

        </script>