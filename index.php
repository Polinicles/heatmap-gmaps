<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="legend">
    <button type="button" data-id="rain">Rain</button>
    <button type="button" data-id="temp">Temperature</i></button>
</div>
<div id="map" style="width: 500px;height: 500px;">
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="data.json"></script>
<script>
    /* Gmaps callback function */
    function initMap() {
        /* Map variables */
        var map;
        var layerData       = <?php require 'data.json' ?>;
        var shapes          = [];
        var NORTH           = 0;
        var WEST            = -90;
        var SOUTH           = 180;
        var EAST            = 90;
        var RADIUS          = 4525;
        var typeOfMap       = 'rain';
        var gradientHeat    = [
            '#7e0e7d', '#931393', '#c61dc6', '#e022df', '#4421a8', '#3e1fc4', '#4227fb', '#1157e2', '#1474e3',
            '#2192e3', '#38b7e4', '#5fdbe5', '#2c9b19', '#45a81c', '#5BB520', '#85CD27', '#A5DF2D', '#C0F033',
            '#D8FA3B', '#FDFD38', '#FEE634', '#FECD31', '#F8AC29', '#FA8E25', '#F47421', '#FC5B1F', '#FC3E1D',
            '#F20E36', '#D90C31', '#C40A2C', '#A80726', '#881423', '#681322', '#4D0220', '#40011B', '#2F010A'
        ];
        var gradientRain    = [
            'rgba(255,255,255, 0)',
            'rgba(0, 255, 255, 1)',
            'rgba(0, 0, 255, 1)'
        ];

        // Initiate the map
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 7,
            center:  new google.maps.LatLng(40.5, 1.5),
            mapTypeId: 'terrain'
        });

        // Initiate the gradient map for rain layer
        var heatMap = new google.maps.visualization.HeatmapLayer({
            gradient: gradientRain,
            radius: 15,
            maxIntensity: 90
        });
        heatMap.setMap(map);

        // Define rain layer by default
        defineGradientLayer();

        /* Change heat map radius when zoom changes */
        google.maps.event.addListener(map, 'zoom_changed', function() {
            zoomLevel = map.getZoom();
            if(zoomLevel === 5) {
                heatMap.setOptions({radius: 5, maxIntensity: 40});
            } else if (zoomLevel === 6) {
                heatMap.setOptions({radius: 7.5, maxIntensity: 10});
            }
        });

        /* Remove shapes from heatmap layer */
        function removeHeatLayer() {
            for(var i in shapes) {
                shapes[i].setMap(null);
            }
            shapes = [];
        }

        /* Change Heatmap values */
        function defineShapesLayer() {
            /* Define heat map layer */
            if(shapes.length) removeHeatLayer();

            for(var key in layerData) {
                var lat = layerData[key].latitude;
                var lng = layerData[key].longitude;
                if(layerData[key].temp !== null && layerData[key].temp !== undefined) {
                    /* Circles option */
                    var circle = new google.maps.Circle({
                        center: new google.maps.LatLng(lat, lng),
                        map: map,
                        fillColor:  gradientHeat[layerData[key].temp],
                        fillOpacity: 0.25,
                        strokeWeight: 0,
                        zIndex: 10,
                        radius: 9000
                    });
                    shapes.push(circle);

                    /* Squares option */
//                    var center      = new google.maps.LatLng(lat, lng);
//                        var north       = google.maps.geometry.spherical.computeOffset(center, RADIUS, NORTH);
//                        var south       = google.maps.geometry.spherical.computeOffset(center, RADIUS, SOUTH);
//                        var northEast   = google.maps.geometry.spherical.computeOffset(north, RADIUS, EAST);
//                        var northWest   = google.maps.geometry.spherical.computeOffset(north, RADIUS, WEST);
//                        var southEast   = google.maps.geometry.spherical.computeOffset(south, RADIUS, EAST);
//                        var southWest   = google.maps.geometry.spherical.computeOffset(south, RADIUS, WEST);
//                        var corners     = [northEast, northWest, southWest, southEast];
//
//                        var rect        = new google.maps.Polygon({
//                            paths: corners,
//                            strokeColor: gradientHeat[layerData[key].temp],
//                            strokeOpacity: 0,
//                            strokeWeight: 0,
//                            fillColor: gradientHeat[layerData[key].temp],
//                            fillOpacity: 0.5,
//                            map: map
//                        });
//                    shapes.push(rect);
                }
            }
        }


        /* Define cloud/rain layer */
        function defineGradientLayer() {
            var colorData = [];
            /* Define heat map layer */
            for(var key in layerData) {
                var lat = layerData[key].latitude;
                var lng = layerData[key].longitude;
                if(layerData[key].rain !== null && layerData[key].rain !== undefined) {
                    var data = {location: new google.maps.LatLng(lat, lng), weight: layerData[key].rain};
                    colorData.push(data);
                }
            }
            heatMap.setOptions({data: colorData});
        }

        /* ------------------------- Triggers -------------------------  */

        /* Change type of Map */
        $(".legend button").click(function(){
            typeOfMap = $(this).attr('data-id');
            if(typeOfMap === 'temp') {
                heatMap.setMap(null);
                defineShapesLayer();
            } else if(typeOfMap === 'rain') {
                removeHeatLayer();
                defineGradientLayer();
                heatMap.setMap(map);
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={YOUR_API_KEY}&libraries=visualization,geometry&callback=initMap"></script>
</html>