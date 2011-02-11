<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Controllers;

//TODO include abstractbase by default
require_once('AbstractBaseController.php');
require_once('PostController.php');

require_once('Repositories/TabRepository.php');
require_once('Repositories/PageRepository.php');
require_once('Repositories/PostRepository.php');
class TabController extends AbstractBaseController {
	
	var $tabRepository;
	
	public function __construct() {
		$this->tabRepository = new \Pheide\Repositories\TabRepository();
	}
	
	public function showAction(){
		$tabid = $_GET['tabid'];

		$tab = $this->tabRepository->getOneById($tabid);

		if ($tab['type'] == 'blog') {
			$postController = new PostController();
			if ($_GET['postid']) { //TODO let postController decide action
				$content = $postController->showAction();	
			} else {
				$content = $postController->listAction();	
			}
		}
		
		$this->view['content'] = $content;
		$this->view['tab'] = $tab;

		return $this->render('show');
	}
	
	public function newAction(){
		$this->view['newTab'] = 1;
		return $this->render('new');
	}
	
	public function createAction(){
		$tab = $_POST['tab'];

		$tabid = $this->tabRepository->insert($tab);
		$this->redirect('show','',array('pageid' => $tab['pageid'], 'tabid' => $tabid));
	}
	
	public function updateAction(){
		$tab = $_POST['tab'];
		
		$this->tabRepository->update($tab);
		$this->redirect('show','',array('pageid' => $tab['pageid'], 'tabid' => $tab['uid']));
	}
	
	public function deleteAction(){
		$tabid = $_GET['tabid'];
		$pageid = $_GET['pageid'];
		
		$this->tabRepository->delete(array('uid' => $tabid));
		$this->redirect('show','Page',array('pageid' => $pageid));
	}
	
	public function shiftAction(){
		$tabid = $_GET['tabid'];
		$direction = $_GET['direction'];
		
		$this->tabRepository->shift($tabid, $direction);
		$this->redirect('show','',array('tabid' => $tabid));
	}
	
	public function render($view){
		$pageid = $_GET['pageid'];

		if(!$pageid){
			$pageid = $this->view['tab']['pageid'];
		}
		
		$this->view['tabs'] = $this->tabRepository->getAllForPageid($pageid);
		$pageRepository = new \Pheide\Repositories\PageRepository();
		$this->view['page'] = $pageRepository->getOneById($pageid);
		return parent::render($view);
	}
	
	
	
}
 
?>
