<?php
require_once 'DBEntity.php';

/**
 * @Entity
 * @author masoud
 *
 */
class Media extends DbEntity{
	/**
	 * @Id @generatedValue(strategy="AUTO") @Column(type="integer")
	 * @var integer
	 */
protected $id;

	/**
	 * @OneToOne(targetEntity="Title")
	 * @var Title
	 */
	protected $onvan;
	public function getTitle(){return $this->onvan;}
	public function setTitle($ti){$this->onvan=$ti;}
	
	/**
	 * @ManyToMany(targetEntity="Matter")
	 * 
	 * @var Matter[]
	 */
	protected $mozu;
	public function getMozu(){return $this->mozu;}
	public function setMozu($ti){$this->mozu=$ti;}
	
	/**
	 * @OneToOne(targetEntity="TVRD")
	 * @var TVRD
	 */
	protected $tv_rd;
	public function getTV_RD(){return $this->tv_rd;}
	public function setTV_RD($ti){$this->tv_rd=$ti;}
	
	/**
	 * ManyToMany(targetEntity="Auidunce")
	 * @var Auidunce[]
	 */
	protected $sathe_mokhatab;
	public function getSathe_Mokhatab(){return $this->sathe_mokhatab;}
	public function setSathe_Mokhatab($ti){$this->sathe_mokhatab=$ti;}
	
		/**
		 * @ManyToMany(targetEntity="State")
		 * @var state[]
		 */
	protected $ostan;
	public function getOstan(){return $this->ostan;}
	public function setOstan($ti){$this->ostan=$ti;}
		
		/**
		 * @Column(type="integer")
		 * @var integer
		 */
	
	protected $tedad_barnameh;
	public function getTedad_Barnameh(){return $this->tedad_barnameh;}
	public function setTedad_Barnameh($ti){$this->tedad_barnameh=$ti;}
		
			/**
			 * @Column(type="string")
			 * @var string
			 */
	protected $shomareh;
	public function getShomareh(){return $this->shomareh;}
	public function setShomareh($ti){$this->shomareh=$ti;}
	
		/**
		 * @OneToMany(targetEntity="Section",mappedBy="Media")
		 * @var Section[]
		 */
	protected $bakhshha;
	public function getBakhshha(){return $this->bakhshha;}
	public function setBakhshha($ti){$this->bakhshha=$ti;}
		
	
}

/**
 * @Entity
 * @author masoud
 *
 */
class Section extends DbEntity
{
	/**
 	 * @ManyToOne(targetEntity="Media",inversedBy="bakhshha")
	 * @var integer
	 */
	protected $Media;
	
	/**
	 * @Id @generatedValue(strategy="AUTO") @Column(type="integer")
	 * @var integer
	 */
protected $id;
		/**
		 * @Column(type="string")
		 * @var string
		 */
	protected $nobat;
	public function getNobat(){return $this->nobat;}
	public function setNobat($ti){$this->nobat=$ti;}
	/**
	 * @Column(type="string")
	 * @var Persian Date string
	 */
	
	protected $Pakhsh;
	public function getPakhsh(){return $this->Pakhsh;}
	public function setPakhsh($ti){$this->Pakhsh=$ti;}
/**
 * @Column(type="string")
 * @var Persian Date String
 */
	protected $enteshar;
	public function getEnteshar(){return $this->enteshar;}
	public function setEnteshar($ti){$this->enteshar=$ti;}
	/**
	 * @ManyToMany(targetEntity="Human")
	 * @JoinTable(name="section_Human_karshenas",
	 *     		 joinColumns={
	 *     					@JoinColumn
	 *     								(
	 *     									name="section_id", 
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
	protected $karshenas;
	public function getKarshenas(){return $this->karshenas;}
	public function setKarshenas($ti){$this->karshenas=$ti;}
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	protected $tirajh;
	public function getTirajh(){return $this->tirajh;}
	public function setTirajh($ti){$this->tirajh=$ti;}
	/**
	 * @ManyToMany(targetEntity="Human")
	 * @JoinTable(name="section_Human_sardabir",
	 *     		 joinColumns={
	 *     					@JoinColumn
	 *     								(
	 *     									name="section_id", 
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
	protected $sardabir;
	public function getSardabir(){return $this->sardabir;}
	public function setSardabir($ti){$this->sardabir=$ti;}
	
}