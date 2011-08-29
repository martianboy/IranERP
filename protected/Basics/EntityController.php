<?php
namespace IRERP\Basics;
use \Yii, \ReflectionClass;

abstract class EntityController extends IRController
{
	public function actionIndex()
	{
		$req = Yii::app()->getRequest();
		$actionParams = $this->getActionParams();
		Yii::trace('Here is ActionIndex','system.web.CController');
		
		$accepts = isset($actionParams['isc_dataFormat']) ? $actionParams['isc_dataFormat'] : 'html';
		
		if ($req->getIsPutRequest())
			$this->UpdateRecord();
		else if ($req->getIsDeleteRequest())
			$this->RemoveRecord();
		else if ($req->getIsPostRequest()) {
			$this->AddRecord();
		}
		else	// Is a GET request
			if ($accepts == 'json')
				$this->fetchResponse();
			else {
				$view_vars = array(
					'dsMaster' => $this->getId(),
				);
				$this->render('index', $view_vars);
			}
	}

	/**
	 * 
	 * Fetch objects from entity repository with SmartClient-sent criteria
	 * @param array $IgnoredProperties
	 * @param \Doctrine\ORM\EntityManager $em
	 */
	protected function fetchResponse($IgnoredProperties = NULL, $em = NULL)
	{
		if ($em == NULL)
			$em = \Yii::app()->doctrine->getEntityManager();
		
		$className = $this->getFullEntityClassname();
		$params = $this->getActionParams();
		$prefix = $this->getActionParam('isc_metaDataPrefix');
		
		$startRow = '0';
		if (isset($params[$prefix.'startRow']))
			$startRow = $params[$prefix.'startRow'];
		
		$endRow = '100';
		if (isset($params[$prefix.'endRow']))
			$endRow = $params[$prefix.'endRow'];
		
		$totalRows = '0';
		
		try {
			if (isset($params['id'])) {
				$id = $params["id"];
				$cls=$em->getRepository($className)
						->find($id);
				RestDataSource::AddResponse(array($cls->GetClassSCPropertiesInArray()));
			}
			else
			{
				//Get sortBy Defines
				$orderBy = array();
				$order = null;
				if (isset($params[$prefix.'sortBy']))
					$order = $params[$prefix.'sortBy'];
					
				$criteria = array();
				if (isset($params[$prefix.'criteria'])) {
					$jsoncriteria = $params['criteria'];
					if (!is_array($jsoncriteria))
						$jsoncriteria = array($jsoncriteria);
					foreach($jsoncriteria as $v) {
						$j = json_decode($v);
						if ($j != null)
							$criteria[]=get_object_vars($j);
					}
				}
				if($order != null) {
					if(!is_array($order))
						$order = array($order);
					
					foreach($order as $fieldname)
						if(substr($fieldname,0,1)=='-')
							$orderBy[substr($fieldname,1,strlen($fieldname)-1)]='DESC';
						else
							$orderBy[$fieldname]='ASC';
				}
		
				$wh = $this->setwhere($criteria);
				$whstr='';
				$whparam =null;
				if (count($criteria)>0){
					$whstr = $wh[0];
					$whparam=$wh[1];
				}
					
				//Get Objects Form Db
				$cls=new ReflectionClass($className);
				$cls = $cls->newInstance();
				$rtn=$cls->fetchObjects($startRow,$endRow,$whstr,$whparam,$orderBy);
				$results=$rtn['results'];
				$totalRows=$rtn['totalRows'];
				
				//Making Result Array
				$resarr = array();
				foreach($results as $item)
					$resarr[]=$item->GetClassSCPropertiesInArray($IgnoredProperties);
				
				$this->SmartClientRespond($resarr, array(
					"startRow"=>$startRow,
					"endRow"=>$endRow,
					"totalRows"=>$totalRows,
				));
				//$this->SmartClientRespond($startRow,$endRow,$totalRows,$resarr);
			}
		} catch(Exception $e) {
			print_r($e);
		}
	}
	
	/**
	 * 
	 * Updates selected record from SmartClient form data
	 * @param \Doctrine\ORM\EntityManager $em
	 */
	protected function UpdateRecord($em=NULL)
	{
		if ($em == NULL)
			$em = \Yii::app()->doctrine->getEntityManager();
		$className = $this->getFullEntityClassname();
		
		try {
			$cls=$em->getRepository($className)
					->find($this->getActionParam('id'));
			$cls->CreateClassFromScUsingMethod(array($this, 'getActionParam'), array("ID"));
			 
			$cls->Save($em);
			$em->flush();
	
			$this->SmartClientRespond($cls->GetClassSCPropertiesInArray());
	
		} catch(Exception $e) {
			$this->SmartClientRespond(array("Name"=>array("errorMessage"=>$e->getMessage())), NULL, '-4');
		}
	}
	
