<script type="text/javascript">
var dsMasterName = "{$dsMaster}"; 
var frmMasterName = "frm{$dsMaster}";
var MasterGridName = "{$dsMaster}Grid";

{literal}
isc.RestDataSource.create({
    ID:dsMasterName,
    fields:
        [
            {hidden:"true",name:"id",primaryKey:"true",type:"integer"},
            {name:"Name",type:"string",title:"نام"},
            {name:"Description",type:"string",title:"شرح", length:2000}
            ],
    dataFormat:"json",
    operationBindings:[
     {operationType:"fetch", dataProtocol:"getParams"},
     {operationType:"add", dataProtocol:"postParams"},
     {operationType:"remove", dataProtocol:"postParams", requestProperties:{httpMethod:"DELETE"}},
     {operationType:"update", dataProtocol:"postParams", requestProperties:{httpMethod:"PUT"}}
    ],
    {/literal}
    fetchDataURL :"{$this->baseUrl}/{$this->uniqueId}/",
    addDataURL   :"{$this->baseUrl}/{$this->uniqueId}/",
    updateDataURL:"{$this->baseUrl}/{$this->uniqueId}/",
    removeDataURL:"{$this->baseUrl}/{$this->uniqueId}/"
            });
{literal}
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
isc.ToolStripButton.create({ID:"btnDelete_Master",title:"حذف",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Trash",click:function(){
    ShowDialog(
            'اخطار حذف',
            'آیا از حذف مورد انتخاب شده اطمینان دارید؟',
            'بله',
            'خیر',
            'DeleteMaster'
            );
}});
isc.ToolStripButton.create({ID:"btnCancel_Master",title:"انصراف",  icon: "Images.php?Color=Orange&IconType=Icons&ActionType=Cancel",click:function(){DisableForm(frmMaster);btnNew_Master.enable();btnEdit_Master.enable();btnSave_Master.disable();btnDelete_Master.enable();}});

isc.ToolStrip.create({
    width: "300", 
    height:24, 
    ID:"ToolstripMaster",
    members: [btnNew_Master,   "separator",
              btnEdit_Master,  "separator",
              btnSave_Master,  "separator", 
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
                  width:"30%",
                  members:[ToolstripMaster, 
                           frmMaster
                           ]
              }),
             isc.VLayout.create({
                        width: "*",
                        members: [MasterGrid ]
                         })
              ]
  });

</script>
{/literal}
