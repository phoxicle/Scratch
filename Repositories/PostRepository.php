<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Repositories;

require_once('AbstractBaseRepository.php');
class PostRepository extends AbstractBaseRepository {
	
	public function __construct() {
		$this->table = 'post';
		$this->dataMap = array(
			'uid' => 'uid',
			'tabid' => 'tabid',
			'title' => 'title',
			'date' => 'date',
			'content' => 'content',
		);
	}
	
	public function getAllForTabid($tabid){
		return $this->select('*',array('tabid' => $tabid),null,array('date' => 'DESC'));
	}
	
	public function getOneById($postid){
		return $this->select('*',array('uid' => $postid),1);
	}
	
}
?>
