<?php
declare(ENCODING = 'utf-8');
namespace Pheide;

require_once('Repositories/PageRepository.php');
require_once('Repositories/TabRepository.php');

class Router {
	
	var $baseUrl = 'http://localhost/scratch';
	
	public function route(){
		//handle mod_rewrite params
		if ($_GET['rewrite']) { // only present when "go" is in URL, see htaccess
			$requestStr = $_GET['rewrite'];
			if (substr($requestStr,-1) == '/') $requestStr = substr($requestStr,0,strlen($requestStr) - 1);
			$requestStr = $this->rereadUrl($requestStr);
			$requestParts = explode('/',$requestStr);
			
			if ($pageTitle = $requestParts[0]) {
				$pageRepository = new \Pheide\Repositories\PageRepository();
				$page = $pageRepository->getOneByTitle($pageTitle);
				$_GET['pageid'] = $page['uid'];
			}
			if ($tabTitle = $requestParts[1]) {
				$tabRepository = new \Pheide\Repositories\TabRepository();
				$tab = $tabRepository->getOneByTitle($tabTitle);
				$_GET['tabid'] = $tab['uid'];
			}
			if ($requestParts[2] == 'post') {
				$postTitle = $requestParts[3];
				$postRepository = new \Pheide\Repositories\PostRepository();
				$post = $postRepository->getOneLikeTitle($postTitle);
				$_GET['postid'] = $post['uid'];
			}
			
			if ($pageTitle) {
				if ($tabTitle) {	
					if ($postTitle) {
						$_GET['action'] = 'show';
						$_GET['controller'] = 'Tab';
					} else {
						$_GET['action'] = 'show';
						$_GET['controller'] = 'Tab';
					}
				} else {
					$_GET['action'] = 'show';
					$_GET['controller'] = 'Page';	
				}
			}
		}
		
		$controllerName = $_POST['controller'] ?: $_GET['controller'];
		$actionName = $_POST['action'] ?: $_GET['action'];
		
		//defaults
		if (!$controllerName) $controllerName = 'Page';
		if (!$actionName) $actionName = 'show';

		require('Controllers/'.$controllerName.'Controller.php');
		$controllerClassName = '\\Pheide\\Controllers\\'.$controllerName.'Controller';
		$controller = new $controllerClassName();
		$controller->actionName = $actionName;
		$controller->controllerName = $controllerName;
		$controller->callAction();
	}
	
	public function actionLink($controllerName,$actionName,$queryParams = array(),$hash='') {
		$url = $this->baseUrl;
		
		//TODO improve URL handling
		if (!$controllerName) return $url;
		
		//handle query params
		if ($queryParams['tabid'] && !$queryParams['pageid']) {
			$tabRepository = new \Pheide\Repositories\TabRepository();
			$tab = $tabRepository->getOneById($queryParams['tabid']);
			$queryParams['pageid'] = $tab['pageid'];
		}
		
		$urlParts = array();
		if ($actionName == 'show' && $queryParams['pageid']) {
			$urlParts[] = 'go';
			
			$pageRepository = new \Pheide\Repositories\PageRepository();
			$page = $pageRepository->getOneById($queryParams['pageid']);
			$urlParts[] = $page['title'];
			
			if ($queryParams['tabid']) {
				$tabRepository = new \Pheide\Repositories\TabRepository();
				$tab = $tabRepository->getOneById($queryParams['tabid']);
				$urlParts[] = $tab['title'];
				
				if ($queryParams['postid']) {
					$postRepository = new \Pheide\Repositories\PostRepository();
					$post = $postRepository->getOneById($queryParams['postid']);
					$urlParts[] = 'post';
					$urlParts[] = $post['title'];
				}
			}
			$url .= $this->rewriteUrl($urlParts);	
		} else {
			$url .= '/?controller='.$controllerName.'&action='.$actionName;
			if ($queryParams) {
				$url .= '&'.$this::my_http_build_query($queryParams);
			}
		}
		
		
		if ($hash) {
			$url .= $hash;
		}
		return $url;
	}
	
	static function my_http_build_query($queryParams){
		return str_replace('&amp;','&',http_build_query($queryParams));
	}
	
	private function rewriteUrl($urlParts) {
		$url = '';
		if ($urlParts) {
			foreach ($urlParts as $part) {
				//double-encode "/" due to a bug in chrome
				$url .= '/'.urlencode(str_replace('/','%2f',str_replace(' ','-',str_replace('-','|',$part))));
			}
		}
		return strtolower($url);
	}
	
	private function rereadUrl($part) {
		return urldecode(str_replace('|','-',str_replace('-',' ',$part)));
	}

	
}
