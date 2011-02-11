<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Repositories;

require_once('AbstractBaseRepository.php');
class PageRepository extends AbstractBaseRepository {

	public function __construct() {
		$this->table = 'page';
		$this->dataMap = array(
			'uid' => 'uid',
			'title' => 'title',
			'headerid' => 'headerid',
			'isdefault' => 'isdefault',
		);
	}
	
	public function getDefaultId(){
		return $this->select('uid',array('isdefault' => 1),1);
	}
	
	public function getAll(){
		$pages = $this->select('*');
		$pagesByKey = array();
		foreach($pages as $page){
			$pagesByKey[$page['headerid']] = $page;
		}
		return $pagesByKey;
	}
	
	public function getOneById($pageid){
		return $this->select('*',array('uid'=>$pageid),1);
	}

	public function update($page) {
		parent::updateAll(array('isdefault' => 0));
		$page['isdefault'] = $page['isdefault'] ? 1 : 0;
		parent::update($page);
	}
	
}
?>
