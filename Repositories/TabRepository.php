<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Repositories;

require_once('AbstractBaseRepository.php');
require_once('PostRepository.php');
class TabRepository extends AbstractBaseRepository {
	
	public function __construct() {
		$this->table = 'tab';
		$this->dataMap = array(
			'uid' => 'uid',
			'pageid' => 'pageid',
			'title' => 'title',
			'aside' => 'aside',
			'content' => 'content',
			'sorting' => 'sorting',
			'type' => 'type',
		);
	}
	
	public function getAllForPageid($pageid){
		return $this->select('uid,title',array('pageid' => $pageid),null,array('sorting' => 'ASC'));
	}
	
	public function getDefaultIdForPageid($pageid){
		return $this->select('uid',array('pageid' => $pageid),1,array('sorting' => 'ASC'));
	}
	
	public function getOneById($tabid){
		return $this->select('*',array('uid' => $tabid),1);
	}
	
	public function delete($tab){
		parent::delete(array('uid' => $tab['uid']));
		$postRepository = new \Pheide\Repositories\PostRepository();
		$postRepository->delete(array('tabid' =>$tab['uid']));
	}
	
	public function shift($tabid, $direction){
		//TODO has some bugs when sortings become equal
		$tab = $this->select('sorting,pageid',array('uid' => $tabid),1);
		if ($direction == 'left') {
			$nextTab = $this->select('uid,sorting',array('pageid' => $tab['pageid'], 'sorting' => array('<',$tab['sorting'])),1);
			$newSorting = $tab['sorting'] - 1;
		} else {
			$nextTab = $this->select('uid,sorting',array('pageid' => $tab['pageid'], 'sorting' => array('>',$tab['sorting'])),1);	
			$newSorting = $tab['sorting'] + 1;
		}
		
		if ($nextTab) {
			$this->update(array('uid' => $nextTab['uid'],'sorting' => $tab['sorting']));
		}
		$this->update(array('uid' => $tabid, 'sorting' => $newSorting));
	}
	
	public function multiplySortings($pageid){
		//quadruple each sorting value	
		$tabs = $this->select('uid,sorting',array('pageid' => $pageid));
		for($i=0; $i < count($tabs); $i++){
			$tabs[$i]['sorting'] = 4 * $tab[$i]['sorting'];	
		}
		$this->update($tabs);
	}
	
}
?>
