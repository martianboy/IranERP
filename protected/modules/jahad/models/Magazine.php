<?php
namespace IRERP\modules\jahad\models;

use IRERP\models\DbEntity;
use IRERP\modules\jahad\models;
use IRERP\Basics\Annotations\scField;

/**
 * 
 * @author masoud
 *@Entity
 */
class Magazine extends DbEntity
{

	/**
	 * @OneToOne(targetEntity="Title")
	 * @var Title
	 */
	protected $onvan;
	public function getTitle(){return $this->onvan;}
	public function setTitle($ti){$this->onvan=$ti;}
	
	/**
	 * @scField(type="string",name="TitleName",title="عنوان",DoctrineField="onvan.Name")
	 */
	public function getTitleName(){return $this->onvan->getName();}
	public function setTitleName($v){}
	
	/**
	 * @scField(type="integer",name="onvan_id",title="عنوان",DoctrineField="onvan.id",hidden=true)
	 */
	public function getTitleid(){if(isset($this->onvan)) return $this->onvan->getid(); else return null;}
	public function setTitleid($id){
		$tit = new Title();
		$tit= $tit->GetByID($id);
		$this->onvan=$tit;
	}
	
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
	 * @scField(type="string",name="MagTypeName",title="نوع مجله",DoctrineField="noe_majale.Name")
	 */
	public function getMagTypeName(){return $this->noe_majale->getName();}
	public function setMagTypeName(){}
	
	/**
	 * @scField(type="integer",name="MagTypeid",title="نوع مجله",DoctrineField="noe_majale.id")
	 */
	public function getMagTypeid(){return $this->noe_majale->getid();}
	public function setMagTypeid($nid){$magt = new MagazineType();$this->noe_majale=$magt->GetByID($nid);}
	
	
	/**
	 * @OneToMany(targetEntity="MagazineVersion",mappedBy="Magazine")
	 * @var MagazineVersion[]
	 */
	protected $magver;
	public function getVersions(){return $this->magver;}
	public function setVersions($vers){$this->magver=$vers;}
	
	
	public function  AddMatter($m)
	{
		$this->mozu[]=$m;
		
	}
	
}

?>