<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Controllers;

//TODO include abstractbase by default
require_once('AbstractBaseController.php');

class AuthenticationController extends AbstractBaseController {
	
	public function loginAction(){
		return $this->render('login');
	}
	
	public function authenticateAction(){
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		if ($username == 'meow' && $password == 'aoeuaoeu1') {
			setcookie('user',md5(':)'),0,'/');
			
			$this->redirect('show','Page');	
		} else {
			$this->redirect('restricted');	
		}
	}
	
	public function logoutAction(){
		//TODO not working
		setcookie('user','',0,'/');
		$this->redirect('show','Page');	
	}
	
	public function restrictedAction(){
		return $this->render('restricted');
	}
	
}
 
?>
