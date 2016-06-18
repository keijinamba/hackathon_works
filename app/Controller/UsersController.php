<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController{
	public $uses = array('User');
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
	}

}