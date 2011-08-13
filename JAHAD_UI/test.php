<?php
define('dsMaster','Matter');


$dataSources=array(dsMaster=>array('ClassName'=>'Matter','Title'=>'موضوعاتا'));
$Perfix='_';
//Set Page Content Charset
header('Content-Type: text/html;charset=utf-8');
    $currentFile = 'test';
     //Detect Operation 
    $optype = GetVar($Perfix.'operationType');
      
    $startRow = GetVar($Perfix.'startRow');
    $endRow = GetVar($Perfix.'endRow');
    if($startRow==null) $startRow =0;
    if($endRow==null) $endRow = 100;
    $totalRows=0;
       switch($optype){
    	case 'fetch':
    		switch(GetVar($Perfix.'dataSource'))
    		{
    			case dsMaster:
    				try{
    				$OneRecord = GetVar("id");
    				if($OneRecord!=null)
    				{
    					$cls=$em->getRepository($dataSources[dsMaster]['ClassName'])
    								->find($OneRecord);
    					
    				RestDataSource::AddResponse(array($cls->GetClassSCPropertiesInArray()));
    				break;
    				}
    				
    				//Get sortBy Defines
    				$orderby=array();
    				$order= GetVar($Perfix.'sortBy');
    				$jsoncriteria = GetVar('criteria');
    				$criteria = array();
    				if($jsoncriteria!=null)
    					foreach($jsoncriteria as $v) 
    						$criteria[]=get_object_vars(json_decode($v));
    				
    				
    				if($order!=null)
	    				if(is_array($order))
	    					foreach($order as $fieldname)
	    					{
	    						if(substr($fieldname,0,1)=='-') $orderby[substr($fieldname,1,strlen($fieldname)-1)]='DESC';
	    						else $orderby[$fieldname]='ASC';
	    					}
	    			    else{
	    			    	if(substr($order,0,1)=='-')
	    			    		 $orderby[substr($order,1,strlen($order)-1)]='DESC';
	    					else 
	    						 $orderby[$order]='ASC';
	    						
	    			    }
	    			// if(count($criteria)>0) print_r($jsoncriteria);
    				/*
    				$results= $em->getRepository($dataSources[dsMaster]['ClassName'])
    								->findBy(
    										array('IsDeleted'=>0),
    										$orderby,
    										$endRow-$startRow,
    										$startRow
    										);*/
	    			$wh = setwhere($criteria);
	    			$whstr='';$whparam =null;
	    			if (count($criteria)>0){$whstr = $wh[0];$whparam=$wh[1];}
	    			$qb = $em->createQueryBuilder();
	    			$qb->add('select', 'tmp')
					   ->add('from', $dataSources[dsMaster]['ClassName'].' tmp')
					   ->setFirstResult( $startRow )
   					   ->setMaxResults( $endRow-$startRow )
   					   ;
   					   $tmp=0;
   					   foreach($orderby as $fn=>$kn) {if($tmp==0) {$qb->orderBy('tmp.'.$fn,$kn);$tmp=1;} else $qb->addOrderBy('tmp.'.$fn,$kn);}
					   if($whstr!='') {$qb->add('where',$whstr);$qb->setParameters($whparam);}
					  
					 $query = $qb->getQuery();
					 
					 
					 $results = $query->getResult();
													 
    				//get Total Rows
    				$dql = "SELECT count(tmp.id)  FROM ".$dataSources[dsMaster]['ClassName']." tmp " .
				     		  "WHERE tmp.IsDeleted = ?1";
    				
    				if($whstr!='') {
    					$dql = $dql . ' and '. $whstr;
    				}
    				$dql_query = $em->createQuery($dql);
    				$dql_query->setParameter(1, 0);
    				
    				if($whstr!='')
    				foreach($whparam as $k=>$p) $dql_query->setParameter($k,$p);
    				 
					$totalRows = $em->getSingleScalarResult();
					print_r($totalRows);
				    //Making Result Array
				    $resarr = array();
				    foreach($results as $item)
				    $resarr[]=$item->GetClassSCPropertiesInArray();
				    RestDataSource::fetchResponse($startRow,$endRow,$totalRows,$resarr);
    				}catch(Exception $e){print_r($e);}
		    	
    		}
    			break;
    	case 'add':
    		
    		//Get Class Instance
    		try{
    			 	
    		$r = new ReflectionClass($dataSources[dsMaster]['ClassName']);
    		$cls=$r->newInstance();
       		$cls->CreateClassFromScUsingMethod('GetVar');
       		$cls->Save($em);
       		$em->flush();
      
       		RestDataSource::AddResponse($cls->GetClassSCPropertiesInArray());
       		
    		} catch(Exception $e)
    		{
    		RestDataSource::SendErrorToClient(-1,$e->getMessage());
    		
    		}
    		break;
    	case 'update':
       	try{
    		$r = new ReflectionClass($dataSources[dsMaster]['ClassName']);
    		$cls=$r->newInstance();
       		$cls->CreateClassFromScUsingMethod('GetVar');
       		$cls=$em->getRepository($dataSources[dsMaster]['ClassName'])
    								->find($cls->getID());
			$cls->CreateClassFromScUsingMethod('GetVar',array("ID"));    								
       		$cls->Save($em);
       		$em->flush();
      
       		RestDataSource::UpdateResponse($cls->GetClassSCPropertiesInArray());
       		
    		} catch(Exception $e)
    		{
    		RestDataSource::SendErrorToClient(-4,array("Name"=>array("errorMessage"=>$e->getMessage())));
    		
    		}
    		break;
    	case 'remove':
       	try{
    		$r = new ReflectionClass($dataSources[dsMaster]['ClassName']);
    		$cls=$r->newInstance();
       		$cls->CreateClassFromScUsingMethod('GetVar');
       		$cls=$em->getRepository($dataSources[dsMaster]['ClassName'])
    								->find($cls->getID());
			$cls->setIsDeleted(true);
								
       		$cls->Save($em);
       		$em->flush();
      
       		RestDataSource::RemoveResponse($cls->GetClassSCPropertiesInArray());//array()
       		
    		} catch(Exception $e)
    		{
    		RestDataSource::SendErrorToClient(-1,"Error in remove");
    		
    		}
     		break;
    }
    ?>
    
    
    <?php 
    /**
     * Set Template Variables
     * 
     */
    $smarty->assign('SmartClientJs',GetSmartClientJs());
    $smarty->assign('dsMaster',dsMaster);
    $smarty->assign('currentFile',$currentFile);
    
    ?>
    
    
    <?php 
    if($optype != null) 
    {
    	die;
    }
    else{
	    $tpl=GetVar('tpl');
	    if($tpl==null) $tpl=$currentFile;
	    $tpl=$currentFile.'/'.$tpl;
	    $smarty->display($tpl.'.html');
    }
    
    
    ?>
  