	/**
	 * 
	 * Add form data as a record  
	 * @param \Doctrine\ORM\EntityManager $em
	 * @throws Exception
	 */
	protected function AddRecord($em=NULL)
	{
		$className = $this->getFullEntityClassname();
		$params = $this->getActionParams();
		
		if ($em == NULL)
			$em = Yii::app()->doctrine->getEntityManager();
		
		try{
			$r = new ReflectionClass($className);
			$cls=$r->newInstance();
			$cls->CreateClassFromScUsingMethod(array($this, 'getActionParam'));
			$cls->Save();
			$em->flush();
			$this->SmartClientRespond($cls->GetClassSCPropertiesInArray());
		} catch(Exception $e) {
			throw $e;
			//$this->SmartClientRespond(array("Name"=>array("errorMessage"=>$e->getMessage())), NULL, '-1');
			
		}
	}
	
	/**
	 * 
	 * Removes record by ID
	 * @param \Doctrine\ORM\EntityManager $em
	 */
	protected function RemoveRecord($em = NULL) {
		if ($em == NULL)
			$em = \Yii::app()->doctrine->getEntityManager();
		
		$className = $this->getFullEntityClassname();
		
		try {
			$cls = $em->getRepository($className)
					  ->find($this->getActionParam('id'));
			$cls->setIsDeleted(true);
	
			$cls->Save($em);
			$em->flush();
	
			$this->SmartClientRespond($cls->GetClassSCPropertiesInArray());
	
		} catch(Exception $e) {
			$this->SmartClientRespond(array("Name"=>array("errorMessage"=>$e->getMessage())), NULL, '-2');
		}
	}
	
	protected function SmartClientRespond($data = NULL, $params = NULL, $statusCode = '0')
	{
		$response = array('response' => array('status' => $statusCode));
		if ($params != NULL)
			foreach($params as $key => $param)
				$response['response'][$key] = $param;
		$response['response']['data'] = $data;
		
		$this->ajaxRespondJSON($response);
	}
	
	private function getFullEntityClassname()
	{
		$className = 'IRERP\\modules\\' . $this->getModule()->getId() . '\\' . 'models' . '\\' . str_replace('Controller', '', get_class($this));
		return $className;
	}
	
	private function setwhere($a)
	{
	$change=array(
		'lessThan'=>' < :p',
		'greaterThan'=>' > :p',
		'lessThanOrEqual'=>' <= :p',
		'greaterThanOrEqual'=>' >= :p',
		'betweenInclusive'=>' between :1p and :2p',
		'notEqual'=>' != :p',
		'startsWith'=>' like :p',
		'endsWith'=>' like :p',
		'notStartsWith'=>' not like :p',
		'notEndsWith'=>' not like :p',
		'iContains'=>' like :p',
		'notContains'=>' not like :p',
		'inSet'=>' in :p',
		'notInSet'=>' not in :p',
		'isNull'=>' IS NULL',
		'isNotNull'=>' IS NOT NULL ',
		'exact match'=>' = :p',
		'equals'=>' = :p '
	);
	
	
	$reval=array();
	$ret='';
	$tmp1=0;
	foreach ($a as &$s) 
	{
		$tmp1++;
		switch ($s['operator']){
			case 'startsWith':
			case 'notStartsWith': $tmp=$s['value'].'%'; break;
			case 'endsWith': 
			case 'notEndsWith': $tmp='%'.$s['value']; break;
			case 'iContains': 
			case 'notContains': $tmp='%'.$s['value'].'%'; break;
			default: $tmp=$s['value'];break;
		}
		if($s['operator']=='betweenInclusive')
		{
			$reval['1'.$s['fieldName'].$tmp1]=$s['value'][0];
			$reval['2'.$s['fieldName'].$tmp1]=$s['value'][1];
		}
		else 
	  {
			$reval[$s['fieldName'].$tmp1]=$tmp;
			
		}	
		if($tmp1!=1)
		{
	
	
			$ret=$ret.' and tmp.'. $s['fieldName'].str_replace('p',$s['fieldName'].$tmp1,$change[$s['operator']]);
		}
		else
		{
			
			$ret='tmp.'.$s['fieldName'].str_replace('p',$s['fieldName'].$tmp1,$change[$s['operator']]);
		}
	}
	return array($ret,$reval);
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