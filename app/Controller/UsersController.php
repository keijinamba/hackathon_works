<?php
App::uses('AppController', 'Controller');
class UsersController extends AppController{
	public $uses = array('User');
	public $components = array('Session', 'Auth');

	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('signup', 'login');
	}

	public function index() {
		
	}
	public function signup() {
		if($this->request->is('post') && $this->User->save($this->request->data)){
			$this->Auth->login();
            $this->redirect('index');
		}
	}
	public function login() {
		if($this->request->is('post')) {
	        if($this->Auth->login())
	        	return $this->redirect('mypage');
	        else
	        	$this->Session->setFlash('ログイン失敗');
	    }
	}

}