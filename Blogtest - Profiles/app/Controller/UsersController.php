<?php
class UsersController extends AppController{

	public function login(){
		if(!empty($this->data) && $id = $this->Auth->user('id')){
			$url = array('controller'=>'profiles', 'action'=>'index');
			if($this->Session->check('Auth.redirect')){
				$url = $this->Session->read('Auth.redirect');
			}
			return $this->redirect(array('controller'=>'profiles','action'=>'profile'));
		}
	}
	
	public function logout(){
		return $this->redirect($this->Auth->logout());
	}
	
	public function register(){
		if(!empty($this->data)){
			$this->User->create();
			$this->Auth->hash($password);
			if($this->User->save($this->data)){
				$this->Session->setFlash(__('Account successfully created.'));
				return $this->redirect(array('controller'=>'posts','action'=>'index'));
			}
			else{
				$this->Session->setFlash(__('Invalid account information. Please try again.'));
			}
		}
	}
}
?>