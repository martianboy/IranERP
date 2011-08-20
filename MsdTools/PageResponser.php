<?php
require_once 'MsdTools/Common.php';
require_once 'MsdTools/RestDataSource.php';

class PageResponser 
{
	public static function RemoveRecord($ClassName,$em) {
	    try {
       		$cls=$em->getRepository($ClassName)
    				->find(Common::GetVar('id'));
    		$cls->setEntityManager($em);
			$cls->setIsDeleted(true);

       		$cls->Save($em);
       		$em->flush();

       		RestDataSource::RemoveResponse($cls->GetClassSCPropertiesInArray());//array()

		} catch(Exception $e) {
    		RestDataSource::SendErrorToClient(-1,"Error in remove");
		}
	}
	
	public static function UpdateRecord($ClassName,$em)
	{
		try {
       		$cls=$em->getRepository($ClassName)
    				->find(Common::GetVar('id'));
    		$cls->setEntityManager($em);
			$cls->CreateClassFromScUsingMethod('Common::GetVar',array("ID"));    								
       		$cls->Save($em);
       		$em->flush();

       		RestDataSource::UpdateResponse($cls->GetClassSCPropertiesInArray());

		} catch(Exception $e) {
    		RestDataSource::SendErrorToClient(-4,array("Name"=>array("errorMessage"=>$e->getMessage())));
		}
	}
	
	public static  function AddRecord($ClassName,$em)
	{
    	try{
    		$r = new ReflectionClass($ClassName);
    		$cls=$r->newInstance();
    		$cls->setEntityManager($em);
       		$cls->CreateClassFromScUsingMethod('Common::GetVar');
       		$cls->Save($em);
       		$em->flush();
       		RestDataSource::AddResponse($cls->GetClassSCPropertiesInArray());
		} catch(Exception $e) {
    		RestDataSource::SendErrorToClient(-1,$e->getMessage());
		}
	}
	
	public static function  fetchResponse($ClassName,$em,$ExceptedProperties=NULL)
	{
	    $Perfix='_';
	    $startRow = Common::GetVar($Perfix.'startRow');
        $endRow =Common::GetVar($Perfix.'endRow');
        if($startRow==null) $startRow =0;
        if($endRow==null) $endRow = 100;
        $totalRows=0;

	    try {
			$OneRecord = Common::GetVar("id");
			if($OneRecord!=null)
			{
				$cls=$em->getRepository($ClassName)
							->find($OneRecord);
				RestDataSource::AddResponse(array($cls->GetClassSCPropertiesInArray()));
    			return;
			}

			//Get sortBy Defines
			$orderby=array();
			$order= Common::GetVar($Perfix.'sortBy');
			$jsoncriteria = Common::GetVar('criteria');
			$criteria = array();
			if($jsoncriteria!=null)
				if (is_array($jsoncriteria))
					foreach($jsoncriteria as $v) 
						$criteria[]=get_object_vars(json_decode($v));
				else
					$criteria[]=get_object_vars(json_decode($jsoncriteria));

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
			$cls->setEntityManager($em);
			$rtn=$cls->fetchObjects($em,$startRow,$endRow,$whstr,$whparam,$orderby);
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
