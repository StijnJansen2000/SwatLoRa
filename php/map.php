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
        'zoom': 18,
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
    // console.log(highFromSnr + highToSnr);

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

    var greenSNR = 0;
    var blueSNR = 0;
    var yellowSNR = 0;
    var orangeSNR = 0;
    var redSNR = 0;

    var greenCircle = "";
    var blueCircle = "";
    var yellowCircle = "";
    var orangeCircle = "";
    var redCircle = "";


    function SNRmarkers(lat, long, snr, rssi, time, gateway, gLat, gLong) {
        if (snr >= lowestFromSnr && snr <= lowestToSnr) {
            //Icon
            icon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            });
            //Marker
            marker = L.marker([lat, long], {
                icon: icon
            }).addTo(map);
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > greenSNR){
                greenSNR = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            greenCircle = L.circle([gLat, gLong],{
                color: lowest,
                fillOpacity: 0.0,
                radius: greenSNR
            })
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            if (marker.getLatLng().distanceTo([gLat, gLong]) > blueSNR){
                blueSNR = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            blueCircle = L.circle([gLat, gLong],{
                color: low,
                fillOpacity: 0.0,
                radius: blueSNR
            })
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            if (marker.getLatLng().distanceTo([gLat, gLong]) > yellowSNR){
                yellowSNR = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            yellowCircle = L.circle([gLat, gLong],{
                color: med,
                fillOpacity: 0.0,
                radius: yellowSNR
            })
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            if (marker.getLatLng().distanceTo([gLat, gLong]) > orangeSNR){
                orangeSNR = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            orangeCircle = L.circle([gLat, gLong],{
                color: high,
                fillOpacity: 0.0,
                radius: orangeSNR
            })
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            if (marker.getLatLng().distanceTo([gLat, gLong]) > redSNR){
                redSNR = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            redCircle = L.circle([gLat, gLong],{
                color: highest,
                fillOpacity: 0.0,
                radius: redSNR
            })


        }

        // var polyline = L.polyline(greenSNR, {color: '#' + lowest, fillColor: 'green'}).addTo(map);
        // var polyline = L.polyline(blueSNR, {color: '#' + low, fillColor: 'blue'}).addTo(map);
        // var polyline = L.polyline(yellowSNR, {color: '#' + med, fillColor: 'yellow'}).addTo(map);
        // var polyline = L.polyline(orangeSNR, {color: '#'+ high, fillColor: 'orange'}).addTo(map);
        // var polyline = L.polyline(redSNR, {color: '#' + highest, fillColor: 'red'}).addTo(map);
    }


    var greenRSSI = 0;
    var blueRSSI = 0;
    var yellowRSSI = 0;
    var orangeRSSI = 0;
    var redRSSI = 0;

    var greenRCircle = "";
    var blueRCircle = "";
    var yellowRCircle = "";
    var orangeRCircle = "";
    var redRCircle = "";


    var greenRSSIarray = new Array();
    var blueRSSIarray = new Array();
    var yellowRSSIarray = new Array();
    var orangeRSSIarray = new Array();
    var redRSSIarray = new Array();

    function RSSImarkers(lat, long, snr, rssi, time, gateway, gLat, gLong) {
        if (Math.abs(rssi) >= lowestFromRssi && Math.abs(rssi) <= lowestToRssi) {
            icon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:" + lowest + ";' class='marker-pin'></div>",
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            });
            //Marker
            marker = L.marker([lat, long], {
                icon: icon
            }).addTo(map);
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > greenRSSI){
                greenRSSI = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            greenRCircle = L.circle([gLat, gLong],{
                color: lowest,
                fillOpacity: 0.0,
                radius: greenRSSI
            });
            greenRSSIarray.push(marker.getLatLng());
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > blueRSSI){
                blueRSSI = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            blueRCircle = L.circle([gLat, gLong],{
                color: low,
                fillOpacity: 0.0,
                radius: blueRSSI
            });
            blueRSSIarray.push(marker.getLatLng());
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > yellowRSSI){
                yellowRSSI = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            yellowRCircle = L.circle([gLat, gLong],{
                color: med,
                fillOpacity: 0.0,
                radius: yellowRSSI
            });
            yellowRSSIarray.push(marker.getLatLng());
        } else if (Math.abs(rssi) >= highFromRssi && Math.abs(rssi) <= highToRssi) {
            icon = L.divIcon({
                className: 'custom-div-icon',
                html: "<div style='background-color:" + high + ";' class='marker-pin'></div>",
                iconSize: [30, 42],
                iconAnchor: [15, 42],

            });
            marker = L.marker([lat, long], {
                icon: icon
            }).addTo(map);
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > orangeRSSI){
                orangeRSSI = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            orangeRCircle = L.circle([gLat, gLong],{
                color: high,
                fillOpacity: 0.0,
                radius: orangeRSSI
            });
            orangeRSSIarray.push(marker.getLatLng());
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
            marker.bindPopup('SNR: ' + snr + '<br>' + 'RSSI: ' + rssi + '<br>Time: ' + time + '<br>Location: ' + lat + ' ' + long);
            //Circle
            if (marker.getLatLng().distanceTo([gLat, gLong]) > redRSSI) {
                redSSI = marker.getLatLng().distanceTo([gLat, gLong]);
            }
            redRCircle = L.circle([gLat, gLong], {
                color: highest,
                fillOpacity: 0.0,
                radius: redRSSI
            });
            redRSSIarray.push(marker.getLatLng());
        }
        var polyline = L.polyline(greenRSSIarray, {color: lowest, fillColor: 'green'}).addTo(map);
        var polyline = L.polyline(blueRSSIarray, {color: low, fillColor: 'blue'}).addTo(map);
        var polyline = L.polyline(yellowRSSIarray, {color: med, fillColor: 'yellow'}).addTo(map);
        var polyline = L.polyline(orangeRSSIarray, {color: high, fillColor: 'orange'}).addTo(map);
        var polyline = L.polyline(redRSSIarray, {color: highest, fillColor: 'red'}).addTo(map);
    }


    var globalLat = "";
    var globalLong = "";
    function gateways(lat, long, name) {
        console.log(lat, long, name);
        L.marker([lat, long]).addTo(map)
            .bindPopup('Name: ' + name)
        // .openPopup();
        globalLat = lat;
        globalLong = long;
    }

    window.onload = function (setMapThings) {
        <?php if (isset($_POST['choiceRadios'])) { ?>
        let radio = <?= json_encode($_POST['choiceRadios'])?>;

        //let radio = <?//= json_encode($_POST['choiceRadios'])?>
           if (radio == "SNR"){
               greenCircle.addTo(map);
               blueCircle.addTo(map);
               yellowCircle.addTo(map);
               orangeCircle.addTo(map);
               redCircle.addTo(map);
           } else {
               if (greenRCircle != "") {
                   greenRCircle.addTo(map);
               }
               if (blueRCircle != "") {
                   blueRCircle.addTo(map);
               }
               if (yellowRCircle != "") {
                   yellowRCircle.addTo(map);
               }
               if (orangeRCircle != "") {
                   orangeRCircle.addTo(map);
               }
               if (redRCircle != "") {
                   redRCircle.addTo(map);
               }
           }
           <?php } ?>
    };

</script>