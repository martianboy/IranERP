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
class FilmContentlist extends IRDataModel
{
	/**
	 * @ManyToOne(targetEntity="Film",inversedBy="FilmContentlists")
	 */
	protected $Film;
	public function getFilmName()
	{
	try {return $this->Film->getFilmName();}catch(\Exception $ex){return '';}
	}
   public function setFilmName($v){}
public function getFilmID(){
	try {return $this->Film->getid();}catch(\Exception $ex){return NULL;}
	}
	public function setFilmID($v){
	try {
		$this->Film=new Film();
		$this->Film= $this->Film->GetByID($v);
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