<?php
App::uses('AppModel', 'Model');
class Content extends AppModel {
    public $name = 'Content';
    public $useTable = 'contents';

    public function getTwitter($user_id) {
    	App::uses('User', 'Model');
    	$this->User= new User();
    	$user = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id)));
        $last_tweet = $this->find('first', array('conditions'=>array('user_id'=>$user['User']['id']),'order'=>array('created'=>'desc')));

    	App::import('Vendor','twitteroauth');
    	// require_once('/var/www/html/cakephp/app/Vendor/OAuth.php');
		define('CONSUMER_KEY','WUi3HC8Nt2amNXNnAugyFGBDW');
		define('CONSUMER_SECRET','iBsZvAHP44qKoZxeI3o5MAFjDRRT66k8WA4fHUN4NZefyW3lvR');
		define('ACCESS_TOKEN','2900443688-XZVY5OjtWOEAXE7SpW0vDTfgFkxF3RacFyREUQt');
		define('ACCESS_TOKEN_SECRET','B4KPrmLPiCbBbCSBcIIrD5Jb3e7cEQyDX3yA2CkYcpyNg');
		$consumerKey = CONSUMER_KEY;
		$consumerSecret = CONSUMER_SECRET;
		$accessToken = ACCESS_TOKEN;
		$accessTokenSecret = ACCESS_TOKEN_SECRET;
		$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
		if (isset($last_tweet['Content']['created']) && $last_tweet['Content']['created']) {
			$req = $twObj->OAuthRequest("https://api.twitter.com/1.1/statuses/user_timeline.json","GET",array("count"=>10,"screen_name"=>$user['User']['twitter_id'],"trim_user"=>true,'since'=>$last_tweet['Content']['created']));
		} else {
			$req = $twObj->OAuthRequest("https://api.twitter.com/1.1/statuses/user_timeline.json","GET",array("count"=>10,"screen_name"=>$user['User']['twitter_id'],"trim_user"=>true,'since'=>'2016-06-17'));
		}
		$tw_arr = json_decode($req);
		$this->log($tw_arr, LOG_DEBUG);
		if (isset($tw_arr)) {
		    foreach ($tw_arr as $key => $val) {
		    	$date = new DateTime($val->created_at);
 				$datetime = $date->format('Y-m-d H:i:s');
		    	$this->create();
				$this->save(array(
					"user_id" => $user_id,
					"url" => "https://twitter.com/".$user['User']['twitter_id']."/status/".$val->id,
					"type" => "twitter",
					"posted" => $datetime
				));
		        // echo $tw_arr[$key]->id;
		        // echo '<br>';
		        // echo $tw_arr[$key]->text;
		        // echo '<br>';
		        // echo $tw_arr[$key]->created_at;
		        // echo '<br>';
		    }
		}
    }
}