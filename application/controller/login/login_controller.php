<?php
require APP . 'controller\Base_Controller.php';

class Login_Controller extends Base_Controller
{
	/**
	* Calls the __construct() method of in the Base_Controller file, passing along the
	* model, view, and globals instantiations, as well as the index.php filename
	*
    * @param $model : Model object (used for authentication to the database)
    * @param $view : View object (used for rendering data and HTML to the webpage)
    * @param $globals : Globals object (provides access to necessary utility functions)
    * @param $index : String (contains the *_index.php filename for the index file that started this controller)
	*/
	public function __construct($model, $view, $globals, $index)
	{
		parent::__construct($model, $view, $globals, $index, false);
	}

	/**
	* Redirects application control to the View's showLogin() method
	*/
	public function noAction()
	{
		$this->view->showLogin();
	}

	/**
	* Authenticates the user-provided username and password against the database and will either
	* redirect the application to the home page or back to the login page if authentication fails
	*/
	public function Log_In()
	{
		$user = $this->globals->getParam('username');
		$pwd = $this->globals->getParam('passwd');
		$pid = $this->model->authenticate($user, $pwd);
		if ( $pid != null )
		{
			$_SESSION['user'] = $user;
			$_SESSION['pid'] = $pid;
			$this->simpleRedirect("../home/home_index.php");
		}
		else
		{
			$this->noAction();
		}
	}
}
?>