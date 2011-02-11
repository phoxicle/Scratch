<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Repositories;

class AbstractBaseRepository {
	
	var $table;
	var $dataMap;
	var $connection;
	
	protected function query($query){
		$this->connect();
		$res = mysql_query($query);
		if ($res)
			return $res;
		else {
			echo mysql_error();die();
		}
	}
	
	public function select($fields,$where = array(),$limit = null,$sorting = array()){
		$query = 'SELECT '.$fields.' FROM '.$this->table;
		if ($where) {
			$query .= ' WHERE '.implode(' AND ',$this->buildConstraints($where));
		}
		if ($sorting) {
			$sortings = array();
			foreach($sorting as $key => $direction){
				$sortings[] = $key.' '.$direction;
			}
			$query .= ' ORDER BY '.implode(',',$sortings);
		}
		if ($limit) {
			$query .= ' LIMIT '.$limit;	
		}
		$objs = array();
		if ($res = $this->query($query)) {
			while ($row = mysql_fetch_assoc($res)) {
				$objs[] = $row;
			}	
		}
		if ($limit == 1) {
			if ($fields != '*' && strpos($fields,',') === false) {
				return $objs[0][$fields];
			} else {
				return $objs[0];	
			}
		} else {
			return $objs;	
		}
	}
	
	public function insert($obj){
		$query = 'INSERT INTO '.$this->table.' SET '.implode(',',$this->buildConstraints($obj));
		$res = $this->query($query);
		return mysql_insert_id();
	}
	
	public function update($obj){
		$query = 'UPDATE '.$this->table.' SET '.implode(',',$this->buildConstraints($obj)).' WHERE uid = '.$this->escape($obj['uid']);
		$this->query($query);
	}
	
	public function delete($obj){
		$query = 'DELETE FROM '.$this->table.' WHERE '.implode(' AND ',$this->buildConstraints($obj));
		$this->query($query);
	}

	public function updateAll($obj) {
		$query = 'UPDATE '.$this->table.' SET '.implode(',',$this->buildConstraints($obj));
		$this->query($query);
	}
	
	protected function buildConstraints($obj){
		$constraints = array();
		foreach($obj as $key => $value){
			if (is_array($value)) {
				$constraints[] = $key.$value[0].$this->escape($value[1]);
			} else {
				$constraints[] = $key.'='.$this->escape($value);
			}
		}
		return $constraints;
	}
	
	protected function escape($value){
		$this->connect();
		$value = mysql_real_escape_string($value);
		return is_numeric($value) ? $value : '"'.$value.'"';
	}
	
	protected function connect(){
		if (!$this->connection) {
			$this->connection = mysql_connect('localhost', '###REMOVED###', '###REMOVED###');
			mysql_select_db('scratch', $this->connection);
		}	
	}
	
	public function getOneByTitle($title) {
		return $this->select('*',array('title'=>$title),1);
	}
	
	public function getOneLikeTitle($title) {
		return $this->select('*',array('title'=>array(' LIKE ',$title . '%')),1);
	}
	
}
?>
