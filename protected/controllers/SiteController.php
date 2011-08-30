<?php
use \IRERP\models\MenuItem,
	\IRERP\modules\jahad\models\TVRD,
	\IRERP\modules\jahad\models\Matter,
	\IRERP\modules\jahad\models\Title,
	\IRERP\modules\jahad\models\MagazineType,
	\IRERP\modules\jahad\models\Size,
	\IRERP\modules\jahad\models\Year,
	\IRERP\modules\jahad\models\MagNo,
	\IRERP\modules\jahad\models\Auidunce,
	\IRERP\modules\jahad\models\Nationality,
	\IRERP\modules\jahad\models\State,
	\IRERP\modules\jahad\models\Magazine,
	\IRERP\modules\jahad\models\MagazineVersion,
	\IRERP\modules\jahad\models\Human,
	\IRERP\modules\jahad\models\Media,
	\IRERP\modules\jahad\models\Section;

class SiteController extends IRController
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.tpl'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function actionTestDoctrine()
	{
		$em = Yii::app()->doctrine->getEntityManager();
		$f = new \IRERP\Basics\Annotations\scField(array());
	}
	public function actionInstallDB()
	{
		$DBClasses = array(
			'\IRERP\models\BasicNamedClass',
			'\IRERP\models\MenuItem',
			'\IRERP\modules\jahad\models\TVRD',
			'\IRERP\modules\jahad\models\Matter',
			'\IRERP\modules\jahad\models\Title',
			'\IRERP\modules\jahad\models\MagazineType',
			'\IRERP\modules\jahad\models\Size',
			'\IRERP\modules\jahad\models\Year',
			'\IRERP\modules\jahad\models\MagNo',
			'\IRERP\modules\jahad\models\Auidunce',
			'\IRERP\modules\jahad\models\State',
			'\IRERP\modules\jahad\models\Magazine',
			'\IRERP\modules\jahad\models\Human',
			'\IRERP\modules\jahad\models\Media',
			'\IRERP\modules\jahad\models\Section',
		);
		
		$em = Yii::app()->doctrine->getEntityManager();
		$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
			'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
		    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em)
		));
		$tool = new \Doctrine\ORM\Tools\SchemaTool($em);
		$classes=array();
		
		foreach($DBClasses as $class)
			$classes[]=$em->getClassMetadata($class);
		
		print_r($tool->getCreateSchemaSql($classes));
		$tool->updateSchema($classes);
		
		echo 'Everything is OK';
	}
	
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionPhpTest()
	{
		try {
			$json = json_decode('{a : "c"}');
			print_r($json);
			print_r(get_object_vars($json));
		}
		catch(Exception $ex)
		{
			print_r($ex);
			//throw $ex;
		}
	}
}