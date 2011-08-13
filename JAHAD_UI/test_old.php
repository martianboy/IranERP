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
    				
    				$results= $em->getRepository($dataSources[dsMaster]['ClassName'])
    								->findBy(
    										array('IsDeleted'=>0),
    										$orderby,
    										$endRow-$startRow,
    										$startRow
    										);
    				//get Total Rows
    				$dql = "SELECT count(m.id)  FROM ".$dataSources[dsMaster]['ClassName']." m " .
				     		  "WHERE m.IsDeleted = ?1";
					$totalRows = $em->createQuery($dql)
				              		->setParameter(1, 0)
				            		->getSingleScalarResult();
				    //Making Result Array
				    $resarr = array();
				    foreach($results as $item)
				    $resarr[]=$item->GetClassSCPropertiesInArray();
				    RestDataSource::fetchResponse($startRow,$endRow,$totalRows,$resarr);
		    	
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
    <?php if($optype != null) die;?>
<html>
<head>
  
</head>
<body dir="rtl">

<?php echo GetSmartClientJs();?> 

<script type="text/javascript" charset="utf-8">

var dsMasterName = "<?php echo dsMaster;?>"; 
var frmMasterName = "<?php echo 'frm'.dsMaster;?>";
var MasterGridName = "<?php echo dsMaster.'Grid';?>";

isc.RestDataSource.create({
	ID:dsMasterName,
	fields:
		[
			{hidden:"true",name:"id",primaryKey:"true",type:"integer"},
			{name:"Name",type:"string",title:"نام"},
			{name:"Description",type:"string",title:"شرح", length:2000}
			],
	dataFormat:"json",
	fetchDataURL:"index.php/?phpmodule=<?php echo $currentFile;?>",
	addDataURL :"index.php?phpmodule=<?php echo $currentFile;?>",
	updateDataURL:"index.php?phpmodule=<?php echo $currentFile;?>",
	removeDataURL:"index.php?phpmodule=<?php echo $currentFile;?>"
			});

isc.ListGrid.create({
    ID: MasterGridName,
    width:"100%", height:"100%", alternateRecordStyles:true,
    autoFetchData: true,
    dataSource: dsMasterName,
    recordClick:"this.FillForm()",
    FillForm:function()
        {
			 var record = this.getSelectedRecord();
		     if (record == null) return ;
		   	 eval(frmMasterName).editRecord(record);
		     
        }

   });

isc.DynamicForm.create({
	ID:frmMasterName,
	dataSource:dsMasterName,
	numCols:2,
	useAllDataSourceFields:true,
	defaultLayoutAlign: "center"
	
});

var dsMaster = eval(dsMasterName);
var frmMaster = eval(frmMasterName);
var MasterGrid = eval(MasterGridName);
DisableForm(frmMaster);
isc.ToolStripButton.create({ID:"btnNew_Master",title:"جدید",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Health",click:function(){EnableForm(frmMaster);btnSave_Master.enable();btnNew_Master.disable();btnEdit_Master.disable();btnDelete_Master.disable();frmMaster.editNewRecord();}});
isc.ToolStripButton.create({ID:"btnSave_Master",title:"ذخیره",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Save",disabled:true,click:function(){DisableForm(frmMaster);SaveMaster();btnSave_Master.disable();btnNew_Master.enable();btnEdit_Master.enable();btnDelete_Master.enable();}});
isc.ToolStripButton.create({ID:"btnEdit_Master",title:"ویرایش",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Pen",click:function(){EnableForm(frmMaster);btnSave_Master.enable();btnNew_Master.disable();btnEdit_Master.disable();btnDelete_Master.disable();}});
isc.ToolStripButton.create({ID:"btnDelete_Master",title:"حذف",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Trash",click:function(){DeleteMaster();}});
isc.ToolStripButton.create({ID:"btnCancel_Master",title:"انصراف",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Cancel",click:function(){DisableForm(frmMaster);btnNew_Master.enable();btnEdit_Master.enable();btnSave_Master.disable();btnDelete_Master.enable();}});

isc.ToolStrip.create({
    width: "100%", 
    height:24, 
    ID:"ToolstripMaster",
    members: [btnNew_Master, "separator",
              btnEdit_Master, "separator",
              btnSave_Master,"separator", 
              btnDelete_Master,"separator", 
              btnCancel_Master]
});

isc.TabSet.create({
    ID: "theTabs",
		  height: 250,
		  tabBarAlign:"right",
	  tabs: [
    {title:"Item",
     pane: isc.DynamicForm.create({
     ID: "form0",
     valuesManager:"vm",
            fields: [
                {name: "itemName", type:"text", title:"تست۱"},
                {name: "description", type:"textArea", title:"تست ۲"},
                {name:"price", type:"float", title: "Price", defaultValue: "low"} 
            ]
        })
    }]})  ;  

isc.HLayout.create({
	ID:"con",
    width: "100%",
    height: "100%",
 	defaultLayoutAlign: "center",
    members: [
              isc.VLayout.create({
 				  defaultLayoutAlign: "right",
            	  showResizeBar:true,
                  Height:"100%",
                  width:"*",
                  members:[ToolstripMaster,	
                           frmMaster
						   ]
              }),
		     isc.VLayout.create({
			            width: "70%",
			            members: [MasterGrid ]
			       		 })
              ]
  });
 
isc.SectionStack.create({
    ID: "sectionStack",
    visibilityMode: "multiple",
    width: "100%", height: "100%",
    border:"1px solid blue",
    sections: [
        {title: "Blue Pawn", expanded: true,
             items: [ con ]},
        {title: "HTMLFlow", expanded: true, canCollapse: true, items: [theTabs]}
        
    ]
});




function SaveMaster()
{
	if(frmMaster.isNewRecord ())
	frmMaster.saveData();
	else
	{
		
		dsMaster.updateData(frmMaster.getValues());
		//MasterGrid.selection.selectSingle(0);
	}
}
function DeleteMaster()
{
	 var record = MasterGrid.getSelectedRecord();
     if (record == null) return ;
     MasterGrid.removeData(record);
     frmMaster.clearValues();
}

function EnableForm(frm)
{
for(var i=0;i<frm.getFields().length;i++) frm.getFields()[i].enable();
}
function DisableForm(frm)
{
for(var i=0;i<frm.getFields().length;i++) frm.getFields()[i].disable();
}

</script>



</body>
</html>
