<?php

require "PolyUtil.php";

$encodedPolyline = "{ciiBm_c}MFYL@vFpC|l@j\\|@RvKz@b@MV_@xEeMjHkQfUwl@f@OV@rBn@RCTU|LoY|BqEv@{@fA[z@?bE`An@@`AOtAcAfJ_MdAq@bAU`F@jHJzFZdIz@jVhDhi@~HbHZdEUzEu@jGiBtaAa[nEeB`p@wY\\Gh@DhAx@XCdAg@bBCl@TlAbAd@@TODICkBIk@iByFyBeG{AsA_@LOf@b@hC@nAU|@c@h@kDfB{NnG_B~@i]pOoGhCcdAx[aGvAuG`@aGUep@}JgBUyCOw@]W_@M_ATyDXe@nAkAHm@S]UEiAf@a@GO]Bc@h@u@XcA~Dac@`@yChCqH|B_FzOoXlIoMvAiCt@uBxEwPh@oCPoCs@gON}WvAou@lDiYbLgy@b@gCTWx@DdIxDzLxD|@t@`@bAj@pDPtFTvAj@nAhKtMhFhMjAdAzJ~EzCnBZp@NdANfEh@hI`@x@vFxItAhC`BdE~Od^xFrLtB`C`D|CjEpDX`@bFnN\\rBnArQHpCAbA_ClZAbCH~AXlBrB~FhAlAFnBnBbGxB~Ft@j@Jh@MZc@V}@b@m@Dg@Sq@k@u@Us@DeAZyBlBg@t@q@lBi@zCUvDV~Dv@lDjB~Ev@hCb@~BNjDUbE}@fGu@pEeA`E}AxCeHjH_@r@Ip@^~MD~FOxOk@hHC|APjDjBdJ@|CV~@f@h@tI~Dx@XxRtDpA\\pAv@hFpHd\\ha@hHvJt@zAxAnEnDjLr@dHB|BOx@Of@}BtDwAxCU~@MjBFfCX~BbEbXd@zAn@jArb@hh@x@jAALSIeb@yg@y@iAy@yAa@iAcEgW_@aDK}C^yCl@cBzDqGXmA?oAe@mFc@aC{DgMaAsC_AmB}L{OiVcZeFoHeA_AoAe@wQqDkBg@{FyBmC}Ag@q@Ky@?mCQuAqAsGQyACeCp@qJNeQc@}SLkAh@aArGuGhAiB`@eAr@mC|BsOJyB?yAU_D]yA}DmL]qBQaC?cCVgC`@yBfAoCrAiBFWWe@m@Yg@@kA^iW`LeT~JgI~C_i@lPm\\nKsHlAcEJ{Ha@q_@uFmGkAoJgAeJuAkHu@cH_@iMU_BH{@XgA~@qHdKiB`BmATq@AgD{@mAIyAd@}@pAeClF_Ot]qJfWgOv_@iCjHq@dDo@dBkAjAi@To@@u@QkA{Ac@O_LaA{Am@mp@u^{FqDn@NbB|@";

echo "<b>Encoded Polyline:</b> $encodedPolyline</br>";

$decodedLatLong = \GeometryLibrary\PolyUtil::decode($encodedPolyline);

//Output of $decodedLatLong
/*
Array ( 
[0] => Array ( [lat] => 17.41902 [lng] => 78.33607 ) 
[1] => Array ( [lat] => 17.41898 [lng] => 78.3362 ) 
[2] => Array ( [lat] => 17.41891 [lng] => 78.33619 ) 
[3] => Array ( [lat] => 17.41767 [lng] => 78.33546 ) 
[4] => Array ( [lat] => 17.41032 [lng] => 78.33076 ) 
)
*/
$data_points = array();
$count = count($decodedLatLong);

foreach ($decodedLatLong as $latlong)
{
    $point = array(
        'lat' => $latlong['lat'],
        'lng' => $latlong['lng']
    );
    array_push($data_points, $point);
}

echo "</br><b>Decoded Polyline using Encoded String is DONE</b></br>";
//Output  of $data_points
/*
Array ( 
  [0] => Array ( [lat] => 17.41902 [lng] => 78.33607 ) 
  [1] => Array ( [lat] => 17.41898 [lng] => 78.3362 ) 
  [2] => Array ( [lat] => 17.41891 [lng] => 78.33619 ) 
  [3] => Array ( [lat] => 17.41767 [lng] => 78.33546 ) 
  [4] => Array ( [lat] => 17.41032 [lng] => 78.33076 ) 
)
*/
$placeDataIntoMap = json_encode($data_points, JSON_NUMERIC_CHECK);

$response = \GeometryLibrary\PolyUtil::encode($data_points);

echo "</br><b>Encoded Polyline String using Decoded Lat Lngs:</b> $response</br></br>";

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Map</title>
</head>

<body>
  <div class="col-md-12">
    <div class="col-md-6">
      <div class="col-md-12">
        <div id="map" style="height:450px; width: 100%; border:1px solid #c1a57b; border-radius: 2px;"></div>
      </div>
    </div>
  </div>

  <script>
    // This example creates a 2-pixel-wide red polyline showing the path of
    var latitudec = <?php echo $decodedLatLong[0]['lat']; ?> ;
    var longitudec = <?php echo $decodedLatLong[0]['lng']; ?> ;

    var latitudeend = <?php echo $decodedLatLong[$count - 1]['lat']; ?> ;
    var longitudeend = <?php echo $decodedLatLong[$count - 1]['lng']; ?> ;

    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: {
          lat: latitudec,
          lng: longitudec
        },
        // mapTypeId: 'terrain'
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });

      var iconBase = 'https://maps.google.com/mapfiles/ms/icons/';

      var icons = {
        start: {
          icon: iconBase + 'green-dot.png'
        },
        end: {
          icon: iconBase + 'red-dot.png'
        }
      };

      var features = [{
        position: new google.maps.LatLng(latitudec, longitudec),
        type: 'start'
      }, {
        position: new google.maps.LatLng(latitudeend, longitudeend),
        type: 'end'
      }];

      features.forEach(function (feature) {
        var marker = new google.maps.Marker({
          position: feature.position,
          icon: icons[feature.type].icon,
          map: map
        });
      });
      //map icon end

      var flightPlanCoordinates = <?php echo $placeDataIntoMap ?> ;

      var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
      });

      flightPath.setMap(map);
    }
  </script>
<!-- 
Place Your API KEY Here: YOUR_API_KEY
https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap
 -->
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap">
    </script>
</body>
</html>