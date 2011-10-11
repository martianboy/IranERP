<?php
namespace IRERP\Basics\Models;

use \Doctrine\Common\Annotations\AnnotationReader,
	 \IRERP\Basics\Annotations\scField,
	\IRERP\Basics,
	 \CModel, \Yii;
use \IRERP\Basics\JoinTb;
//This shoud be defined inside php.ini file, not here
//date_default_timezone_set('UTC');

/**
 * @MappedSuperclass
 * @author masoud
 *
 */
class IRDataModel extends CModel
{
	private static $_names=array();

	/**
	 * Entity Manager That This Class Use To 
	 * Doing Something To Objects
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;
	
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
	protected $dateCreated;
	
	/**
	 * @Column(type="datetime")
	 * @var DateTime
	 */
	Protected $dateLastModified;
	
	/**
	 * @Column(type="boolean")
	 * @var boolean
	 */
	protected $IsDeleted=false;
	
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	protected $creatorUserId=-1;
	
	/**
	 * @Column(type="integer")
	 * @var integer
	 */
	protected $modifierUserId=-1;
	
	/**
	 * 
	 * Values of all annotations is stored in this array
	 * @var string[]
	 */
	protected $annotationValues = array();
	
	protected $HelpField='';
	public function setHelpField($v){$this->HelpField=$v;}
   /**
	 *@scField(name="HelpField") 
	 */
	public function getHelpField(){return $this->HelpField;}
	
	
	protected function getClassMember($MemberName){
		$tmp=new \ReflectionProperty($this,$MemberName);
		$tmp->setAccessible(true);
		return $tmp->getValue($this);
	}
	
	protected function setClassMember($MemberName,$Value,$Obj=NULL){
		$tmp=new \ReflectionProperty($this,$MemberName);
		$tmp->setAccessible(true);
		if(!isset($Obj)) $Obj=$this; 
		$tmp->setValue($Obj, $Value);
	}
	
	
	public function AddToMember($MemberName,IRDataModel $Value){
		$_1nPropName = NULL;
		$_1nPropName=\ApplicationHelpers::GetPropertyInTargetFor1nRelation($this, $MemberName, $Value);
		if(isset($_1nPropName)){
			$Value->setClassMember($_1nPropName, $this,$Value);
			$this->getClassMember($MemberName)->add($Value);
			$Value->Save();
		}else {

		$this->getClassMember($MemberName)->add($Value);
		$this->Save();
		}
		//Check For Relation Betweeen $Value Class And Member Class 
		//if Relation is n-1 And There Is 
	}
	public function AddToMemberENUM($MemberName,$Value){
		$this->getClassMember($MemberName)->add($Value);
	}
	public function RemoveFromMember_ENUM($MemberName,$Value){
		$this->getClassMember($MemberName)->removeElement($Value);
	}
	public function RemoveFromMember_Complete($MemberName,IRDataModel $Value){
		$this->getClassMember($MemberName)->removeElement($Value);
		$Value->setIsDeleted(true);
		$Value->Save();
		$this->Save();
		
	}
	
	/***
	 * this method copy all property from src to this class property which have save name
	 */
	
