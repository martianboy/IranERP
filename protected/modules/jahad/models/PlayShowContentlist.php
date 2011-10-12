<?php
namespace IRERP\modules\jahad\models;

use IRERP\Basics\Models\IRDataModel;

use IRERP\Basics\Models\BasicNamedClass;
use IRERP\Basics\Annotations\scField;

/**
 * @Entity
 * 
 * @author masoud
 *
 */
class PlayShowContentlist extends IRDataModel
{
	/**
	 * @ManyToOne(targetEntity="PlayShow",inversedBy="PlayShowContentlists")
	 */
	protected $PlayShow;
	public function getPlayShowName()
	{
	try {return $this->PlayShow->getPlayShowName();}catch(\Exception $ex){return '';}
	}
   public function setPlayShowName($v){}
public function getPlayShowID(){
	try {return $this->PlayShow->getid();}catch(\Exception $ex){return NULL;}
	}
	public function setPlayShowID($v){
	try {
		$this->PlayShow=new PlayShow();
		$this->PlayShow= $this->PlayShow->GetByID($v);
	}catch(\Exception $ex){}
	}
	/**
	 * @Column(type="string",length=50)
	 */
	protected $ContentTitle;
	/**
	 * 
	 * @scField(name="ContentTitle",type="string",title="آیتم",DoctrineField="ContentTitle")
	 */
	public function getContentTitle(){
	try {return $this->ContentTitle;}catch(\Exception $ex){return '';}
	}
	public function setContentTitle($v){$this->ContentTitle=$v;}
	
	/**
	 * @Column(type="string",length=500)
	 */
	protected $Description;
	/**
	 * 
	 * @scField(name="Description",type="string",title="توضیح",DoctrineField="Description")
	 */
	public function getDescription(){
	try {return $this->Description;}catch(\Exception $ex){return '';}
	}
	public function setDescription($v){$this->Description=$v;}
	
}
?>