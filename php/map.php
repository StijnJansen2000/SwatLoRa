<?php?>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <script>
            var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                'attribution': 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            });

            var map = new L.Map('map', {
                'center': [39.568329, -0.617676],
                'zoom': 14,
                'layers': [tileLayer]
            });
            <?php
            $query = $conn->prepare("SELECT * FROM colors WHERE config_id=:conf");
            $query->execute(array(
                ":conf"=> $_SESSION['config_id']
            ));

            $query = $query->fetch(PDO::FETCH_ASSOC);

            $lowest = $query['lowest'];
            $lowestFromSnr = $query['llFromSnr'];
            $lowestToSnr = $query['llToSnr'];
            $lowestFromRSSI = $query['llFromRssi'];
            $lowestToRssi = $query['llToRssi'];

            $low = $query['low'];
            $lowFromSnr = $query['lFromSnr'];
            $lowToSnr = $query['lToSnr'];
            $lowFromRSSI = $query['lFromRSSI'];
            $lowToRssi = $query['lToRSSI'];

            $med = $query['medium'];
            $medFromSnr = $query['mFromSnr'];
            $medToSnr = $query['mToSnr'];
            $medFromRSSI = $query['mFromRssi'];
            $medToRssi = $query['mToRssi'];

            $high = $query['high'];
            $highFromSnr = $query['hFromSnr'];
            $highToSnr = $query['hToSnr'];
            $highFromRSSI = $query['hFromRssi'];
            $highToRssi = $query['hToRssi'];

            $highest = $query['highest'];
            $highestFromSnr = $query['hhFromSnr'];
            $highestToSnr = $query['hhToSnr'];
            $highestFromRSSI = $query['hhFromRssi'];
            $highestToRssi = $query['hhToRssi'];
            ?>



            let lowest = "#" + <?= json_encode($lowest) ?>;
            let lowestFromSnr = <?= json_encode($lowestFromSnr)?>;
            let lowestToSnr = <?= json_encode($lowestToSnr)?>;
            let lowestFromRssi = <?= json_encode($lowestFromRSSI)?>;
            let lowestToRssi = <?= json_encode($lowestToRssi)?>;

            let low = "#" + <?= json_encode($low) ?>;
            let lowFromSnr = <?= json_encode($lowFromSnr)?>;
            let lowToSnr = <?= json_encode($lowToSnr)?>;
            let lowFromRssi = <?= json_encode($lowFromRSSI)?>;
            let lowToRssi = <?= json_encode($lowToRssi)?>;

            let med = "#" + <?= json_encode($med) ?>;
            let medFromSnr = <?= json_encode($medFromSnr)?>;
            let medToSnr = <?= json_encode($medToSnr)?>;
            let medFromRssi = <?= json_encode($medFromRSSI)?>;
            let medToRssi = <?= json_encode($medToRssi)?>;

            let high = "#" + <?= json_encode($high) ?>;
            let highFromSnr = <?= json_encode($highFromSnr)?>;
            let highToSnr = <?= json_encode($highToSnr)?>;
            let highFromRssi = <?= json_encode($highFromRSSI)?>;
            let highToRssi = <?= json_encode($highToRssi)?>;
            console.log(highFromSnr + highToSnr);

            let highest = "#" + <?= json_encode($highest) ?>;
            let highestFromSnr = <?= json_encode($highestFromSnr)?>;
            let highestToSnr = <?= json_encode($highestToSnr)?>;
            let highestFromRssi = <?= json_encode($highestFromRSSI)?>;
            let highestToRssi = <?= json_encode($highestToRssi)?>;


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
                if (snr >= lowestFromSnr && snr <= lowestToSnr) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long)
                    // greenSNR.push(marker.getLatLng());
                    // greenSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr >= lowFromSnr && snr <= lowToSnr) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + low + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long)
                    // blueSNR.push(marker.getLatLng());
                    // blueSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr >= medFromSnr && snr <= medToSnr) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + med + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long)
                    // yellowSNR.push(marker.getLatLng());
                    // yellowSNR.push(({lat: gLat, lng: gLong}));
                } else if (snr >= highFromSnr && snr <= highToSnr) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + high + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long)
                    // orangeSNR.push(marker.getLatLng());
                    // orangeSNR.push(({lat: gLat, lng: gLong}));
                } else {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + highest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long)
                    // redSNR.push(marker.getLatLng());
                    // redSNR.push(({lat: gLat, lng: gLong}));
                }

                // greenSNR.push(({lat: gLat, lng: gLong}));
                // greenSNR.unshift(({lat: gLat, lng: gLong}));
                //
                // blueSNR.push(({lat: gLat, lng: gLong}));
                // blueSNR.unshift(({lat: gLat, lng: gLong}));
                //
                // yellowSNR.push(({lat: gLat, lng: gLong}));
                // yellowSNR.unshift(({lat: gLat, lng: gLong}));
                //
                // orangeSNR.push(({lat: gLat, lng: gLong}));
                // orangeSNR.unshift(({lat: gLat, lng: gLong}));
                //
                // redSNR.push(({lat: gLat, lng: gLong}));
                // redSNR.unshift(({lat: gLat, lng: gLong}));

                // var polyline = L.polyline(greenSNR, {color: '#' + lowest, fillColor: 'green'}).addTo(map);
                // var polyline = L.polyline(blueSNR, {color: '#' + low, fillColor: 'blue'}).addTo(map);
                var polyline = L.polyline(yellowSNR, {color: '#' + med, fillColor: 'yellow'}).addTo(map);
                // var polyline = L.polyline(orangeSNR, {color: '#'+ high, fillColor: 'orange'}).addTo(map);
                // var polyline = L.polyline(redSNR, {color: '#' + highest, fillColor: 'red'}).addTo(map);

                // console.log(yellowSNR);
            }

            var greenRSSI = Array();
            var blueRSSI = Array();
            var yellowRSSI = Array();
            var orangeRSSI = Array();
            var redRSSI = Array();

            function RSSImarkers(lat, long, snr, rssi, gateway, gLat, gLong) {
                if (Math.abs(rssi) >= lowestFromRssi && Math.abs(rssi) <= lowestToRssi) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                    // greenRSSI.push(marker.getLatLng());
                    // greenRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) >= lowFromRssi && Math.abs(rssi) <= lowToRssi) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + low + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                    // blueRSSI.push(marker.getLatLng());
                    // blueRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) >= medFromRssi && Math.abs(rssi) <= medToRssi) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + med + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                    // yellowRSSI.push(marker.getLatLng());
                    // yellowRSSI.push(({lat: gLat, lng: gLong}));
                } else if (Math.abs(rssi) >= highFromRssi && Math.abs(rssi) <= highToRssi) {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + high + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
                    // orangeRSSI.push(marker.getLatLng());
                    // orangeRSSI.push(({lat: gLat, lng: gLong}));
                } else {
                    icon = L.divIcon({
                        className: 'custom-div-icon',
                        html: "<div style='background-color:" + highest + ";' class='marker-pin'></div>",
                        iconSize: [30, 42],
                        iconAnchor: [15, 42]
                    });
                    marker = L.marker([lat, long], {
                        icon: icon
                    }).addTo(map);
                    marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time)
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
                // .openPopup();
            }

        </script>