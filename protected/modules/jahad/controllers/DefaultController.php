<?php
use IRERP\modules\jahad\models\Matter;
use IRERP\modules\jahad\models;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		\Yii::app()->ir_ClassLoader->nop();
		$b = new Matter();
		$this->render('index');
	}
}