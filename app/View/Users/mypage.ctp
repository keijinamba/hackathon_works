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

<?php if ($facebooks): ?>
<div class="facebook_wrapper">
    <?php foreach ($facebooks as $facebook): ?>
<iframe src="https://www.facebook.com/plugins/post.php?href=<?php echo $facebook['url']; ?>?pnref=story&width=400" width="400" height="142" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<div id="fb-root"></div>
<script>(function(d, s, id) {
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) return;
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.6&appId=531354500384473";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <?php endforeach; ?>
</div>
<div class="facebook_modal unshow">
    <?php foreach ($facebooks as $facebook) : ?>
        <div class="modal unshow modal<?php echo $facebook['Content']['id'] ?>">
            <blockquote class="twitter-facebook" data-lang="ja"><a href="<?php echo $facebook['Content']['url'] ?>"></a></blockquote>
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


var facebooks = <?php echo json_encode($facebooks); ?>;
var facebook_points = [];
var facebook_ids = [];
for (var i = 0; i <= facebooks.length - 1; i++) {
    if ('lat' in facebooks[i]['Content'] && 'lng' in facebooks[i]['Content']) {
        facebook_points.push({lat: Number(tweets[i]['Content']['lat']), lng: Number(facebooks[i]['Content']['lng'])});
        facebook_ids.push(facebooks[i]['Content']['id']);
    };
};



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
		optimizeWaypoints: true,
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



var flag = true;
    for (var i = 0; i <= facebook_points.length - 1; i++) {
        flag = true;
        for(var j = 0; j <= tweet_points.length -1; j++) {
            if(facebook_points[i]==tweet_points[j]){
                flag = false;
            }
        }
        if(flag){
              markers[i] = new google.maps.Marker({
                map: map,
                animation: google.maps.Animation.DROP,
                position: facebook_points[i],
                anchorPoint: new google.maps.Point( 0 , -24 )
            });
          }
    };
    for (var i = 0; i <= facebook_points.length - 1; i++) {
        google.maps.event.addListener( markers[i] , 'click' , (function(i) {
            return function() {
            $('.facebook_modal .modal' + facebook_ids[i]).fadeIn('slow');
            $('.facebook_modal .modal' + facebook_ids[i]).addClass('active');
            $('.facebook_modal').addClass('modal-back');
            $('.facebook_modal').fadeIn('slow')};
        })(i));
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