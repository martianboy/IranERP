<?php
use IRERP\modules\jahad\models\Magazine;
use IRERP\modules\jahad\models\Matter;
use IRERP\modules\jahad\models\Nationality;
use \IRERP\models\MenuItem,
	\IRERP\modules\jahad\models\TVRD,
	\IRERP\modules\jahad\models\Matter as mats,
	\IRERP\modules\jahad\models\Title,
	\IRERP\modules\jahad\models\MagazineType,
	\IRERP\modules\jahad\models\Size,
	\IRERP\modules\jahad\models\Year,
	\IRERP\modules\jahad\models\MagNo,
	\IRERP\modules\jahad\models\Auidunce,
	\IRERP\modules\jahad\models\Nationality AS USA,
	\IRERP\modules\jahad\models\State,
	\IRERP\modules\jahad\models\Magazine as cddc,
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
		print_r($_POST);
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
			'\IRERP\Basics\Models\BasicNamedClass',
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
			'\IRERP\modules\jahad\models\MagazineVersion',
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

	public function actionInsertTestData()
	{
		$parentMenuItem = new MenuItem();
		$parentMenuItem->setTitle('منوی پدر');
		$parentMenuItem->setIcon('#');
		$parentMenuItem->setCommand('/');
		$parentMenuItem->Save();
		
		$menuItem1 = new MenuItem();
		$menuItem1->setTitle('سیستم');
		$menuItem1->setIcon('#');
		$menuItem1->setCommand(Yii::app()->baseUrl . '/#');
		$menuItem1->setParent($parentMenuItem);
		$menuItem1->Save();

		$menuItem2 = new MenuItem();
		$menuItem2->setTitle('منوها');
		$menuItem2->setIcon('#');
		$menuItem2->setParent($menuItem1);
		$menuItem2->setCommand(Yii::app()->baseUrl . '/menu');
		$menuItem2->Save();
		
		Yii::app()->doctrine->getEntityManager()->flush();
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
	
	public function actionNatTest()
	{
		for($i=0;$i<1000;$i++){
		$n = new Nationality();
		$n->setName('Nati'.$i);
		$n->setDescription('Nati'.$i);
		$n->Save();
		$n->getEntityManager()->flush();
		echo $i.'<br/>';
		}
	}
	
	public function actionMatTest()
	{
		$m = new Matter();
		$m1 = $m->GetByID(2);
		$m2=$m->GetByID(3);
		$m3=$m->GetByID(4);
		
		$mag= new Magazine();
		$mag = $mag->GetByID(1);
		$mag->AddMatter($m1);
		$mag->AddMatter($m2);
		$mag->Save();
		$mag->getEntityManager()->flush();
		echo count($mag->getMatters());
	}
	public function actionGeMats()
	{
		$m = new Matter();
		$a = new Magazine();
		$em = $m->getEntityManager();
		$qb= $em->createQueryBuilder();
		$qb	->select('tmp1.Name')
    		->from(get_class($a),' tmp')
    		->leftJoin('tmp.mozu','tmp1');
    		
		/*$qb	->select('tmp')
    		->from(get_class($a),' tmp');*/
    		
    	$query = $qb->getQuery();
    	$tp = $query->getDQL();
    	
    		print_r($tp);
    	$tp= $query->execute();
    	print_r($tp);
    		return;
		
		
		/*$q = \Doctrine_Query::create()
    		->select('tmp1')
    		->from(get_class($a).' tmp')
    		->leftJoin('tmp.mozu tmp1');
*/
		$results = $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
		print_r($results);
		/*$qb = $em->createQueryBuilder();
		$qb->add('select', 'tmp')
		   ->add('from', get_class($this).' tmp')
		   ->setFirstResult( $startRow )
		   ->setMaxResults( $endRow-$startRow );

		$tmp=0;
		
		
		print_r($m);
		*/
	}
		
		
		
	
}
