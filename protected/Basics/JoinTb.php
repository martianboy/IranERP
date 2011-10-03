<?php
namespace IRERP\Basics;
/*
 *  array structure array('Class'=>TargetClassName,
 * 									'Prop'=>TargetProperty,
 * 									'PropClass'=>propclass
 * 									'whstr'=>WhereString,
 * 									'whparam'=>array,
 * 									'HelpField'=>array('Type'=>['Value' or 'function'],
 * 									
 */
class JoinTb
{
	
	protected $Class='';
	protected $Prop='';
	protected $PropClass='';
	protected $whstr='';
	protected $whparam=array();
	protected $HelpField=array();
	public function __construct($JoinTBArray=NULL){
		if(isset($JoinTBArray)){
			if(isset($JoinTBArray['Class'])) $this->Class=$JoinTBArray['Class'];
			if(isset($JoinTBArray['Prop'])) $this->Prop=$JoinTBArray['Prop'];
			if(isset($JoinTBArray['whstr'])) $this->whstr=$JoinTBArrayp['whstr'];
			if(isset($JoinTBArray['whparam'])) $this->whparam=$JoinTBArray['whparam'];
			if(isset($JoinTBArray['HelpField'])) $this->HelpField=$JoinTBArray['HelpField'];
			if(isset($JoinTBArray['PropClass'])) $this->PropClass=$JoinTBArray['PropClass'];
			
		}
	}
	
	public function getClass(){return $this->Class;}
	public function setClass($v){$this->Class=$v;}
	
	public function getProp(){return $this->Prop;}
	public function setProp($v){$this->Prop=$v;}
	
	public function getPropClass(){return $this->PropClass;}
	public function setPropClass($v){$this->PropClass=$v;}

	public function getPropClassInstance($em=NULL){
		$r = new \ReflectionClass($this->getPropClass());
		return $r->newInstance($em);
	}
	
	public function getClassInstance($em=NULL){
		$r = new \ReflectionClass($this->getClass());
		return $r->newInstance($em);
	}
	
	public function getWhereString(){return $this->whstr;}
	public function setWhereString($v){$this->whstr=$v;}
	
	public function getWhereParam(){return $this->whparam;}
	public function setWhereParam($v){$this->whparam=$v;}

	public function getHelpFieldType(){return $this->HelpField['Type'];}
	public function setHelpFieldType($v){$this->HelpField['Type']=$v;}
	
	public function getHelpField(){
	switch ($this->getHelpFieldType()){
		case 'Value':
			return $this->HelpField['Value'];
			break;
	}
	}
	public function setHelpField($v){
	switch ($this->getHelpFieldType()) {
		case 'Value':
			$this->HelpField['Value']=$v;
			break;
	}
	}
	
	
}