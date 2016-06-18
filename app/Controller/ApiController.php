<?php
App::uses('AppController', 'Controller');
class ApiController extends AppController{
	public $uses = null;

	public function getJson() {
		if ($this->request->data) {
			return json_encode(array('got it !'));
		}
		return json_encode(array('failed !'));
	}
}