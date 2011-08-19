<?php
require_once 'DBEntity.php';


/**
 * @Entity 
 * @Table(indexes={@Index(name="indx_Descrim",columns={"classname"})})
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="classname", type="string")
 * @DiscriminatorMap({
 * 						"TVR"="TVRD",
 * 						"Mat"="Matter",
 * 					  	"Tit"="Title",
 * 						"MgT"="Magazine_Type",
 * 						"Siz"="Size",
 * 						"Yea"="Year",
 * 						"Mag"="Mag_No",
 * 						"Aui"="Auidunce",
 * 						"Nat"="Nationality",
 * 						"Sta"="State",
 * 						"BNC"="BasicNamedClass"
 * 					})
 */

class BasicNamedClass extends DbEntity
{

	 /**
     * @Column(type="string",length=50)
     * @var string
     */
	protected $Name;
	 /**
     * @Column(type="string",length=1000,nullable=true)
     * @var string
     */
	protected $Description;
	 /*
     * @var string
     * Column(type="string",length=15)
     */
	protected $classname;
	
	
	/*******************
	 * BL Functions
	 */
	public function getID(){return $this->id;}
	public function setID($newid){$this->id=$newid;}
	
	public function getName(){return $this->Name;}
	public function setName($newName){$this->Name=$newName;}
	
	public function getDescription(){return $this->Description;}
	public function setDescription($newDesc){$this->Description=$newDesc;}

	
	/****************************
	 * Smart Client DataSource Generator Functions
	 */
	/**
	 * @scField(name="id",primaryKey=true,hidden=true,type="integer")
	 */
	public function scgetid(){return $this->getID() ;}
	public function scsetid($newid){$this->setID($newid);}
	/**
	 * @scField(name="Name",type="string",title="نام")
	 */
	public function scgetName(){return $this->getName();}
	public function scsetName($newName){$this->setName($newName);}
	/**
	 * @scField(name="Description",type="string",title="شرح")
	 */
	public function scgetDescription(){return $this->getDescription();}
	public function scsetDescription($newDesc){$this->setDescription($newDesc);}
	
	
	
}
?>