<?php
App::uses('AppController', 'Controller');
class ApiController extends AppController{
	public $uses = array('Location');

	public function getJson() {
		$data = $this->request->data;
		if (!$data) {
			return
		}
		if (!isset($data['user']) || !$data['user']) {
			return
		}
		if (!isset($data['lat']) || !$data['lat']) {
			return
		}
		if (!isset($data['lon']) || !$data['lon']) {
			return
		}
		if (!isset($data['time']) || !$data['time']) {
			return
		}
		$this->Location->create();
		$this->Location->save(array(
			'user_id' => $data['user'],
			'lat' => $data['lat'],
			'lng' => $data['lon'],
			'time' => date("Y-m-d H:i:s", $data['time'])
		));
	}
}