<?php
declare(ENCODING = 'utf-8');
namespace Pheide\Models;

class Tab {
	
	var $title;
	var $linkTitle;
	var $headerid;
	var $isdefault;
	
	//TODO magic
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setLinkTitle($linkTitle){
		$this->title = $title;
	}
	
	public function getLinkTitle(){
		return $this->linkTitle;
	}
	
	public function setheaderid($headerid){
		$this->headerid = $headerid;
	}
	
	public function getheaderid(){
		return $this->headerid;
	}
	
	public function setisdefault($isdefault){
		$this->isdefault = $isdefault;
	}
	
	public function getisdefault(){
		return $this->isdefault;
	}
	
}
?>
