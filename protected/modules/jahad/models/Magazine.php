<?php
namespace IRERP\modules\jahad\models;

use IRERP\models\DbEntity;

/**
 * 
 * @author masoud
 *@Entity
 */
class Magazine extends DbEntity
{
	/**
	 * @Id @generatedValue(strategy="AUTO") @Column(type="integer")
	 * 
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
	 * @var Matter[]
	 */
	protected $mozu;
	public function getMatters(){return $this->mozu;}
	public function setMatters($m){$this->mozu=$m;}
	
	/**
	 * @OneToOne(targetEntity="MagazineType")
	 * @var MagazineType
	 */
	protected $noe_majale;
	public function getMagType(){return $this->noe_majale;}
	public function setMagType($m){$this->noe_majale=$m;}
	
	/**
	 * @OneToMany(targetEntity="MagazineVersion",mappedBy="Magazine")
	 * @var MagazineVersion[]
	 */
	protected $magver;
	public function getVersions(){return $this->magver;}
	public function setVersions($vers){$this->magver=$vers;}
	
	
}

?>