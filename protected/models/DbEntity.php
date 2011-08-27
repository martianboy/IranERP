<?php

namespace IRERP\models;

use Doctrine\Common\Annotations\AnnotationReader;
date_default_timezone_set('UTC');
/**
 * @MappedSuperclass
 * @author masoud
 *
 */
class DbEntity
{
	/**
	 * Entity Manager That This Class Use To 
	 * Doing Something To Objects
	 * @var Doctrine EntityManager
	 */
	protected $EM;
	
	/**
	 * @Id @generatedValue(strategy="AUTO") @Column(type="integer")
	 * @var integer
	 */
	protected $id = null;
	/**
	 * @Column(type="integer")
	 * @version
	 * @var integer
	 */
	protected $version = 0;
	
	/**
	 * @Column(type="datetime")
	 * @var DateTime
	 */
	protected $CreatedDate ;
	
	/**
	 * @Column(type="datetime")
	 * @var DateTime
	 */
	Protected $LastModifyDate ;
	
	/**
	 * @Column(type="boolean")
	 * @var boolean
	 */
	protected $IsDeleted=false;
	
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	protected $CreatorUserId=-1;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	protected $ModifierUserId=-1;
	
	public function setEntityManager($value){$this->EM=\Yii::app()->doctrine->getEntityManager();}
	public function getEntityManager(){return \Yii::app()->doctrine->getEntityManager();}
	
	/**
	 *@scField(name="id",DoctrineField="id",type="integer",primaryKey="true",hidden="true") 
	 */
	public function getid(){return $this->id;}
	public function setid($v){$this->id=$v;}
	
/*
	public function getID(){return $this->id;}
	protected function setID($value){$this->id=$value;}
	*/
 	public function getVersion(){return $this->version;}
	
	public function getCreatorUserID(){return $this->CreatorUserId;}
	public function setCreatorUserID($uid){$this->CreatorUserId=$uid;}
	
	public function getModifierUserID(){return $this->ModifierUserId;}
	public function setModifierUserID($uid){$this->ModifierUserId=$uid;}
	
	public function getCreateDate(){return $this->CreatedDate;}
	public function setCreateDate($d){$this->CreatedDate=$d;}
	
	public function getLastModifyDate(){return $this->LastModifyDate;}
	public function setLastModifyDate($d){$this->LastModifyDate=$d;}
	
	public function getIsDeleted(){return $this->IsDeleted;}
	public function setIsDeleted($d){$this->IsDeleted=$d;}

	public function CreateClassFromScUsingMethod($functionName,$ExceptedProperties=NULL,$ValueArray = NULL){
		$reader=new AnnotationReader();
		$methods=get_class_methods(get_class($this));
		foreach ($methods as $methodName)
		{
			//Check That Method is getter or setter else continue
			if(!(substr($methodName, 0,3)=='get' ||	substr($methodName,0,3)=='set')	) continue;
			$propname = substr($methodName, 3,strlen($methodName)-3);
			//if propname is in $ExceptedProperties jump to next property
			if(is_array($ExceptedProperties))
				if(in_array($propname, $ExceptedProperties)) continue; 
			//Get Method Annotation
			$reflMethod = new \ReflectionMethod(get_class($this), $methodName);
			$MethodAnns = $reader->getMethodAnnotations($reflMethod);
			foreach ($MethodAnns as $annots){
				if(is_a($annots,'scField')){
					//if defined Annotation is scField
					//Get Value From User
					$fieldvalue = call_user_func($functionName,$annots->name,$ValueArray);
					//Try To Set To Class 
					call_user_func(array(&$this, 'set'.$propname),$fieldvalue);
				}
			}
		}
	}
	public function GetByID($id)
	{
		return $this->getEntityManager()
					->getRepository(get_class($this))
					->find($id);
	}
	
	protected function parseObjectToArray()
	{
		return Common::parseObjectToArray($this);
	}

	protected function _Save()
	{
		$this->getEntityManager()->persist($this);
	}
	function Save()
	{
		$this->_Save();
	}

