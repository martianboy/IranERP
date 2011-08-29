<?php echo "<?php\n"; ?>

class DefaultController extends IRController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}
