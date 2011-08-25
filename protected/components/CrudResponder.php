<?php
//require_once 'ApplicationHelpers.php';
//require_once 'RestDataSource.php';
require_once 'WhereMaker.php';

class CrudResponder 
{
	public static function RemoveRecord($ClassName,$em=NULL) {
		$em = Yii::app()->doctrine->getEntityManager();
		 
	    try {
       		$cls=$em->getRepository($ClassName)
    				->find(ApplicationHelpers::GetVar('id'));
    		$cls->setEntityManager($em);
			$cls->setIsDeleted(true);

       		$cls->Save($em);
       		$em->flush();

       		RestDataSource::RemoveResponse($cls->GetClassSCPropertiesInArray());//array()

		} catch(Exception $e) {
    		RestDataSource::SendErrorToClient(-1,"Error in remove");
		}
	}
	
	public static function UpdateRecord($ClassName,$em=NULL)
	{
		$em = Yii::app()->doctrine->getEntityManager();
		 
		try {
       		$cls=$em->getRepository($ClassName)
    				->find(ApplicationHelpers::GetVar('id'));
			$cls->CreateClassFromScUsingMethod('ApplicationHelpers::GetVar',array("ID"));    								
       		//print_r($cls); die;
			$cls->Save($em);
       		$em->flush();

       		RestDataSource::UpdateResponse($cls->GetClassSCPropertiesInArray());

		} catch(Exception $e) {
    		RestDataSource::SendErrorToClient(-4,array("Name"=>array("errorMessage"=>$e->getMessage())));
		}
	}
	
	public static  function AddRecord($ClassName,$params=array(), $em=NULL)
	{
		$em = Yii::app()->doctrine->getEntityManager();
		
		try{
    		$r = new ReflectionClass($ClassName);
    		$cls=$r->newInstance();
    		$cls->CreateClassFromScUsingMethod('ApplicationHelpers::GetVar');
       		$cls->Save();
       		$em->flush();
       		RestDataSource::AddResponse($cls->GetClassSCPropertiesInArray());
		} catch(Exception $e) {
			throw $e;
    		//RestDataSource::SendErrorToClient(-1,$e->getMessage());
		}
	}
	
	public static function fetchResponse($ClassName, $params=array(),$ExceptedProperties=NULL)
	{
		$em = Yii::app()->doctrine->getEntityManager();
		
	    $Prefix='_';
	    $startRow = $params[$Prefix.'startRow'];
        $endRow = $params[$Prefix.'endRow'];
        if($startRow==null) $startRow =0;
        if($endRow==null) $endRow = 100;
        $totalRows=0;

		try {
			if (isset($params['id'])) {
				$OneRecord = $params["id"];
				$cls=$em->getRepository($ClassName)
						->find($OneRecord);
				RestDataSource::AddResponse(array($cls->GetClassSCPropertiesInArray()));
    			return;
			}

			//Get sortBy Defines
			$orderby=array();
			$order = null;
			if (isset($params[$Prefix.'sortBy'])) 
				$order= $params[$Prefix.'sortBy'];
			
			$criteria = array();
			if (isset($params[$Prefix.'criteria'])) {
				$jsoncriteria = $params['criteria'];
				if($jsoncriteria!=null)
					if (is_array($jsoncriteria))
						foreach($jsoncriteria as $v) 
							$criteria[]=get_object_vars(json_decode($v));
					else
						$criteria[]=get_object_vars(json_decode($jsoncriteria));
			}
			if($order!=null)
				if(is_array($order))
					foreach($order as $fieldname)
					    if(substr($fieldname,0,1)=='-') 
					        $orderby[substr($fieldname,1,strlen($fieldname)-1)]='DESC';
						else 
						    $orderby[$fieldname]='ASC';
			    else
			    	if(substr($order,0,1)=='-')
			    		 $orderby[substr($order,1,strlen($order)-1)]='DESC';
					else 
						 $orderby[$order]='ASC';

			$wh = setwhere($criteria);
			$whstr='';
			$whparam =null;
			if (count($criteria)>0){
				$whstr = $wh[0];
				$whparam=$wh[1];
			}
			
			//Get Objects Form Db
			$cls=new ReflectionClass($ClassName);
			$cls=$cls->newInstance();
			$rtn=$cls->fetchObjects($startRow,$endRow,$whstr,$whparam,$orderby);
			$results=$rtn['results'];
			$totalRows=$rtn['totalRows'];
			
			//Making Result Array
		    $resarr = array();
		    foreach($results as $item)
				$resarr[]=$item->GetClassSCPropertiesInArray($ExceptedProperties);
		    
		    RestDataSource::fetchResponse($startRow,$endRow,$totalRows,$resarr);
		} catch(Exception $e) {
		    print_r($e);
        }
	}
}
?>
