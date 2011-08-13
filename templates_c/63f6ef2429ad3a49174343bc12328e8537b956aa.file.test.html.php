<?php /* Smarty version Smarty-3.0.8, created on 2011-08-11 08:43:00
         compiled from "./templates/test.html" */ ?>
<?php /*%%SmartyHeaderCode:19511688804e43961480af91-28123937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '63f6ef2429ad3a49174343bc12328e8537b956aa' => 
    array (
      0 => './templates/test.html',
      1 => 1313052177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19511688804e43961480af91-28123937',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
  
</head>
<body dir="rtl">

<?php echo $_smarty_tpl->getVariable('SmartClientJs')->value;?>


<script type="text/javascript" charset="utf-8">

var dsMasterName = "<?php echo $_smarty_tpl->getVariable('dsMaster')->value;?>
"; 
var frmMasterName = "frm<?php echo $_smarty_tpl->getVariable('dsMaster')->value;?>
";
var MasterGridName = "<?php echo $_smarty_tpl->getVariable('dsMaster')->value;?>
Grid";


isc.RestDataSource.create({
	ID:dsMasterName,
	fields:
		[
			{hidden:"true",name:"id",primaryKey:"true",type:"integer"},
			{name:"Name",type:"string",title:"نام"},
			{name:"Description",type:"string",title:"شرح", length:2000}
			],
	dataFormat:"json",
	
	fetchDataURL:"index.php/?phpmodule=<?php echo $_smarty_tpl->getVariable('currentFile')->value;?>
",
	addDataURL :"index.php?phpmodule=<?php echo $_smarty_tpl->getVariable('currentFile')->value;?>
",
	updateDataURL:"index.php?phpmodule=<?php echo $_smarty_tpl->getVariable('currentFile')->value;?>
",
	removeDataURL:"index.php?phpmodule=<?php echo $_smarty_tpl->getVariable('currentFile')->value;?>
"
			});

isc.ListGrid.create({
	showFilterEditor: true,
	allowFilterExpressions: true,
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


isc.HLayout.create({
	ID:"con",
    width: "100%",
    height: "100%",
 	defaultLayoutAlign: "right",
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