	public function CopyProps($src)
	{
		//Get all Properties
		$rcls = new \ReflectionClass(get_class($src));
		foreach($rcls->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED) as $p){
			//$p is PropertyReflection
			try{
			$p->setAccessible(true);
			$thisclassp=new \ReflectionProperty($this, $p->getName());
			$thisclassp->setAccessible(true);
			$thisclassp->setValue($this, $p->getValue($src));
			}catch(\Exception $e)
			{}
		}
	}
	
	public function setEntityManager(&$value = NULL){
		if ($value !== NULL && is_a($value, '\Doctrine\ORM\EntityManager'))
			$this->entityManager = $value;
		else
			$this->entityManager=\Yii::app()->doctrine->getEntityManager();
	}
	public function &getEntityManager(){
		if ($this->entityManager === NULL)
			$this->setEntityManager();
		
		return $this->entityManager;
	}
	
	/**
	 *@scField(name="id",DoctrineField="id",type="integer",primaryKey="true",hidden="true") 
	 */
	public function getid(){return $this->id;}
	public function setid($v){$this->id=$v;}
	
 	public function getVersion(){return $this->version;}
	
	public function getCreatorUserID(){return $this->creatorUserId;}
	public function setCreatorUserID($uid){$this->creatorUserId=$uid;}
	
	public function getModifierUserID(){return $this->modifierUserId;}
	public function setModifierUserID($uid){$this->modifierUserId=$uid;}
	
	public function getCreateDate(){return $this->dateCreated;}
	public function setCreateDate($d){$this->dateCreated=$d;}
	
	public function getdateLastModified(){return $this->dateLastModified;}
	public function setdateLastModified($d){$this->dateLastModified=$d;}
	
	public function getIsDeleted(){return $this->IsDeleted;}
	public function setIsDeleted($d){$this->IsDeleted=$d;}

	public function CreateClassFromScUsingMethod($functionName,$ExceptedProperties=NULL,$ValueArray = NULL){
		$reader = new AnnotationReader();
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
				if(is_a($annots,'\IRERP\Basics\Annotations\scField')){
					//if defined Annotation is scField
					//Get Value From User
					$fieldvalue = call_user_func($functionName,$annots->name,$ValueArray);
					//Try To Set To Class 
					try {
						$this->$propname = $fieldvalue;
					}
					catch (\Exception $ex)
					{
						call_user_func(array(&$this, 'set'.$propname),$fieldvalue);
					}
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

	protected function persistEntity()
	{
		$this->getEntityManager()->persist($this);
	}
	public function Save()
	{
		$this->persistEntity();
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
			$reflMethod= NULL;
			$reflMethod = new \ReflectionMethod(get_class($this), $methodName);
			$MethodAnns = $reader->getMethodAnnotations($reflMethod);
			foreach ($MethodAnns as $annots){
				if(is_a($annots,'\IRERP\Basics\Annotations\scField')){
					//if defined Annotation is scField
					//Get Value
					
					try{
					$rtnval[$annots->name]=	call_user_func(array(&$this, 'get'.$propname));
					}catch(\Exception $ex){}
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

/*	public function __construct()
	{
		$this->dateLastModified=new \DateTime();
		$this->dateCreated=new \DateTime();
		$this->EntityManager = Yii::app()->doctrine->getEntityManager();
	}*/
public function __construct($em=NULL)
	{
		$this->dateLastModified=new \DateTime();
		$this->dateCreated=new \DateTime();
		if(isset($em))
			$this->entityManager=$em;
		else 
			$this->entityManager = \Yii::app()->doctrine->getEntityManager();
	}

	public function findAll($parameters)
	{
		$tableAlias = 'tmp';
		
		$queryBuilder = $this->EntityManager->createQueryBuilder();
		$queryBuilder->add('select', $tableAlias)
					 ->add('from', get_class($this));
		
		if(isset($parameters['startRow']))
		{
			$queryBuilder->setFirstResult($parameters['startRow']);
			if(isset($parameters['endRow']))
				$queryBuilder->setMaxResults($parameters['endRow'] - $parameters['startRow']);
		}
		
		if(isset($parameters['orderBy']))
			foreach ($parameters['orderBy'] as $key => $value)
				$queryBuilder->addOrderBy($tableAlias.'.'.$key,$value);
		
		
	}
	
/**
 * 
 * Enter description here ...
 * @param integer $startRow
 * @param integer $endRow
 * @param string $whstr
 * @param array $whparam
 * @param array $orderby
 * @param array $joinedTable
 * 			> array structure array('Class'=>TargetClassName,
 * 									'Prop'=>TargetProperty,
 * 									'whstr'=>WhereString,
 * 									'whparam'=>array,
 * 									'HelpField'=>array('Type'=>['Value' or 'function'],
 * 																['Value'=>Value]['function'=>function($reterivedClass)]))
 */
	public function fetchObjects($startRow=0,$endRow=100,$whstr='',$whparam=NULL,$orderby=array(),JoinTb  $joinedTable=NULL){
		
		$em = $this->entityManager;
		
		$qb = $em->createQueryBuilder();
		if(!isset($joinedTable)){
		$qb->add('select', 'tmp')
		   ->add('from', get_class($this).' tmp')
		   ->setFirstResult( $startRow )
		   ->setMaxResults( $endRow-$startRow );
		}else {
			$subquery= $em->createQueryBuilder();
			$subquery
			->select('TBIDS.id')
			->from($joinedTable->getClass(),'tmp1')
			->innerJoin('tmp1.'.$joinedTable->getProp(), 'TBIDS')
			;
			$jointbwhstr = $joinedTable->getWhereString();
			$jointbwhparam = $joinedTable->getWhereParam();
			
			if(isset($jointbwhstr)) {
				$subquery->add('where',$joinedTable->getWhereString());
				if(isset($jointbwhparam)) 
					$subquery->setParameters($joinedTable->getWhereParam());
					
			$qb->add('select', 'tmp')
		   ->add('from', get_class($this).' tmp')
		   ->setFirstResult( $startRow )
		   ->setMaxResults( $endRow-$startRow );
		   
		   $qb->add('where','tmp.id in ('.$subquery->getDQL().')');
		   $qb->setParameters($subquery->getParameters());
			}
		}

		$tmp=0;

		foreach($orderby as $fn=>$kn)
			if($tmp==0){
				$qb->orderBy('tmp.'.$fn,$kn);
				$tmp=1;
			}
			else
				$qb->addOrderBy('tmp.'.$fn,$kn);
				
		if(isset($joinedTable))
		{
			if($whstr!=''){
				$qb->andWhere($whstr.' and tmp.IsDeleted = 0 ');
				if(isset($whparam)) $qb->setParameters($whparam);
			}
			else 
			{
				$qb->andWhere('tmp.IsDeleted = 0');
			}
		}else 
			if($whstr!='') {
				$qb->add('where',$whstr.' and tmp.IsDeleted = 0 ');
				 if(isset($whparam))$qb->setParameters($whparam);
			}
			else
				$qb->add('where','tmp.IsDeleted =0');
		
		$query = $qb->getQuery();
		

//		var_dump($qb->getQuery()->getSQL());
//		var_dump($whparam);
//		var_dump($whstr); die;
		$jointbhelpfieldtype =NULL;
		if(isset($joinedTable))		$jointbhelpfieldtype = $joinedTable->getHelpFieldType();
		
		$results = $query->getResult();
		if(isset($joinedTable))
			if(isset($jointbhelpfieldtype))
				foreach($results as $r){
					switch ($joinedTable->getHelpFieldType()){
						case 'Value':
							$r->HelpField=$joinedTable->getHelpField();
							break;
						case 'function':
							/**
							 * 
							 *TODO: Complete this section for
							 *Make instance of function and call it 
							 *HelpField=function($r);
							 */
							break;
							
						
					}
						
				}

				
		/*		
		$qb = $em->createQueryBuilder();
		if(!isset($joinedTable)){
		$qb->add('select', 'count(tmp.id)')
		   ->add('from', get_class($this).' tmp');	
		}else {
			$qb	->select('count(tmp.id)')
    		->from($joinedTable['Class'],' tmp1')
    		->innerJoin('tmp1.'.$joinedTable['Prop'],'tmp');
		}
		
		if(isset($joinedTable))
		{
			if($whstr!=''){
				$qb->andWhere($whstr.' and tmp.IsDeleted = 0 ');
				if(isset($whparam)) $qb->setParameters($whparam);
			}
			else 
			{
				$qb->andWhere('tmp.IsDeleted = 0');
			}
		}else 
			if($whstr!='') {
				$qb->add('where',$whstr.' and tmp.IsDeleted = 0 ');
				 if(isset($whparam))$qb->setParameters($whparam);
			}
			else
				$qb->add('where','tmp.IsDeleted =0');
		*/
		
/*
		if($whstr!='') {
			$qb->add('where',$whstr.' and tmp.IsDeleted = 0 ');
			$qb->setParameters($whparam);
		} else
			$qb->add('where','tmp.IsDeleted =0');
	*/		
				
		//get Total Rows
		$qb1 = $em->createQueryBuilder();
	if(!isset($joinedTable)){
		$qb1->add('select', 'count(tmp.id)')
		   ->add('from', get_class($this).' tmp');
		}else {
			$subquery= $em->createQueryBuilder();
			$subquery
			->select('TBIDS.id')
			->from($joinedTable->getClass(),'tmp1')
			->innerJoin('tmp1.'.$joinedTable->getProp(), 'TBIDS')
			;
			$jointbwhstr = $joinedTable->getWhereString();
			$jointbwhparam = $joinedTable->getWhereParam();
			
			if(isset($jointbwhstr)) {
				$subquery->add('where',$joinedTable->getWhereString());
				if(isset($jointbwhparam)) 
					$subquery->setParameters($joinedTable->getWhereParam());
					
			$qb1->add('select', 'count(tmp.id)')
		   ->add('from', get_class($this).' tmp');
		   
		   $qb1->add('where','tmp.id in ('.$subquery->getDQL().')');
		   $qb1->setParameters($subquery->getParameters());
			}
		}
	if(isset($joinedTable))
		{
			if($whstr!=''){
				$qb1->andWhere($whstr.' and tmp.IsDeleted = 0 ');
				if(isset($whparam)) $qb1->setParameters($whparam);
			}
			else 
			{
				$qb1->andWhere('tmp.IsDeleted = 0');
			}
		}else 
			if($whstr!='') {
				$qb1->add('where',$whstr.' and tmp.IsDeleted = 0 ');
				 if(isset($whparam))$qb1->setParameters($whparam);
			}
			else
				$qb1->add('where','tmp.IsDeleted =0');
		$dql = $qb1->getQuery();
		
		$tmptest = $dql->getResult();
		$totalRows = $tmptest[0][1];
		
		return array('totalRows'=>$totalRows,'results'=>$results);
	}
	
	/**
	* Returns the list of attribute names.
	* By default, this method returns all public properties of the class.
	* You may override this method to change the default.
	* @return array list of attribute names. Defaults to all public properties of the class.
	*/
	public function attributeNames()
	{
		$className=get_class($this);
		if(!isset(self::$_names[$className]))
		{
			$class=new ReflectionClass(get_class($this));
			$names=array();
			foreach($class->getProperties() as $property)
			{
				$name=$property->getName();
				if($property->isPublic() && !$property->isStatic())
				$names[]=$name;
			}
			return self::$_names[$className]=$names;
		}
		else
		return self::$_names[$className];
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
