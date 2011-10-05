<?php

namespace IRERP\modules\jahad\models;

use IRERP\Basics\Models\IRDataModel;
use IRERP\Basics\Annotations\scField;

/**
 * @Entity
 * @author masoud
 *
 */
class MagazineVersion extends IRDataModel
{
	/**
	 * @ManyToOne(targetEntity="Magazine",inversedBy="magver")
	 * @var Magazine
	 */
	protected $Magazine;
	
	/**
	 * 
	 * @scField(name="Magazineid",DoctrineField="Magazine.id",hidden=true)
	 */
	public function getMagazineid(){
		if(isset($this->Magazine))
		return $this->Magazine->getid();
	}
	public function setMagazineid($d){
		$tmp= new Magazine();
		
		$this->Magazine=$tmp->GetByID($d);
	
	}
	/**
	 * 
	 * @scField(name="MagazineTitle",DoctrineField="Magazine.onvan.Name",title="عنوان مجله")
	 */
	public function getMagazineTitle(){
		if(isset($this->Magazine))
		return $this->Magazine->getTitle()->getName();}
	public function setMagazineTitle(){}
	/**
	 * @Id @generatedValue(strategy="AUTO") @Column(type="integer")
	 * @var integer
	 */
protected $id;

/**
 * @ManyToMany(targetEntity="Size")
 * @var Size[]
 */
protected $Ghate;
public function getGhate(){return $this->Ghate;}
public function setGhate($g){ $this->Ghate=$g;}

/**
 * @ManyToOne(targetEntity="Year")
 * @var Year
 */
protected $year;
public function getYear(){return $this->year;}
public function setYear($g){ $this->year=$g;}

/**
 * 
 * @scField(name="YearID",DoctrineField="year.id",hidden=true)
 */
public function getYearid(){return $this->year->getid();}
public function setYearid($id=NULL){
	if(isset($id)){
		$a = new Year();
	
		$this->year=$a->GetByID($id);
	}
}
/**
 * 
 * @scField(name="YearTitle",DoctrineField="year.Name",title="سال")
 */
public function getYearTitle(){if(isset($this->year))  return $this->year->getName();}
public function setYearTitle($a){} 


/**
 * @ManyToMany(targetEntity="Human")
 * @JoinTable(name="magver_Human_modirmasoul",
 *     		 joinColumns={
 *     					@JoinColumn
 *     								(
 *     									name="magver_id", 
 *     									referencedColumnName="id"
 *     								)
 *     						},
 *      inverseJoinColumns={
 *      				@JoinColumn
 *      							(
 *      							name="human_id",
 *      							referencedColumnName="id"
 *      							)
 *      					}
 *      )
 * 
 * @var Human[]
 */
protected $modirmasoul;
public function getModirMasoul(){return $this->modirmasoul;}
public function setModirMasoul($g){ $this->modirmasoul=$g;}

/**
 * @ManyToMany(targetEntity="Human")
 * @JoinTable(name="magver_Human_nevisandeh",
 *     		 joinColumns={
 *     					@JoinColumn
 *     								(
 *     									name="magver_id", 
 *     									referencedColumnName="id"
 *     								)
 *     						},
 *      inverseJoinColumns={
 *      				@JoinColumn
 *      							(
 *      							name="human_id",
 *      							referencedColumnName="id"
 *      							)
 *      					}
 *      )
 * 
 * @var Human[]
 */
protected $nevisandeh;
public function getNevisandeh(){return $this->nevisandeh;}
public function setNevisandeh($g){ $this->nevisandeh=$g;}

/**
 * @Column(type="string",length=15)
 * @var string
 */
protected $shomare;
/**
 * 
 * @scField(name="Shomare",DoctrineField="shomare",title="شماره")
 */
public function getShomare(){return $this->shomare;}
public function setShomare($g){ $this->shomare=$g;}

/**
 * @Column(type="integer")
 * @var integer
 */
protected $tirajh;

/**
 * 
 * @scField(name="Tirajh",title="تیراژ",DoctrineField="tirajh")
 */
public function getTirajh(){return $this->tirajh;}
public function setTirajh($g){ $this->tirajh=$g;}

/**
 * @ManyToMany(targetEntity="Auidunce")
 * @var Auidunce[]
 */
protected $mokhatab;
public function getMokhatab(){return $this->mokhatab;}
public function setMokhatab($g){ $this->mokhatab=$g;}



}
?>
