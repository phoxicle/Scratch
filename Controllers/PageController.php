<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Controllers;

//TODO include abstractbase by default
require_once('AbstractBaseController.php');

require_once('Repositories/PageRepository.php');
require_once('Repositories/TabRepository.php');
class PageController extends AbstractBaseController {
	
	//TODO removePage
	public function __construct(){
		$this->pageRepository = new \Pheide\Repositories\PageRepository();
	}
	
	public function updateAction(){
		$page = $_POST['page'];
		
		$this->pageRepository->update($page);

		$this->redirect('show','',array('pageid' => $page['uid']));
	}
	
	public function createAction(){
		$page = $_POST['page'];
		
		$pageid = $this->pageRepository->insert($page);

		$this->redirect('show','',array('pageid' => $pageid));
	}
	
	public function showAction(){
		$pageid = $_GET['pageid'];

		if ($pageid) {
			$tabRepository = new \Pheide\Repositories\TabRepository();
			$tabid = $tabRepository->getDefaultIdForPageid($pageid);
			if ($tabid) { // go to default tab
				$this->redirect('show','Tab',array('pageid' => $pageid,'tabid' => $tabid));		
			} else { // no tabs available
				$this->redirect('new','Tab',array('pageid' => $pageid));
			}
		} else if ($pageid = $this->pageRepository->getDefaultId()) { // go to default page
			$this->redirect('show','Page',array('pageid' => $pageid));
		} else { // no pages yet
			$this->redirect('new');	
		}
	}
	
	public function newAction(){
		$headerid = $_GET['headerid'];
		
		$this->view['page']['headerid'] = $headerid;
		$this->view['newPage'] = true;
		$this->render('new');
	}
	
}
 
?>
