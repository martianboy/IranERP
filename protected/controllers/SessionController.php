<?php
use \IRERP\Basics;

class SessionController extends \IRController
{
	public function actionIndex()
	{
		$req = Yii::app()->getRequest();
		if ($req->getIsPostRequest())
		{
			$op = $this->getActionParam('op');
			switch ($op) {
				case 'login':
					$this->logUserIn();
					break;

				case 'logout':
					$this->logUserOut();
					break;

				default:
			}
		}
	}
	
	//FIXME: Rewrite this function properly
	private function logUserIn()
	{
		$user = $this->getActionParam('username');
		$pass = $this->getActionParam('password');
		$req = Yii::app()->getRequest();

		if ($this->validateUserCredentials($user, $pass)) {
			$this->setSessionUsername($user);
			$this->redirect(\Yii::app()->baseUrl . '/');
//			Yii::app()->end();
		}
		else
			$this->redirect(\Yii::app()->baseUrl . '/login?error=1');
	}

	//FIXME: Rewrite this function properly
	private function logUserOut()
	{
		$this->setSessionUsername();
		$this->redirect(\Yii::app()->baseUrl . '/login?message=1');
	}
	
	private function validateUserCredentials($user, $pass)
	{
	    if ($user === 'admin' && $pass === 'admin')
	        return true;
	        
	    return false;
	}

	private function setSessionUsername($user)
	{
	    $session = new CHttpSession();
	    $session->open();
	    
		if ($user != '')
			$session['username'] = $user;
		else {
			unset($session['username']);
		}
	}
}
?>
