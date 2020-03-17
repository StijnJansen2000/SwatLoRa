var tileLayer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    'attribution': 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
});

var map = new L.Map('map', {
    'center': [39.46975,-0.37739],
    'zoom': 14,
    'layers': [tileLayer]
});

map.on('popupopen', function(openEvent){
    $(function () {
        $('#marker-popover').popover();
    });
});

var marker = L.marker([39.46975,-0.37739])
    .addTo(map)
    .bindPopup('<button id="marker-popover" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="This is a marker">Click</button>');


var circle = L.circle([39.46975,-0.37739], {
    color: 'green',
    // fillColor: 'green',
    fillOpacity: 0.0,
    radius: 500
}).addTo(map);

var circle = L.circle([39.46975,-0.37739], {
    color: 'blue',
    fillOpacity: 0.0,
    radius: 750
}).addTo(map);

var circle = L.circle([39.46975,-0.37739], {
    color: 'yellow',
    fillOpacity: 0.0,
    radius: 1000
}).addTo(map);

var circle = L.circle([39.46975,-0.37739], {
    color: 'orange',
    fillOpacity: 0.0,
    radius: 1250
}).addTo(map);

var circle = L.circle([39.46975,-0.37739], {
    color: 'red',
    fillOpacity: 0.0,
    radius: 1500
}).addTo(map);

function makeMarker($long, $lat){
    var marker = L.marker([$long, $lat])
        .addTo(map)
        .bindPopup('<button id="marker-popover" type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="This is a marker">Click</button>');
}


