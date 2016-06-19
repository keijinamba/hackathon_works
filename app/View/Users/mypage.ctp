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
<?php if ($tweets) : ?>
<div class="twitter_wrapper">
	<?php foreach ($tweets as $tweet) : ?>
	<blockquote class="twitter-tweet" data-lang="ja"><a href="<?php echo $tweet['Content']['url'] ?>"></a></blockquote>
    <?php endforeach ; ?>
</div>
<div class="twitter_modal unshow">
	<?php foreach ($tweets as $tweet) : ?>
	<div class="modal unshow modal<?php echo $tweet['Content']['id'] ?>">
	    <blockquote class="twitter-tweet" data-lang="ja"><a href="<?php echo $tweet['Content']['url'] ?>"></a></blockquote>
    </div>
    <?php endforeach ; ?>
</div>
<?php endif ; ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<script type="text/javascript">
var tweets = <?php echo json_encode($tweets); ?>;
var tweet_points = [];
var tweet_ids = [];
for (var i = 0; i <= tweets.length - 1; i++) {
	if ('lat' in tweets[i]['Content'] && 'lng' in tweets[i]['Content']) {
		tweet_points.push({lat: Number(tweets[i]['Content']['lat']), lng: Number(tweets[i]['Content']['lng'])});
		tweet_ids.push(tweets[i]['Content']['id']);
	};
};
function initMap() {
	var map;
	var directionsDisplay = new google.maps.DirectionsRenderer;
	var directionsService = new google.maps.DirectionsService;
	var markers = [];
	var points = <?php echo json_encode($locations); ?>;
	if (points && points.length > 2) {
		for (var i = 0; i <= points.length - 1; i++) {
			points[i]['']
		};
		var waypoints = [];
		for (var i = 0; i <= points.length - 1; i++) {
			if (i != 0 && i != points.length - 1) {
				waypoints[i - 1] = {
			        location:points[i],
			        stopover:false
			    }
			};
		};
		var request = {
		    origin:points[0],
		    destination:points[points.length - 1],
		    waypoints: waypoints,
			optimizeWaypoints: true,
		    travelMode: google.maps.TravelMode.DRIVING
	    };
	    map = new google.maps.Map(document.getElementById('map'), {
	        center: points[points.length - 1],
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
		for (var i = 0; i <= tweet_points.length - 1; i++) {
		  	markers[i] = new google.maps.Marker({
				map: map,
				animation: google.maps.Animation.DROP,
				position: tweet_points[i],
				anchorPoint: new google.maps.Point( 0 , -24 )
			});
		};
		for (var i = 0; i <= tweet_points.length - 1; i++) {
			google.maps.event.addListener( markers[i] , 'click' , (function(i) {
				return function() {
				$('.twitter_modal .modal' + tweet_ids[i]).fadeIn('slow');
				$('.twitter_modal .modal' + tweet_ids[i]).addClass('active');
				$('.twitter_modal').addClass('modal-back');
				$('.twitter_modal').fadeIn('slow')};
			})(i));
		};
	} else {
		map = new google.maps.Map(document.getElementById('map'), {
	        center: {lat:35.684760, lng:139.752882},
	        zoom: 8
	    });
	};
}
$(document).on('click', '.twitter_modal', function() {
	$('.twitter_modal .active').hide();
	$('.twitter_modal .active').removeClass('active');
	$('.twitter_modal').removeClass('modal-back');
	$('.twitter_modal').hide();
});
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwgQwhMxIar1UU0YIQJMbgnfWK4vld17A&callback=initMap"></script>