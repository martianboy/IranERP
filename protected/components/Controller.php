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
	
	public $baseUrl = '';
	/**
	 * 
	 * Static resources for all controllers.
	 * @var array
	 */
	public $globalResources = array();
	
	public function getActionParams()
	{
		$queryString = Yii::app()->getRequest()->getQueryString();
		if ($queryString == '') return $_GET;
		
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
	
	public function beforeRender($view)
	{
		$this->baseUrl = Yii::app()->baseUrl;
		$res = MainLayoutHelpers::GetSmartClientJs();
		$this->globalResources = array_merge($this->globalResources, $res);
		
		return parent::beforeRender($view);
	}
}