<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController{
	public $uses = array('User', 'Content', 'Location');
	public $components = array('Session', 'Auth');

	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('signup', 'login');
	    $this->set('auth',$this->Auth);
	}
	public function signup() {
		if($this->request->is('post') && $this->User->save($this->request->data)){
			$this->Auth->login();
            $this->redirect('mypage/'.$this->Auth->user('id'));
		}
	}
	public function login() {
		if($this->request->is('post')) {
	        if($this->Auth->login())
	        	return $this->redirect('mypage/'.$this->Auth->user('id'));
	        else
	        	$this->Session->setFlash('ログイン失敗');
	    }
	}
	 public function logout(){
	    $this->Auth->logout();
	    $this->redirect('/');
    }
    public function mypage($id) {
		$user = $this->User->findById($id);
		$this->set('user', $user);
		$date = (isset($_GET['date']) && $_GET['date'])? new DateTime($_GET['date'].' 23:59:59') : new DateTime();
		$tweets = $this->Content->find('all', array('conditions'=>array('user_id'=>$id,'type'=>'twitter','posted <='=>$date->format('Y-m-d H:i:s'),'posted >='=>$date->format('Y-m-d 00:00:00'))));
		for ($i=0; $i < count($tweets) - 1; $i++) {
			$point = $this->Location->find('first', array('conditions'=>array('time <='=>$tweets[$i]['Content']['posted']),'order'=>array('time'=>'desc')));
			if (!$point) { continue; }
			$tweets[$i]['Content']['lat'] = $point['Location']['lat'];
			$tweets[$i]['Content']['lng'] = $point['Location']['lng'];
		}
		$this->set('tweets', $tweets);
	}
	public function getData() {
		$this->autoRender = false;
		$message = ($this->request->data) ? "got it" : "error";
		return json_encode(array($this->request->data['date']));
	}
}