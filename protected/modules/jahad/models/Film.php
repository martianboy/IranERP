<?php
namespace IRERP\modules\jahad\models;

use IRERP\Basics\Models\IRDataModel,
    IRERP\Basics\Annotations\scField;
use IRERP\modules\jahad\models\FilmEducationalGoal;    
/**
 * @Entity 
 */
class Film extends IRDataModel
{
/**
	 * @Column(type="string",length=50)
	 */
	protected $FilmName;
	/**
	 * 
	 * @scField(name="FilmName",type="string",title="نام فیلم",DoctrineField="FilmName")
	 */
	public function getFilmName(){
	try {return $this->FilmName;}catch(\Exception $ex){return '';}
	}
	public function setFilmName($v){$this->FilmName=$v;}
	/**
	 * @Column(type="string",length=10)
	 */
	protected $FilmTime;
		/**
	 * 
	 * @scField(name="FilmTime",type="string",title="زمان فیلم",DoctrineField="FilmTime")
	 */
	
	public function getFilmTime(){
	try {return $this->FilmTime;}catch(\Exception $ex){return '';}
	}
	public function setFilmTime($v){$this->FilmTime=$v;}
	
	/**
	 * @Column(type="string",length=50)
	 */
	protected $ProductionDate;
		/**
	 * 
	 * @scField(name="ProductionDate",type="string",title="تاریخ تولید",DoctrineField="ProductionDate")
	 */
	
		public function getProductionDate(){
	try {return $this->ProductionDate;}catch(\Exception $ex){return '';}
	}
	public function setProductionDate($v){$this->ProductionDate=$v;}
	
	/**
	 * @Column(type="string",length=50)
	 */
	protected $Montage;
		/**
	 * 
	 * @scField(name="Montage",type="string",title="مونتاژ",DoctrineField="Montage")
	 */
	
		public function getMontage(){
	try {return $this->Montage;}catch(\Exception $ex){return '';}
	}
	public function setMontage($v){$this->Montage=$v;}
	
	/**
	 * @Column(type="string",length=50)
	 */
	
	protected $FilmCode;
		/**
	 * 
	 * @scField(name="FilmCode",type="string",title="کد فیلم",DoctrineField="FilmCode")
	 */
	
	public function getFilmCode(){
	try {return $this->FilmCode;}catch(\Exception $ex){return '';}
	}
	public function setFilmCode($v){$this->FilmCode=$v;}
	
	
	/**
	 * @Column(type="string",length=50)
	 */
	protected $FilmabstracFile;
		/**
	 * 
	 * @scField(name="FilmabstracFile",type="string",title="پرونده خلاصه فیلم",DoctrineField="FilmabstracFile")
	 */
	
	
		public function getFilmabstracFile(){
	try {return $this->FilmabstracFile;}catch(\Exception $ex){return '';}
	}
	public function setFilmabstracFile($v){$this->FilmabstracFile=$v;}
	
	
	
	/**
	 * @ManyToOne(targetEntity="FilmProductionFormat")
	 */
	protected $ProductionFormat;
	/**
	 * 
	 * @scField(name="ProductionFormatName",type="string",title="قالب تولید",DoctrineField="ProductionFormat.Name")
	 */
	public function getProductionFormatName(){
	try {return $this->ProductionFormat->getName();}catch(\Exception $ex){return '';}
	}
	public function setProductionFormatName($v){}
	/**
	 * 
	 * @scField(name="ProductionFormatID",type="string",hidden=true,DoctrineField="ProductionFormat.id")
	 */
	public function getProductionFormatID(){
	try {return $this->ProductionFormat->getid();}catch(\Exception $ex){return NULL;}
	}
	public function setProductionFormatID($v){
	try {
		$this->ProductionFormat=new FilmProductionFormat();
		$this->ProductionFormat= $this->ProductionFormat->GetByID($v);
	}catch(\Exception $ex){}
	}
	
	
	
	
	
	/**
	 * @ManyToOne(targetEntity="Human")
	 */
	protected $Client;
	/**
	 * 
	 * @scField(name="ClientFirstName",type="string",DoctrineField="Client.fname",title="نام سفارش دهنده")
	 */
	public function getClientFirstName(){
	try {return $this->Client->getFirstName();}catch(\Exception $ex){return '';}
	}
	public function setClientFirstName($v){}
	/**
	 * 
	 * @scField(name="ClientLastName",type="string",DoctrineField="Client.lname",title="نام خانوادگی سفارش دهنده")
	 */
	public function getClientLastName(){
	try {return $this->Client->getLastName();}catch(\Exception $ex){return '';}
	}
	public function setClientLastName($v){}
	
	/**
	 * 
	 * @scField(name="ClientID",type="string",hidden=true,DoctrineField="Client.id")
	 */
	public function getClientID(){
	try {return $this->Client->getid();}catch(\Exception $ex){return NULL;}
	}
	public function setClientID($v){
	try {
		$this->Client=new Human();
		$this->Client= $this->Client->GetByID($v);
	}catch(\Exception $ex){}
	}
	
	
	
	
	
	/**
	 * @ManyToOne(targetEntity="FilmSystemType")
	 */
	protected $SystemType;
	/**
	 * 
	 * @scField(name="SystemTypeName",type="string",title="نوع سیستم",DoctrineField="SystemType.Name")
	 */
	public function getSystemTypeName(){
	try {return $this->SystemType->getName();}catch(\Exception $ex){return '';}
	}
	public function setSystemTypeName($v){}
	/**
	 * 
	 * @scField(name="SystemTypeID",type="string",hidden=true,DoctrineField="SystemType.id")
	 */
	public function getSystemTypeID(){
	try {return $this->SystemType->getID();}catch(\Exception $ex){return NULL;}
	}
	public function setSystemTypeID($v){
	try {
		$this->SystemType=new FilmSystemType();
		$this->SystemType= $this->SystemType->GetByID($v);
	}catch(\Exception $ex){}
	}
	
	
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="Film_Executives",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Executive_id", referencedColumnName="id")}
 	 *      )

	 * @var Human
	 */
	protected $Executives;
	
	/**
	 * @OneToMany(targetEntity="FilmContentlist",mappedBy="Film")
	 * @var FilmContentlist
	 */
	protected $FilmContentlists;
	/**
	 * 
	 * @ManyToMany(targetEntity="FilmEducationalGoal")
	 * @var FilmEducationalGoal
	 */
	protected $EducationalGoals;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="Film_TechnicalExperts",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="TechnicalExpert_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $TechnicalExperts;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="Film_Speakers",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Speaker_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Speakers;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
	 * @var Human
     * @JoinTable(name="Film_Senarists",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Senarist_id", referencedColumnName="id")}
 	 *      )
	 */
	protected $Senarists;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="Film_Actors",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Actor_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Actors;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="Film_Writers",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Writer_id", referencedColumnName="id")}
 	 *      )
	 * 
	 * @var Human
	 */
	protected $Writers;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
	 * 
     * @JoinTable(name="Film_Directors",
	 *      joinColumns={@JoinColumn(name="Film_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Director_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Directors;
	
	
	
	
	 
}
?>