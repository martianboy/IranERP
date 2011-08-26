<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/main';
	/**
	 * context menu items. This property will be assigned to {@link CMenu::items}.
	 * @var array
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public function __construct($id,$m=NULL)
	{
	parent::__construct($id,$m);
	Yii::app()->ir_ClassLoader->nop();
	}
	
	public $baseUrl = '';
	/**
	 * 
	 * Static resources for all controllers.
	 * @var array
	 */
	public $globalResources = array();
	
	protected $actionParams = array();
	
	protected function getIsGetRequest()
	{
		$req = Yii::app()->getRequest();
		return !($req->getIsDeleteRequest() || $req->getIsPostRequest() || $req->getIsPutRequest());
	}
	
	public function getActionParam($paramName)
	{
		$req = Yii::app()->getRequest();
		if ($req->getIsPutRequest())
			return $req->getPut($paramName, NULL);
		else
		{
			if (count($this->actionParams) == 0)
				$this->actionParams = $this->getActionParams();
			
			if (isset($this->actionParams[$paramName]))
				return $this->actionParams[$paramName];
			else
				return NULL;
		}
	}
	public function getActionParams()
	{
		$req = Yii::app()->getRequest();
		
		if ($req->getIsPostRequest() || $req->getIsDeleteRequest())
			return $_REQUEST;
		if ($this->getIsGetRequest()) {
			$queryString = $req->getQueryString();
			
			// FIXME check for other possible errors 
			if ($queryString !== '') {
				$reqParams = explode('&', $queryString);
				
				$actionParams = array();
				foreach($reqParams as $param)
				{
					list($paramName, $paramValue) = explode('=',$param);
					if(array_key_exists($paramName, $actionParams)) {
						$temp = $actionParams[$paramName];
						if (!is_array($temp))
							$actionParams[$paramName] = array(0 => $temp);
						$actionParams[$paramName][] = urldecode($paramValue);
					}
					else
						$actionParams[$paramName] = urldecode($paramValue);
				}
				return $actionParams;
			}
			else
				return $_GET;
		}
		
		return NULL;
	}
	
	public function beforeRender($view)
	{
		$this->baseUrl ='http://localhost/iryii/index.php';// Yii::app()->baseUrl;
		$res = MainLayoutHelpers::GetSmartClientJs();
		$this->globalResources = array_merge($this->globalResources, $res);
		
		return parent::beforeRender($view);
	}
}