function createMarker(lat, long, rssi, snr){
    console.log(lat, long, rssi, snr);

    var marker = L.marker([lat,long])
        .addTo(map)
        .title(rssi, snr);
}
