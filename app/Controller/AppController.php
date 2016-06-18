<?php

App::uses('Controller', 'Controller');
class AppController extends Controller {
	public function beforeFilter() {
        $this->_load_authUser();
        $this->_load_isMobile();
    }
    public function _load_authUser(){
        $authUser = $this->Auth->user();
        $this->authUser = $authUser;
        $this->set('authUser',$authUser);
    }
    protected function _load_isMobile(){
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            $isMobile=false;
        }else{
            $ua=$_SERVER['HTTP_USER_AGENT'];
            $isMobile=((strpos($ua,'iPhone')!==false)||(strpos($ua,'iPod')!==false)||(strpos($ua,'Android')!==false));
        }
        $this->isMobile = $isMobile;
        $this->set('isMobile', $isMobile);
    }
}
