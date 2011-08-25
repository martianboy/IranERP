<?php
//Yii::import('application.models.SimpleEntities');

class MatterController extends Controller
{
	public function actionIndex()
	{
		$req = Yii::app()->getRequest();
		$actionParams = $this->getActionParams();
		//print_r($actionParams);
		//echo $req->getQueryString();
		
		$accepts = isset($actionParams['isc_dataFormat']) ? $actionParams['isc_dataFormat'] : 'html';
		
		if ($req->getIsPutRequest())
			CrudResponder::UpdateRecord('Matter');
		else if ($req->getIsDeleteRequest())
			CrudResponder::RemoveRecord('Matter');
		else if ($req->getIsPostRequest()) {
			//print_r($_SERVER);
			CrudResponder::AddRecord('Matter', $actionParams);
		}
		else	// Is a GET request
			if ($accepts == 'json')
				CrudResponder::fetchResponse('Matter', $actionParams);
			else {
				$view_vars = array(
					'dsMaster' => $this->getId(),
				);
				$this->render('index', $view_vars);
			}
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}