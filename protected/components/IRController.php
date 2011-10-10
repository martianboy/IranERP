<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class IRController extends CController
{
	/**
	 * context menu items. This property will be assigned to {@link CMenu::items}.
	 * @var array
	 */
	public $menu=array();
	
	public $direction = 'rtl';
	
	public function __construct($id,$m=NULL)
	{
		parent::__construct($id,$m);
		Yii::app()->ir_ClassLoader->nop();
		Yii::app()->doctrine->nop();
	}
	
	/**
	 * 
	 * Static resources for all controllers.
	 * @var array
	 */
	public $globalResources = array();
	
	protected function getIsGetRequest()
	{
		$req = Yii::app()->getRequest();
		return !($req->getIsDeleteRequest() || $req->getIsPostRequest() || $req->getIsPutRequest());
	}
	
	/**
	*
	* Sends raw response with desired content-type
	* @param object $response
	* @param string $contentType
	*/
	public function ajaxRespond($response, $contentType)
	{
		header('Content-Type: ' . $contentType . '; charset=utf-8');
		echo $response;
	}
	
	/**
	 *
	 * Sends json response with content-type: text/json
	 * @param array $responseArray
	 */
	public function ajaxRespondJSON($responseArray)
	{
		$this->ajaxRespond(json_encode($responseArray), 'text/json');
	}
	
	
	// Below Function Must be Removed In Future
	public function GetDetailToolbar($DetailNumber)
	{
	$rtnval="isc.ToolStripButton.create({ID:\"btnNew_detail$DetailNumber\",title:\"جدید\",  icon: icon_new,click:function(){EnableForm(detailForm$DetailNumber);btnSave_detail$DetailNumber.enable();btnNew_detail$DetailNumber.disable();btnEdit_detail$DetailNumber.disable();btnDelete_detail$DetailNumber.disable();detailForm$DetailNumber.editNewRecord();}});";
	$rtnval.="isc.ToolStripButton.create({ID:\"btnSave_detail$DetailNumber\",title:\"ذخیره\",  icon: icon_Save,disabled:true,click:function(){DisableForm(detailForm$DetailNumber);SaveFormDetail(detailForm$DetailNumber);btnSave_detail$DetailNumber.disable();btnNew_detail$DetailNumber.enable();btnEdit_detail$DetailNumber.enable();btnDelete_detail$DetailNumber.enable();}});";
	$rtnval.="isc.ToolStripButton.create({ID:\"btnEdit_detail$DetailNumber\",title:\"ویرایش\",  icon: icon_Edit,click:function(){EnableForm(detailForm$DetailNumber);btnSave_detail$DetailNumber.enable();btnNew_detail$DetailNumber.disable();btnEdit_detail$DetailNumber.disable();btnDelete_detail$DetailNumber.disable();}});";
	$rtnval.="isc.ToolStripButton.create({ID:\"btnDelete_detail$DetailNumber\",title:\"حذف\",  icon: icon_Delete,click:function(){";
	$rtnval.="ShowDialog(";
	$rtnval.="'اخطار حذف',";
	$rtnval.="'آیا از حذف مورد انتخاب شده اطمینان دارید؟',";
	$rtnval.="'بله',";
	$rtnval.="'خیر',";
	$rtnval.="'DeleteForm',detailForm".$DetailNumber."Name,detailGrid".$DetailNumber."Name";
	$rtnval.="            );	}});";
	$rtnval.="isc.ToolStripButton.create({ID:\"btnCancel_detail$DetailNumber\",title:\"انصراف\",  icon: icon_Cancel,click:function(){DisableForm(detailForm$DetailNumber);btnNew_detail$DetailNumber.enable();btnEdit_detail$DetailNumber.enable();btnSave_detail$DetailNumber.disable();btnDelete_detail$DetailNumber.enable();}});";
	$rtnval.="	isc.ToolStrip.create({	    width: \"100%\",	    height:24,	    ID:\"Toolstripdetail$DetailNumber\",	    members: [btnNew_detail$DetailNumber, \"separator\",";
	$rtnval.="   btnEdit_detail$DetailNumber, \"separator\",";
	$rtnval.="              btnSave_detail$DetailNumber,\"separator\",";
	$rtnval.="            btnDelete_detail$DetailNumber,\"separator\",";
	$rtnval.="        btnCancel_detail$DetailNumber]	});";
	return $rtnval;
	}
	
	public function GetDetailLayout($DetailNumber)
	{
		$rtnval="isc.HLayout.create({";
		$rtnval.="ID:\"detail".$DetailNumber."Frame\",";
		$rtnval.="width: \"100%\",";
		$rtnval.="height: \"100%\",";
		$rtnval.="defaultLayoutAlign: \"right\",";
		$rtnval.=" members: [";
		$rtnval.="isc.VLayout.create({";
		$rtnval.="defaultLayoutAlign: \"right\",";
		$rtnval.="showResizeBar:true,";
		$rtnval.="Height:\"100%\",";
		$rtnval.=" width:\"*\",";
		$rtnval.="	members:[Toolstripdetail$DetailNumber,detailForm$DetailNumber";
		$rtnval.="]}),";
		$rtnval.="isc.VLayout.create({";
		$rtnval.=" width: \"70%\",";
		$rtnval.="members: [detailGrid$DetailNumber ]";
		$rtnval.="	                         })	              ]	  });		";
		return $rtnval;
	}
	public function GetInitDetail($DetailNumber)
	{
		$rtnval="	var detailDs$DetailNumber = eval(detailDs".$DetailNumber."Name);";
		$rtnval.="	var detailForm$DetailNumber= eval(detailForm".$DetailNumber."Name);";
		$rtnval.="	var detailGrid$DetailNumber = eval(detailGrid".$DetailNumber."Name);";
		$rtnval.="	DetailForms[DetailForms.length]=detailForm$DetailNumber;";
		$rtnval.="	DetailGrids[DetailGrids.length]=detailGrid$DetailNumber;";
		$rtnval.="	DetailDss[DetailDss.length]=detailDs$DetailNumber;";
		$rtnval.="	DisableForm(detailForm$DetailNumber);";
		return $rtnval;
	}
	
}
	

