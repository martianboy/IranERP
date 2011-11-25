<?php
namespace IRERP\modules\jahad\models;

use IRERP\Basics\Models\IRDataModel,
    IRERP\Basics\Annotations\scField;
   
/**
 * @Entity 
 */
class PlayShow extends IRDataModel
{

	/**
	 * @ManyToOne(targetEntity="Title")
	 */
	protected $Title;
	/**
	 * 
	 * @scField(name="TitleName",type="string",title="عنوان",DoctrineField="Title.Name")
	 */
	public function getTitleName(){
	try {return $this->Title->getName();}catch(\Exception $ex){return '';}
	}
	public function setTitleName($v){}
	/**
	 * 
	 * @scField(name="TitleID",type="string",hidden=true,DoctrineField="Title.id")
	 */
	public function getTitleID(){
	try {return $this->Title->getID();}catch(\Exception $ex){return NULL;}
	}
	public function setTitleID($v){
	try {
		$this->Title=new Title();
		$this->Title= $this->Title->GetByID($v);
	}catch(\Exception $ex){}
	}
	
	/**
	 * @Column(type="string",length=10)
	 */
	protected $PlayShowTime;
		/**
	 * 
	 * @scField(name="PlayShowTime",type="string",title="زمان ",DoctrineField="PlayShowTime")
	 */
	
	public function getPlayShowTime(){
	try {return $this->PlayShowTime;}catch(\Exception $ex){return '';}
	}
	public function setPlayShowTime($v){$this->PlayShowTime=$v;}
	
	
	/**
	 * @Column(type="string",length=50)
	 */
	protected $Center;
		/**
	 * 
	 * @scField(name="Center",type="string",title="مرکز",DoctrineField="Center")
	 */
	
		public function getCenter(){
	try {return $this->Center;}catch(\Exception $ex){return '';}
	}
	public function setCenter($v){$this->Center=$v;}
	
	/**
	 * @Column(type="string",length=50)
	 */
	
	protected $PlayShowCode;
		/**
	 * 
	 * @scField(name="PlayShowCode",type="string",title="کد ",DoctrineField="PlayShowCode")
	 */
	
	public function getPlayShowCode(){
	try {return $this->PlayShowCode;}catch(\Exception $ex){return '';}
	}
	public function setPlayShowCode($v){$this->PlayShowCode=$v;}
	
	
	/**
	 * @Column(type="string",length=50)
	 */
	protected $PlayShowabstracFile;
		/**
	 * 
	 * @scField(name="PlayShowabstracFile",type="string",title="پرونده خلاصه ",DoctrineField="PlayShowabstracFile")
	 */
	
	
		public function getPlayShowabstracFile(){
	try {return $this->PlayShowabstracFile;}catch(\Exception $ex){return '';}
	}
	public function setPlayShowabstracFile($v){$this->PlayShowabstracFile=$v;}
	
	/**
	 * @OneToMany(targetEntity="PlayShowContentlist",mappedBy="PlayShow")
	 * @var PlayShowContentlist
	 */
	protected $PlayShowContentlists;
	/**
	 * 
	 * @ManyToMany(targetEntity="FilmEducationalGoal")
	 * @var FilmEducationalGoal
	 */
	protected $EducationalGoals;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="PlayShow_TechnicalExperts",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="TechnicalExpert_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $TechnicalExperts;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="PlayShow_Speakers",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Speaker_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Speakers;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
	 * @var Human
     * @JoinTable(name="PlayShow_Actors",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Actor_id", referencedColumnName="id")}
 	 *      )
	 */
	protected $Actors;
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
     * @JoinTable(name="PlayShow_Writers",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Writer_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Writers;
	
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
	 * 
     * @JoinTable(name="PlayShow_Directors",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Director_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Directors;
	
	
	/**
	 * 
	 * @ManyToMany(targetEntity="Human")
	 * 
     * @JoinTable(name="PlayShow_Producers",
	 *      joinColumns={@JoinColumn(name="PlayShow_id", referencedColumnName="id")},
	 *      inverseJoinColumns={@JoinColumn(name="Producer_id", referencedColumnName="id")}
 	 *      )
	 * @var Human
	 */
	protected $Producers;
	
	
	/**
	 * @ManyToMany(targetEntity="Auidunce")
	 * @var Auidunce
	 */
	protected $Audiences;
	
	
	
	 
}
?>