<?php
App::uses('AppModel', 'Model');
class Content extends AppModel {
    public $name = 'Content';
    public $useTable = 'contents';

    public function getTwitter($user_id) {
    	App::uses('User', 'Model');
    	$this->User= new User();
    	$user = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id)));
        $last_tweet = $this->find('first', array('conditions'=>array('user_id'=>$user['User']['id'],'type'=>'twitter'),'order'=>array('created'=>'desc')));

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

    public function getFacebook($user_id)
    {
        $user = $this->User->find('first', array('conditions'=>array('User.id'=>$user_id)));
        $last_face = $this->find('first', array('conditions'=>array('user_id'=>$user['User']['id'],'type'=>'facebook'),'order'=>array('created'=>'desc')));
        define('APP_ID', "723725144433672");
        define('APP_TOKEN', "EAACEdEose0cBAHgr4a0HSftwhDhobFgqNHhQJo2CSms89rXhi08ZAF3RGGmwhtJub29tqqfDyI6ma6nZAzOUwFSvtqarULl0ZBRIpo6gqx8nrksPurZCMzVzzfsXiL4ItL5jNav0I0NTOaZBIxuq0vqEykeQgLKQ2YaUX272DoQZDZD");
        $url = "https://graph.facebook.com/v2.3/".APP_ID."/feed?access_token=".APP_TOKEN;
        $ch = curl_init();
        curl_setopt_array($ch,
         array(
         CURLOPT_URL => $url,
         CURLOPT_SSL_VERIFYPEER =>false,
         CURLOPT_RETURNTRANSFER =>true,
         )
         );
        $res = curl_exec($ch);
        curl_close($ch);
        //json整形
        $array = json_decode($res, TRUE);
         
        $fb_data = array(); //投稿内容を入れる配列です
        $times = array(); //投稿時間を入れる配列です
        $i = 0;
        while(1==1){
         $urls = $array['data'][$i]['id'];
         $url_array = explode("_", $urls);
         $times[$i] = substr($array['data'][$i]['created_time'], 0, strcspn($array['data'][$i]['created_time'],'T'));
         $date = new DateTime($times[$i]);
         $times[$i] = $date->format('Y-m-d H:i:s');
         if (isset($last_face['Content']['created']) && $last_face['Content']['created']) {
             $now = $date->format($last_face['Content']['created']);
         }else{
             $now = $date->format('2016-06-01 00:00:00');
         }
         if($times[$i]<$now)break;
        $this->create();
        $this->save(array(
            "user_id" => $user_id,
            "url" => "https://www.facebook.com/".$url_array[0]."/posts/".$url_array[1],
            "type" => "facebook",
            "posted" => $times[$i]
        ));
         $i += 1;
        }
    }
}