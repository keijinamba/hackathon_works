<?php
App::uses('AppController', 'Controller');
class PagesController extends AppController{
	public $uses = null;
	public $components = array('Session', 'Auth');

	public function beforeFilter() {
	    parent::beforeFilter();
	    $this->Auth->allow('index');
	    $this->set('auth',$this->Auth);
	}

	public function index() {
		
	}
}