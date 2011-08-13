<?php
require_once('DBEntity.php');
/**
 * @Entity @Table(name="Human")
 */
class Human extends DbEntity
{
	 /**
     * @Id @Column(type="integer") @GeneratedValue
     */
	protected $id;
	public function getID(){return $this->id;}
	public function setID($id){$this->id=$id;}
	/**
	 * @Column(type="string",length=50)
	 */
	protected $fname;
	public function getFirstName(){return $this->fname;}
	public function setFirstName($name){$this->fname=$name;}
	/**
	 * @Column(type="string",length=50)
	 */
	protected $lname;
	public function getLastName(){return $this->lname;}
	public function setLastName($LName){$this->lname=$LName;}
	
	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $NationalCode;
	public function getNationalCode(){return $this->NationalCode;}
	public function setNationalCode($nl){$this->NationalCode=$nl;}
	
	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $fathername;
	public function getFatherName(){return $this->fathername;}
	public function setFatherName($fn){$this->fathername=$fn;}
	
	/**
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $phoneno;
	public function getPhoneNo(){return $this->phoneno;}
	public function setPhoneNo($p){$this->phoneno=$p;}
	
	/**
	 * @ManyToOne(targetEntity="Nationality")
	 * @var Nationality
	 */
	protected $nationality;
	public function getNationality(){return $this->nationality;}
	public function setNationality($nl) {$this->nationality=$nl;}
	
	/**
	 * 
	 * @Column(type="string",length=50,nullable=true)
	 */
	protected $postalcode;
	public function getPostalCode(){return $this->postalcode;}
	public function setPostalCode($pl){$this->postalcode=$pl;}
	
}
?>