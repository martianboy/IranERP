<?php
namespace IRERP\modules\jahad\models;

use IRERP\Basics\Models\IRDataModel,
    IRERP\Basics\Annotations\scField;

/**
 * @Entity @Table(name="Human")
 */
class Human extends IRDataModel
{
	/**
	 * @Column(type="string",length=50)
	 */
	protected $fname;

	/**
	 *
	 * @scField(type="string",title="نام",DoctrineField="fname",name="FirstName")
	 */
	public function getFirstName(){
		return $this->fname;
	}
	public function setFirstName($name){
		$this->fname=$name;
	}
	/**
	 * @Column(type="string",length=50)
	 */
	protected $lname;
	/**
	 *
	 * @scField(
	 * 	type="string",
	 * 	title="نام خانوادگی",
	 * 	DoctrineField="lname",
	 * 	name="LastName"
	 * )
	 *
	 */
	public function getLastName(){
		return $this->lname;
	}
	public function setLastName($LName){
		$this->lname=$LName;
	}

	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $NationalCode;
	/**
	 *
	 * @scField(
	 * 	type="string",
	 * 	title="کدملی",
	 * 	DoctrineField="NationalCode",
	 * 	name="NationalCode"
	 * )
	 */
	public function getNationalCode(){
		return $this->NationalCode;
	}
	public function setNationalCode($nl){
		$this->NationalCode=$nl;
	}

	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $fathername;
	/**
	 *
	 * @scField(
	 *	type="string",
	 * 	title="نام پدر",
	 * 	DoctrineField="fathername",
	 * 	name="FatherName"
	 * )
	 */
	public function getFatherName(){
		return $this->fathername;
	}
	public function setFatherName($fn){
		$this->fathername=$fn;
	}

	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $phoneno;
	/**
	 *
	 * @scField(type="string",title="شماره تلفن",DoctrineField="phoneno",name="PhoneNo")
	 */
	public function getPhoneNo(){
		return $this->phoneno;
	}
	public function setPhoneNo($p){
		$this->phoneno=$p;
	}

	/**
	 * @ManyToOne(targetEntity="Nationality")
	 * @var Nationality
	 */
	protected $nationality;
	/**
	 *
	 * @scField(
	 * 	type="string",
	 * 	title="ملیت",
	 * 	DoctrineField="nationality.Name",
	 * 	name="NationalityTitle"
	 * )
	 */
	public function getNationality(){
		if(isset($this->nationality)){
		try{
		return $this->nationality->getName();}
		catch (\CException $e){return '';}
		}
	}
	public function setNationality($nl) {
		/*$this->nationality=$nl;*/
	}

	/**
	 *
	 * @scField(
	 * 	type="integer",
	 * 	hidden=true,
	 * 	name="NationalityID"
	 * )
	 */
	public function getNationalityID(){
		if(isset($this->nationality))
			return $this->nationality->getID();
		else
			return null;
	}
	public function setNationalityID($nid){
		//Reterive Nationality Object From Data Bank
		$nationality= new Nationality();
		$nationality= $nationality->GetByID($nid);
		$this->nationality=$nationality;
	}


	/**
	 *
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $postalcode;
	/**
	 *
	 * @scField(
	 * 	type="string",
	 * 	title="کدپستی",
	 * 	name="PostalCode",
	 * 	DoctrineField="postalcode"
	 * )
	 */
	public function getPostalCode(){
		return $this->postalcode;
	}
	public function setPostalCode($pl){
		$this->postalcode=$pl;
	}

}
?>