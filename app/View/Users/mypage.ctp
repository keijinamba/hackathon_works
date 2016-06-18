<?php
$this->start('css');
echo $this->Html->css('cal');
$this->end(); // css
$this->start('script');
echo $this->Html->script('cal');
$this->end(); // js
echo $this->element('pc/header');
?>
<div id="map-wrapper" data-id="<?php echo $auth->user('id'); ?>">
	<div id="map"></div>
</div>
<div id="cal0" class="cal_wrapper">Calendar Loading</div>
<div class="twitter_wrapper">
	<?php if ($tweets) : ?>
	<?php foreach ($tweets as $tweet) : ?>
	<blockquote class="twitter-tweet" data-lang="ja"><a href="<?php echo $tweet['Content']['url'] ?>"></a></blockquote>
    <?php endforeach ; ?>
    <?php endif ; ?>
</div>
<script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<script type="text/javascript">
function initMap() {
	var map;
	var directionsDisplay = new google.maps.DirectionsRenderer;
	var directionsService = new google.maps.DirectionsService;
	var markers = [];
	var points = [{lat: 35.725498, lng: 139.615570},{lat: 35.628658, lng: 139.711914},{lat: 35.713167, lng: 139.705457},{lat: 35.722547, lng: 139.643250},{lat: 35.716102, lng: 139.698816},{lat: 35.706696, lng: 139.701605},{lat: 35.660517, lng: 139.701390},{lat: 35.633364, lng: 139.715382}];
	var request = {
	    origin:points[0],
	    destination:points[1],
	    waypoints: [
		    {
		      location:points[2],
		      stopover:false
		    },
		    {
		      location:points[3],
		      stopover:false
		    },
		    {
		      location:points[4],
		      stopover:false
		    },
		    {
		      location:points[5],
		      stopover:false
		    },
		    {
		      location:points[6],
		      stopover:false
		    },
		    {
		      location:points[7],
		      stopover:false
		    }],
	    travelMode: google.maps.TravelMode.DRIVING
    };
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 35.5, lng: 140},
        zoom: 8
    });
    directionsDisplay.setMap(map);
    directionsService.route(request, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);
        } else {
            window.alert('Directions request failed due to ' + status);
        }
    });
	for (var i = 0; i <= points.length - 1; i++) {
	  	markers[i] = new google.maps.Marker({
			map: map,
			position: points[i],
		});
	};
}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwgQwhMxIar1UU0YIQJMbgnfWK4vld17A&callback=initMap"></script>