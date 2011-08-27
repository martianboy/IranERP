<?php
namespace IRERP\modules\jahad\models;

/**
 * @Entity
 * @author masoud
 *
 */
class Magazine_Version extends DbEntity
{
	/**
	 * @ManyToOne(targetEntity="Magazine",inversedBy="magver")
	 * @var Magazine
	 */
	protected $Magazie;
	
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
 * @OneToOne(targetEntity="Year")
 * @var Year
 */
protected $year;
public function getYear(){return $this->year;}
public function setYear($g){ $this->year=$g;}

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
public function getShomare(){return $this->shomare;}
public function setShomare($g){ $this->shomare=$g;}

/**
 * @Column(type="integer")
 * @var integer
 */
protected $tirajh;
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