<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Controllers;

//TODO include abstractbase by default
require_once('AbstractBaseController.php');

require_once('Repositories/PostRepository.php');
require_once('Repositories/TabRepository.php');
require_once('Repositories/PageRepository.php');
class PostController extends AbstractBaseController {
	
	public function __construct(){
		$this->controllerName = 'Post';
		$this->postRepository = new \Pheide\Repositories\PostRepository();
	}
	
	public function createAction(){
		$post = $_POST['post'];
		
		$this->postRepository->insert($post);
		$this->redirect('show','Tab',array('tabid' => $post['tabid']));
	}
	
	public function updateAction(){
		$post = $_POST['post'];
		
		$this->postRepository->update($post);
		$this->redirect('show','Tab',array('tabid' => $post['tabid']),'#post'.$post['uid']);
	}
	
	public function deleteAction(){
		$postid = $_GET['postid'];
		$tabid = $_GET['tabid'];
		
		$this->postRepository->delete(array('uid' =>$postid));
		$this->redirect('show','Tab',array('tabid' => $tabid));
	}
	
	public function listAction(){
		$tabid = $_GET['tabid'];

		$this->view['posts'] = $this->postRepository->getAllForTabid($tabid);
		$tabRepository = new \Pheide\Repositories\TabRepository();
		$this->view['tab'] = $tabRepository->getOneById($tabid);

		return $this->render('list');
	}
	
	public function showAction() {
		$postid = $_GET['postid'];
		
		$this->view['post'] = $this->postRepository->getOneById($postid);
		
		return $this->render('show');
	}
	
	public function rssAction() {
		$tabid = $_GET['tabid'];
		
		$tabRepository = new \Pheide\Repositories\TabRepository();
		$tab = $tabRepository->getOneById($tabid);
		$pageRepository = new \Pheide\Repositories\PageRepository();
		$page = $pageRepository->getOneById($tab['pageid']);
		
		$this->view['page'] = $page;
		$this->view['tab'] = $tab;
		$this->view['posts'] = $this->postRepository->getAllForTabid($tabid);

		header('Content-type: application/rss+xml');
		return $this->render('rss');
	}
	
}
 
?>
