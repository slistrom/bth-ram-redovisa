<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}

?><article <?= classList($classes) ?>>
<h1>Weather report</h1>

<?php if ($location != 'Not valid IP-address.') : ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <p><?= $location["city"] ?>, <?= $location["country_name"] ?></p>
    <div id="mapid" style="width: 600px; height: 400px;"></div>
    <script>
        var mymap = L.map('mapid').setView([<?= $location["latitude"] ?>, <?= $location["longitude"] ?>], 13);

        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
            maxZoom: 18,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1
        }).addTo(mymap);

    </script>
    <h3>Current weather</h3>
    <p>Current weather in <?= $location["city"] ?> is <?= $weather["weather"][0]["description"] ?>.</p>
    <p>The temperature is <?= $weather["main"]["temp"] ?> degrees Celsius and the wind speed is <?= $weather["wind"]["speed"] ?> m/s.</p>
    <h3>Weather forecast</h3>
        <?php foreach ($forecast["daily"] as $daily) : ?>
            <p><strong><?= date("Y/m/d", $daily["dt"]) ?> </strong><br>
            Weather will be <?= $daily["weather"][0]["main"] ?><br>
            Temperature during day <?= $daily["temp"]["day"] ?> degrees Celsius and the wind speed <?= $daily["wind_speed"] ?> m/s.</p>
        <?php endforeach; ?>

    <h3>Historic weather</h3>
        <?php foreach ($historicWeather as $pastDay) : ?>
            <p><strong><?= date("Y/m/d", $pastDay["current"]["dt"]) ?> </strong><br>
            Weather will be <?= $pastDay["current"]["weather"][0]["main"] ?><br>
            Temperature during day <?= $pastDay["current"]["temp"] ?> degrees Celsius and the wind speed <?= $pastDay["current"]["wind_speed"] ?> m/s.</p>
        <?php endforeach; ?>

<?php else : ?>
    <p>Not a valid IP-address</p>
    <p><a href="../weather">Try again</a></p>
<?php endif; ?>

</article>
