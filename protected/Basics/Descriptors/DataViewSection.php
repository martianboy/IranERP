<?php
namespace IRERP\Basics\Descriptors;

use IRERP\Basics\Descriptors\Grid;
use IRERP\Basics\Descriptors\DynamicForm;
use IRERP\Basics\Descriptors\DataSource;
use IRERP\Basics\ClientFrameWork;

use IRERP\Basics\Descriptors\DescriptorBase;
class DataViewSection extends DescriptorBase
{
	/**
	 * 
	 * Enter description here ...
	 * @var DataSource
	 */
	protected $DataSource=NULL;
	/**
	 * 
	 * Enter description here ...
	 * @var DynamicForm
	 */
	protected $FORM=NULL;
	/**
	 * 
	 * Enter description here ...
	 * @var Grid
	 */
	protected $GRID=NULL;

	public function getPage(){return  $this->Page;}
	public function getDataSource(){return $this->DataSource;}
	
	
	public function __construct(DataSource $DS,DescriptorBase $Parent=NULL)
	{
		$this->DataSource=$DS;
		$this->setParentDescriptor($Parent);
		$this->MakeReady();
	}
	
	protected function MakeReady()
	{
		if(!isset($this->DataSource)) return ;
		$this->FORM= new DynamicForm($this->DataSource,$this);
		$this->GRID=new Grid($this->DataSource,$this);
		
	}
	public function GetID(){return 'SEC'.$this->DataSource->GetID();}
	public function getClientDVS(){return 'DVS_'.$this->GetID();}
	public function GenerateClientCode($ClientFrameWork)
	{
		switch ($ClientFrameWork)
		{
			case ClientFrameWork::SmartClient:
				$DVSID=$this->getClientDVS();
				$FORMID=$this->FORM->GetID();
				$GRIDID=$this->GRID->GetID();
				$SECID=$this->GetID();
				$rtnval='var '.$DVSID.'= new IRERPJS_DataViewSection(\''.$DVSID.'\');';
				$rtnval.= $this->FORM->GenerateClientCode($ClientFrameWork);
				$rtnval.= $this->GRID->GenerateClientCode($ClientFrameWork);
				$rtnval.= $DVSID.'.setFormId("'.$this->FORM->GetID().'");';
				$rtnval.= $DVSID.'.setGridId("'.$this->GRID->GetID().'");';
				
				$BTNID="btnNew_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",title:\"جدید\",IRERPDVS:$DVSID/*function(){EnableForm($FORMID);btnSave_$SECID.enable();btnNew_$SECID.disable();btnEdit_$SECID.disable();btnDelete_$SECID.disable();$FORMID.editNewRecord();}*/});";
				$rtnval.="$BTNID.click=function(){".$BTNID.".IRERPDVS.getPage().EventManager('OnNEWCommand',".$BTNID.",".$BTNID.".IRERPDVS);};";
				$rtnval.="$BTNID.setIcon($BTNID.IRERPDVS.getIconNew());";
				$rtnval.="$DVSID.addNEWCommander($BTNID);";
				
				$BTNID="btnSave_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",IRERPDVS:$DVSID,title:\"ذخیره\", disabled:true,/*click:function(){DisableForm($FORMID);SaveFormDetail($FORMID);btnSave_$SECID.disable();btnNew_$SECID.enable();btnEdit_$SECID.enable();btnDelete_$SECID.enable();}*/});";
				$rtnval.="$BTNID.click=function(){".$BTNID.".IRERPDVS.getPage().EventManager('OnSAVECommand',".$BTNID.",".$BTNID.".IRERPDVS);};";
				$rtnval.="$BTNID.setIcon($BTNID.IRERPDVS.getIconSave());";
				$rtnval.="$DVSID.addSAVECommander($BTNID);";
				
				$BTNID="btnEdit_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",IRERPDVS:$DVSID,title:\"ویرایش\",  icon: $DVSID.getIconEdit(),click:function(){EnableForm($FORMID);btnSave_$SECID.enable();btnNew_$SECID.disable();btnEdit_$SECID.disable();btnDelete_$SECID.disable();}});";
				$rtnval.="$BTNID.click=function(){".$BTNID.".IRERPDVS.getPage().EventManager('OnEDITCommand',".$BTNID.",".$BTNID.".IRERPDVS);};";
				$rtnval.="$BTNID.setIcon($BTNID.IRERPDVS.getIconEdit());";
				$rtnval.="$DVSID.addEDITCommander($BTNID);";
				
				$BTNID="btnDelete_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",IRERPDVS:$DVSID,title:\"حذف\",  icon: $DVSID.getIconDelete(),click:function(){";
				$rtnval.="ShowDialog(";
				$rtnval.="'اخطار حذف',";
				$rtnval.="'آیا از حذف مورد انتخاب شده اطمینان دارید؟',";
				$rtnval.="'بله',";
				$rtnval.="'خیر',";
				$rtnval.="'DeleteForm',$FORMID,$GRIDID";
				$rtnval.="            );	}});";
				$rtnval.="$BTNID.click=function(){".$BTNID.".IRERPDVS.getPage().EventManager('OnDELETECommand',".$BTNID.",".$BTNID.".IRERPDVS);};";
				$rtnval.="$BTNID.setIcon($BTNID.IRERPDVS.getIconDelete());";
				$rtnval.="$DVSID.addDELETECommander($BTNID);";
				
				$BTNID="btnCancel_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",IRERPDVS:$DVSID,title:\"انصراف\",  icon: icon_Cancel,click:function(){DisableForm($FORMID);btnNew_$SECID.enable();btnEdit_$SECID.enable();btnSave_$SECID.disable();btnDelete_$SECID.enable();}});";
				
				$BTNID="btnRefresh_$SECID";
				$rtnval.="isc.ToolStripButton.create({ID:\"$BTNID\",IRERPDVS:$DVSID,title:\"بارگزاری مجدد\",});";
				$rtnval.="$BTNID.click=function(){".$BTNID.".IRERPDVS.getPage().EventManager('OnRefreshCommand',".$BTNID.",".$BTNID.".IRERPDVS);};";
				$rtnval.="$BTNID.setIcon($BTNID.IRERPDVS.getIconRefresh());";
				
				
				
				$rtnval.="	isc.ToolStrip.create({	    width: \"100%\",	    height:24,	    ID:\"Toolstrip$SECID\",	    members: [btnNew_$SECID, \"separator\",";
				$rtnval.="   btnEdit_$SECID, \"separator\",";
				$rtnval.="              btnSave_$SECID,\"separator\",";
				$rtnval.="            btnDelete_$SECID,\"separator\",";
				$rtnval.="        btnCancel_$SECID,\"separator\",btnRefresh_$SECID]	});";
				
				
				
				
				
				$rtnval.="isc.HLayout.create({";
				$rtnval.="ID:\"$SECID\",";
				$rtnval.="width: \"100%\",";
				$rtnval.="height: \"100%\",";
				$rtnval.="defaultLayoutAlign: \"right\",";
				$rtnval.=" members: [";
				$rtnval.="isc.VLayout.create({";
				$rtnval.="defaultLayoutAlign: \"right\",";
				$rtnval.="showResizeBar:true,";
				$rtnval.="Height:\"100%\",";
				$rtnval.=" width:\"*\",";
				$rtnval.="	members:[Toolstrip$SECID,$FORMID";
				$rtnval.="]}),";
				$rtnval.="isc.VLayout.create({";
				$rtnval.=" width: \"65%\",";
				$rtnval.="members: [$GRIDID ]";
				$rtnval.="	                         })	              ]	  });		";
				return $rtnval;
				break;
		}
		
	}

	public function getForm(){return $this->FORM;}
	public function getGrid(){return $this->GRID;}
}
?>