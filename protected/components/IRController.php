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
	
}
