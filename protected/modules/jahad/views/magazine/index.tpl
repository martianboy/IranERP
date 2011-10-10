<script type="text/javascript">
var dsMasterName = "{$dsMaster}"; 
var frmMasterName = "frm{$dsMaster}";
var MasterGridName = "{$dsMaster}Grid";
{literal}
function TitleClick(DataSourceAddress)
{
alert(DataSourceAddress);
}
 
isc.RestDataSource.create({
    ID:dsMasterName,
    fields:
        [
            {hidden:"true",name:"id",primaryKey:"true",type:"integer"},
            {type:"string",name:"TitleName",title:"عنوان"},
            {type:"integer",name:"onvan_id",title:"عنوان",hidden:true},
            {type:"string",name:"MagTypeName",title:"نوع مجله"},
            {type:"integer",name:"MagTypeid",title:"نوع مجله",hidden:true}
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
isc.RestDataSource.create({
    ID:"Title",
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
    fetchDataURL :"{$this->baseUrl}/jahad/Title/",
    addDataURL   :"{$this->baseUrl}/jahad/Title/",
    updateDataURL:"{$this->baseUrl}/jahad/Title/",
    removeDataURL:"{$this->baseUrl}/jahad/Title/"
            });

{literal}
isc.RestDataSource.create({
    ID:"MagazineType",
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
    fetchDataURL :"{$this->baseUrl}/jahad/MagazineType/",
    addDataURL   :"{$this->baseUrl}/jahad/MagazineType/",
    updateDataURL:"{$this->baseUrl}/jahad/MagazineType/",
    removeDataURL:"{$this->baseUrl}/jahad/MagazineType/"
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
             if(record.id!=eval(frmMasterName).getValues()['id'])
             {
            	 ChangesDetailMasterId(record.id);
             }
             eval(frmMasterName).editRecord(record);
             
             
        }

   });

isc.DynamicForm.create({
    ID:frmMasterName,
    dataSource:dsMasterName,
    numCols:2,
    useAllDataSourceFields:true,
    defaultLayoutAlign: "center",
    fields:
        [
            {name:"id"},
            {name:"TitleName",hidden:true},
            {name:"onvan_id",hidden:false,editorType:"SelectItem",
            optionDataSource:"Title",displayField:"Name",
            pickListProperties:{showFilterEditor:true},pickListFields:[{name:"Name"},{name:"Description"}]
            ,
            
	            titleClick:function(a,b){
	            isc.Window.create({
				        height:500,
				        width:500,
				        canDragResize: true,
				        isModal:true,
				        align: "center",
				        autoCenter:true,
				        showMaximizeButton:true,
				        closeClick:function(){isc_PickListMenu_9.fetchData();this.hide();},
				        src:"http://localhost/IranERP/jahad/title"});
	            }
            },
            {name:"MagTypeName",hidden:true},
            {name:"MagTypeid",hidden:false,editorType:"SelectItem",
            optionDataSource:"MagazineType",displayField:"Name",valueField:"id",
            pickListProperties:{showFilterEditor:true},pickListFields:[{name:"Name"},{name:"Description"}]
            }
        ]
    
});

var dsMaster = eval(dsMasterName);
var frmMaster = eval(frmMasterName);
var MasterGrid = eval(MasterGridName);
DisableForm(frmMaster);
isc.ToolStripButton.create({ID:"btnNew_Master",title:"جدید", click:function(){EnableForm(frmMaster);btnSave_Master.enable();btnNew_Master.disable();btnEdit_Master.disable();btnDelete_Master.disable();frmMaster.editNewRecord();}});
isc.ToolStripButton.create({ID:"btnSave_Master",title:"ذخیره",  disabled:true,click:function(){DisableForm(frmMaster);SaveMaster();btnSave_Master.disable();btnNew_Master.enable();btnEdit_Master.enable();btnDelete_Master.enable();}});
isc.ToolStripButton.create({ID:"btnEdit_Master",title:"ویرایش",click:function(){EnableForm(frmMaster);btnSave_Master.enable();btnNew_Master.disable();btnEdit_Master.disable();btnDelete_Master.disable();}});
isc.ToolStripButton.create({ID:"btnDelete_Master",title:"حذف", click:function(){
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
    ID:"MasterFrame",
    width: "100%",
    height: "50%",
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


/***********************************************************************************************
  Detail Section - Matter
 */
 var detailGrid1Name = 'Detail_Matter_Grid';
 var detailForm1Name = 'Detail_Matter_Form';
 var detailDs1Name='Magazine_Matter';

 isc.RestDataSource.create({
	    ID:"Matter",
	    fields:
	        [   {hidden:"true",name:"HelpField",primaryKey:"true",type:"integer"},
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
	    fetchDataURL :"{$this->baseUrl}/jahad/Matter/",
	    addDataURL   :"{$this->baseUrl}/jahad/Matter/",
	    updateDataURL:"{$this->baseUrl}/jahad/Matter/",
	    removeDataURL:"{$this->baseUrl}/jahad/Matter/"
	            });
{literal}

 
 isc.RestDataSource.create({
	    ID:detailDs1Name,
	    fields:
	        [   {hidden:"true",name:"HelpField",primaryKey:"true",type:"integer"},
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
	    fetchDataURL :"{$this->baseUrl}/jahad/matter/jdsenum/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/mozu/",
	    addDataURL   :"{$this->baseUrl}/jahad/matter/jdsenum/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/mozu/",
	    updateDataURL:"{$this->baseUrl}/jahad/matter/jdsenum/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/mozu/",
	    removeDataURL:"{$this->baseUrl}/jahad/matter/jdsenum/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/mozu/"
	            });
{literal}
isc.ListGrid.create({
	    showFilterEditor: true,
	    allowFilterExpressions: true,
	    initialCriteria:{
	        HelpField : "1"
	     },
	    ID: detailGrid1Name,
	    width:"100%", height:"100%", alternateRecordStyles:true,
	    autoFetchData: true,
	    dataSource: detailDs1Name,
	    recordClick:"this.FillForm()",
	    FillForm:function()
	        {
	             var record = this.getSelectedRecord();
	             if (record == null) return ;
	             eval(detailForm1Name).editRecord(record);
	             
	        }

	   });

	isc.DynamicForm.create({
	    ID:detailForm1Name,
	    dataSource:detailDs1Name,
	    numCols:2,
	    useAllDataSourceFields:true,
	    defaultLayoutAlign: "center",
	    HelpField:1,
	    fields:[
	            {name:"Name",hidden:true},{name:"Description",hidden:true},
	            {name:"id",hidden:false,editorType:"SelectItem",
	                optionDataSource:'Matter',displayField:"Name",valueField:"id",
	                pickListProperties:{showFilterEditor:true},pickListFields:[{name:"Name"},{name:"Description"}]
	                }
	    	    ]
	});
 

	{/literal}
	{$this->GetInitDetail(1)}
	{$this->GetDetailToolbar(1)}
	{$this->GetDetailLayout(1)}
	{literal}

 /*****************************************************/

 
 /***********************************************************************************************
  Detail Section - MagazineVersion
 */
 var detailGrid2Name = 'Detail_MagazineVersion_Grid';
 var detailForm2Name = 'Detail_MagazineVersion_Form';
 var detailDs2Name='Magazine_MagazineVersion';

 isc.RestDataSource.create({
	    ID:"Year",
	    fields:
	        [   {hidden:"true",name:"HelpField",primaryKey:"true",type:"integer"},
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
	    fetchDataURL :"{$this->baseUrl}/jahad/Year/",
	    addDataURL   :"{$this->baseUrl}/jahad/Year/",
	    updateDataURL:"{$this->baseUrl}/jahad/Year/",
	    removeDataURL:"{$this->baseUrl}/jahad/Year/"
	            });
{literal}

 
 isc.RestDataSource.create({
	    ID:detailDs2Name,
	    fields:
	        [   {hidden:"true",name:"HelpField",primaryKey:"true",type:"integer"},
	            {hidden:"true",name:"id",primaryKey:"true",type:"integer"},
	            {name:"YearID",type:"integer",hidden:"true",title:"سال"},
	            {name:"YearTitle",type:"string",title:"سال"},
	            {name:"Shomare",type:"string",title:"شماره"},
	            {name:"Tirajh",type:"string",title:"تبراژ"}
	            ],
	    dataFormat:"json",
	    operationBindings:[
	     {operationType:"fetch", dataProtocol:"getParams"},
	     {operationType:"add", dataProtocol:"postParams"},
	     {operationType:"remove", dataProtocol:"postParams", requestProperties:{httpMethod:"DELETE"}},
	     {operationType:"update", dataProtocol:"postParams", requestProperties:{httpMethod:"PUT"}}
	    ],
	    {/literal}
	    fetchDataURL :"{$this->baseUrl}/jahad/MagazineVersion/jds/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/magver/",
	    addDataURL   :"{$this->baseUrl}/jahad/MagazineVersion/jds/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/magver/",
	    updateDataURL:"{$this->baseUrl}/jahad/MagazineVersion/jds/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/magver/",
	    removeDataURL:"{$this->baseUrl}/jahad/MagazineVersion/jds/_5cIRERP_5cmodules_5cjahad_5cmodels_5cMagazine/magver/",
	            });
{literal}
isc.ListGrid.create({
	    showFilterEditor: true,
	    allowFilterExpressions: true,
	    initialCriteria:{
	        HelpField : "1"
	     },
	    ID: detailGrid2Name,
	    width:"100%", height:"100%", alternateRecordStyles:true,
	    autoFetchData: true,
	    dataSource: detailDs2Name,
	    recordClick:"this.FillForm()",
	    FillForm:function()
	        {
	             var record = this.getSelectedRecord();
	             if (record == null) return ;
	             eval(detailForm2Name).editRecord(record);
	             
	        }

	   });

	isc.DynamicForm.create({
	    ID:detailForm2Name,
	    dataSource:detailDs2Name,
	    numCols:2,
	    useAllDataSourceFields:true,
	    defaultLayoutAlign: "center",
	    HelpField:1,
	    fields:[
	    	    
	            {name:"YearTitle",hidden:true},
	            {name:"YearID",hidden:false,editorType:"SelectItem",
	                optionDataSource:'Year',displayField:"Name",valueField:"id",
	                pickListProperties:{showFilterEditor:true},pickListFields:[{name:"Name"},{name:"Description"}]
	                }
	    	    ]
	});

	{/literal}
	{$this->GetInitDetail(2)}
	{$this->GetDetailToolbar(2)}
	{$this->GetDetailLayout(2)}
	{literal}
	 

 /*****************************************************/
 
 
 
 isc.TabSet.create({
    ID:"itemDetailTabs",
    defaultLayoutAlign: "right",
    align:"right",
    tabBarAlign:"right",
    tabs:[
			{title:"موضوعات یک مجله",pane:detail1Frame,ID:"detail1FrameTab" },
			{title:"نسخه های مجله",pane:detail2Frame,ID:"detail2FrameTab" },
				 
          ]});
 

isc.SectionStack.create({
    ID:"rightSideLayout",
    width:"100%",height:"100%",
    visibilityMode:"multiple",
    animateSections:true,
    sections:[
              {title:"مجلات", autoShow:true, items:[MasterFrame]},
              {title:"جزییات مربوط به مجله انتخاب شده",autoShow:true,items:[itemDetailTabs]}              

              ]});




</script>
{/literal}