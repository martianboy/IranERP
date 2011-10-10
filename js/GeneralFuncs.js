
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
function DeleteMaster(ans)
{
    if(ans=='YES'){
     var record = MasterGrid.getSelectedRecord();
     if (record == null) return ;
     MasterGrid.removeData(record);
     frmMaster.clearValues();
    }
}

function EnableForm(frm)
{
for(var i=0;i<frm.getFields().length;i++) frm.getFields()[i].enable();
}
function DisableForm(frm)
{
for(var i=0;i<frm.getFields().length;i++) frm.getFields()[i].disable();
}

function ShowDialog(Title,Message,Yes,No,afterclose)
{
    isc.Window.create({
        ID:"dlgQuest",
        height:100,
        width:300,
        canDragResize: true,
        autoCenter:true,
        isModal:true,
        autoSize:true,
        align:"right",
        headerControls : [ "closeButton",
                            "minimizeButton", isc.Label.create({
                                            height: "100%",
                                            width: "100%",
                                            contents: Title,
                                            align:"center"
                                        })
                            
                     ],
        items:[
                    isc.VLayout.create({
                        defaultLayoutAlign: "center",
                        width: "100%",
                        height: "100%",
                        layoutMargin: 6,
                        membersMargin: 6,
                        border: "1px",
                        align: "center",  // As promised!
                        members: [
                            isc.Label.create({
                                height: "100%",
                                width: "100%",
                                contents: Message,
                                align:"center"
                            }),
                           isc.HLayout.create({
                                layoutMargin: 6,
                                membersMargin: 6,
                                border: "1px",
                                defaultLayoutAlign:"center",
                                members:[
                                            isc.Label.create({width:"*"}),
                                            isc.Button.create({title:Yes,click:function(){dlgQuest.hide();eval(afterclose+'("YES")');}}),
                                            isc.Button.create({title:No,click:function(){dlgQuest.hide();eval(afterclose+'("NO")');}}),
                                            isc.Label.create({width:"*"})
                                            ]

                          })
                        ]
                    })
                ]
        
    });
}
function AfterUploadFile(filename,DynForm,Field)
{
Field.setValue(filename);
}
function ShowUploadDialog(obj,afterclose)
{
	alert(baseurl);
	alert(window.baseurl);
    isc.HTMLPane.create({
        ID:"myPane",
        height: "100%",
        width: "100%",
        scrollbarSize:0
    });
    var iframeid='jjjli12d';
    var content= "<iframe scrolling=\"no\" width=\"100%\" height=\"100%\" id=\'"+iframeid+"\' ";
    content += "src=\'"+baseurl+"/upload/\' style=\"width:100%;height:100%;border:none;\"/>";
    
    myPane.setContents(content);
    var args=[];
	   for(var i=2; i < arguments.length; i++)
	    {
	        args.push(arguments[i]);
	    }
     isc.Window.create({
        ID:"dlgUploadFile",
        ARGS:args,
        obj:obj,
        height:200,
        width:300,
        canDragResize: true,
        isModal:true,
        align:"right",
        autoCenter:true,
        title:"بارگذاری پرونده",
        items:[
               isc.Button.create({title:'پرونده مورد تایید است',click:function(){
            	   dlgUploadFile.hide();
            	   if(afterclose!=null) try{
                	   //Get File Name
                	   
                	   filename=document.getElementById(iframeid).contentWindow.getFileName();
                	   dlgUploadFile.ARGS.splice(0,0,filename);
                	   
                	   afterclose.apply(dlgUploadFile.obj,
                        	   dlgUploadFile.ARGS);

                	   }catch(err){}
                   }})
               ,
    			myPane
               ]
        
    });
}
