<?php
date_default_timezone_set('UTC');

/**
 * @MappedSuperclass
 * @author masoud
 *
 */
class DbEntity
{
	
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
	

	public function getID(){return $this->id;}
	protected function setID($value){$this->id=$value;}
	
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

	public function CreateClassFromScUsingMethod($functionName,$ExceptedProperties)
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
			call_user_method($m,$this,$rtn);
		}
		
	}
	}
protected function parseObjectToArray() {
	$object = $this;
    $array = array();
    if (is_object($object)) {
        $array = get_object_vars($object);
    }
    return $array;
}



protected function _Save($EM){
	
	$EM->persist($this);
}

function Save($EM){$this->_Save($EM);}


function GetClassSCPropertiesInArray($ExceptedProperties)
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
			
			$rtnval[$propname]=call_user_method($m,$this);
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
	foreach($methods as $m){
		
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
	$this->LastModifyDate=new DateTime();
	$this->CreatedDate=new DateTime();
	
}
}




 function Delete($EM){}

function CreateClassFromSCArray( $a)
{
	
}


 
 
 
?>