	public function GetClassSCPropertiesInArray($ExceptedProperties=NULL){
		$rtnval=array();
		$isarray=is_array($ExceptedProperties);
		$reader=new AnnotationReader();
		$methods=get_class_methods(get_class($this));
		foreach ($methods as $methodName)
		{
			//Check That Method is getter or setter else continue
			if(!(substr($methodName, 0,3)=='get')) continue;
			$propname = substr($methodName, 3,strlen($methodName)-3);
			//if propname is in $ExceptedProperties jump to next property
			if($isarray) if(in_array($propname, $ExceptedProperties)) continue; 
			//Get Method Annotation
			$reflMethod= NUll;
			$reflMethod = new \ReflectionMethod(get_class($this), $methodName);
			$MethodAnns = $reader->getMethodAnnotations($reflMethod);
			foreach ($MethodAnns as $annots){
				if(is_a($annots,'scField')){
					//if defined Annotation is scField
					//Get Value
					$rtnval[$annots->name]=	call_user_func(array(&$this, 'get'.$propname));
				}
			}
		}
		return $rtnval;
	}

	function GetClassPropertiesinArray($ExceptedProperties)
	{
		$rtnval = array();
		$isarray=is_array($ExceptedProperties);
		$methods = get_class_methods($this);
		print_r($methods);
		foreach($methods as $m)
		{
			if(substr($m,0,3)=='get'){
				$propname=substr($m,3);
				
				if($isarray){
					//Check That propname exist in ExcepredProperties
					if(in_array($propname,$ExceptedProperties)) continue;
				}
				
				$rtnval[$propname]=call_user_method($m,$this);
			}
		}
			
		return $rtnval;
	}


	function GetClassArray()
	{
		return $this->parseObjectToArray();
	}

	public function __construct()
	{
		$this->LastModifyDate=new \DateTime();
		$this->CreatedDate=new \DateTime();
		$this->EM = \Yii::app()->doctrine->getEntityManager();
	}

	public function fetchObjects($startRow,$endRow,$whstr,$whparam,$orderby){
		$em = $this->EM;
		
		$qb = $em->createQueryBuilder();
		$qb->add('select', 'tmp')
		   ->add('from', get_class($this).' tmp')
		   ->setFirstResult( $startRow )
		   ->setMaxResults( $endRow-$startRow );

		$tmp=0;
            
        	foreach($orderby as $fn=>$kn) 
                if($tmp==0){
                	$qb->orderBy('tmp.'.$fn,$kn);
                	$tmp=1;
                }
                else
                    $qb->addOrderBy('tmp.'.$fn,$kn);

            if($whstr!='') {
                $qb->add('where',$whstr.' and tmp.IsDeleted = 0 ');
                $qb->setParameters($whparam);
            }
            else {
                $qb->add('where','tmp.IsDeleted =0');
            }
			  
            $query = $qb->getQuery();
			$results = $query->getResult();

			$qb = $em->createQueryBuilder();
			$qb->add('select', 'count(tmp.id)')
			   ->add('from', get_class($this).' tmp');

			if($whstr!='') {
			    $qb->add('where',$whstr.' and tmp.IsDeleted = 0 ');
			    $qb->setParameters($whparam);
			} else {
			    $qb->add('where','tmp.IsDeleted =0');
			}
			   
			//get Total Rows
			$dql = $qb->getQuery();
			$tmptest= $dql->getResult();
			
			$totalRows = $tmptest[0][1];
			return array('totalRows'=>$totalRows,'results'=>$results);
	}
}
/***
 * Old
 * /*
function GetClassSCPropertiesInArray($ExceptedProperties=NULL)
{
$rtnval = array();
	$isarray=is_array($ExceptedProperties);
	$methods = get_class_methods($this);
	foreach($methods as $m){
		
		if(substr($m,0,5)=='scget'){
			$propname=substr($m,5);
			
			if($isarray){
				//Check That propname exist in ExcepredProperties
				if(in_array($propname,$ExceptedProperties)) continue;
			}
			
			$rtnval[$propname]= call_user_func(array(&$this, $m));
		}
	}
		
return $rtnval;
	
}

/*public function CreateClassFromScUsingMethod($functionName,$ExceptedProperties=NULL)
	{
	$isarray=is_array($ExceptedProperties);
	$methods = get_class_methods($this);
	foreach($methods as $m){
		
		if(substr($m,0,5)=='scset'){
			$propname=substr($m,5);
			
			if($isarray){
				//Check That propname exist in ExcepredProperties
				if(in_array($propname,$ExceptedProperties)) continue;
			}
			$rtn = call_user_func($functionName,$propname);
			//call_user_method($m,$this,$rtn);
			call_user_func(array(&$this, $m),$rtn);
		}
		
	}
	}
	public static function parseObjectToArray(){
	/*$object = $this;
    $array = array();
    if (is_object($object)) {
        $array = get_object_vars($object);
    }
    return $array;
}
*/
?>
