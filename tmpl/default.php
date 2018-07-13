<?php

/**
 * @version     3.0.0
 * @package     com_imc
 * @subpackage  mod_imc
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE
 * @author      Ioannis Tsampoulatidis <tsampoulatidis@gmail.com> - https://github.com/itsam
 */
defined('_JEXEC') or die;
?>
<div class="imc-mod-map-canvas-wrapper<?php echo $moduleclass_sfx ?>">
    <div id="imc-mod-map-canvas">
        <div id="map" class="imc-map"></div>
    </div>
</div>


<script>
	var lat = <?php echo $lat;?>;
	var lng = <?php echo $lng;?>;
	var zoom = <?php echo $zoom;?>;
	var clusterer = "<?php echo $clusterer;?>";
	var language = "<?php echo $language;?>";
    var markerImg = "<?php echo $markerImg;?>";


    var points = new Array();
    var map = L.map('map').setView([lat, lng], zoom);
    mapLink = '<a href="http://openstreetmap.org">OpenStreetMap</a>';

    L.tileLayer('https://api.mapbox.com/styles/v1/drp0ll0/cj0tausco00tb2rt87i5c8pi0/tiles/256/{z}/{x}/{y}@2x?access_token=pk.eyJ1IjoiZHJwMGxsMCIsImEiOiI4bUpPVm9JIn0.NCRmAUzSfQ_fT3A86d9RvQ', {
        attribution: '&copy; ' + mapLink + ' Contributors',
        maxZoom: 18,
    }).addTo(map);


    jQuery.ajax({
        'async': true,
        'global': false,
        'url': "index.php?option=com_imc&task=issues.markers&format=json",
        'dataType': "json",
        'success': function (data) {
            json = data;
            var img = markerImg;

            //loop between each of the json elements
            for (var i = 0; i < json.data.length; i++) {
                var data = json.data[i];
                

                if (data.category_image) {
                    img = data.category_image;
                }
                if(data.moderation == 1) {
                    img = 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png';
                }


                points[i] = {'title':data.title, 'lat':data.latitude, 'long':data.longitude, 'image':img};
            }


            for (var i = 0; i < points.length; i++) {
                var icon = L.icon({
                    iconUrl: points[i]['image']
                });

                marker = new L.marker([points[i]['lat'], points[i]['long']], {
                    icon: icon
                })
                .bindPopup(points[i]['title'])
                .addTo(map);
            }
        },
        'error': function (error) {
            alert('Cannot read markers - See console for more information');
            console.log (error);
        }
    });
</script>