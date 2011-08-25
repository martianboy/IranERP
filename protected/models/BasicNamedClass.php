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
 * 						"MgT"="MagazineType",
 * 						"Siz"="Size",
 * 						"Yea"="Year",
 * 						"Mag"="MagNo",
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
	/**
	 * @scField(name="id",primaryKey=true,hidden=true,type="integer")
	 */
	public function getID(){return $this->id;}
	public function setID($newid){$this->id=$newid;}
	/**
	 * @scField(name="Name",type="string",title="نام")
	 */
	public function getName(){return $this->Name;}
	public function setName($newName){$this->Name=$newName;}
	/**
	 * @scField(name="Description",type="string",title="شرح")
	 */
	public function getDescription(){return $this->Description;}
	public function setDescription($newDesc){$this->Description=$newDesc;}
	
}
?>