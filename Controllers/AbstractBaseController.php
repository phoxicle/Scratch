<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Controllers;
 
require_once('Repositories/PageRepository.php'); 
require_once('Router.php'); 

class AbstractBaseController {
	
	var $view = array();
	var $actionName;
	var $controllerName;
	var $authenticated;
	
	var $unrestrictedActionsArr = array(
		'Page' => array('show'),
		'Tab' => array('show'),
		'Authentication' => array('login','authenticate','restricted'),
		'Post' => array('list','show','rss'),
	);
	
	public function callAction(){
		$this->authenticated = $this->isAuthenticated();
		
		if (!is_array($this->unrestrictedActionsArr[$this->controllerName])
			|| !in_array($this->actionName,$this->unrestrictedActionsArr[$this->controllerName])
				&& !$this->authenticated) {
			$this->redirect('restricted','Authentication');
		}
		
		$this->initializeAction();
		$action = $this->actionName.'Action';
		echo $this->postProcessContent($this->$action());
	}
	
	protected function initializeAction(){
	}
	
	protected function render($view,$controllerName = ''){
		//set vars that all views need
		if (!$controllerName) $controllerName = $this->controllerName;
		$this->view['authenticated'] = $this->isAuthenticated(); // TODO called twice for no reason, need clone function
		
		$pageRepository = new \Pheide\Repositories\PageRepository();
		$this->view['pages'] = $pageRepository->getAll();
		$this->view['router'] = new \Pheide\Router();

		//render the content
		return $this->renderTemplate('Views/'.$controllerName.'/'.$view.'.php',$this->view);
	}
	
	protected function renderTemplate(){
		if (is_array(func_get_arg(1))) {
			extract(func_get_arg(1));
		}
		ob_start();
		require func_get_arg(0);
		$content = ob_get_clean();
		return $content;
	}
	
	protected function postProcessContent($content) {
		//escape HTML appearing inside <pre> tags
		$content = preg_replace_callback(
		  '#\<code\>(.+?)\<\/code\>#s',
		  create_function(
		    '$matches',
		    'return "<code>".htmlspecialchars($matches[1])."</code>";'
		  ),
		  $content
		);
		return $content;	
	}
	
	protected function redirect($actionName,$controllerName = '',$queryParams = array(),$hash = ''){
		if (!$controllerName) $controllerName = $this->controllerName;
		
		
		$router = new \Pheide\Router();
		$url = $router->actionLink($controllerName,$actionName,$queryParams,$hash);
		
		
		header('Location: '.$url);	
	}
	
	private function isAuthenticated() {
		// ###REMOVED###
	}
	
}
 
?>
