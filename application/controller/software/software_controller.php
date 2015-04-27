<?php
require_once('../../globals.php');
require APP . 'controller\Base_Controller.php';

class Software_Controller Extends Base_Controller
{
    public function noAction()
    {
        $this->showAllSoftware(0);
    }

	public function showAllSoftware( $start )
	{
		$software_objects = $this->model->showAllSoftware( $start );
		$rows = array();
		foreach( $software_objects as $software )
		{
            $sid                        = isset($software->sid)             ? $software->sid            : "";
            $name                       = isset($software->name)            ? $software->name           : "";
            $last_mdfd_user             = isset($software->last_mdfd_user)  ? $software->last_mdfd_user : "";
            $last_mdfd_tmst             = isset($software->last_mdfd_tmst)  ? $software->last_mdfd_tmst : "";

			$rows[]                     = array( $sid, $name, $last_mdfd_user, $last_mdfd_tmst );
		}
		$this->view->renderSoftware($rows, $start);
	}

    public function Next()
    {
        $start = (int)getParam( 'start' , 0 );
        $prev_displayed = getParam( 'displayed', '10' );
        if ( $prev_displayed == '10' )
        {
            $start += 10; 
        }

        $this->showAllSoftware( $start );
    }

    public function Previous()
    {
        $start = (int)getParam( 'start' , 10 ) - 10;
        if ( $start < 0 ) $start = 0;
        $this->showAllSoftware( $start );
    }
       
    public function New_Software()
    {
        $this->view->renderForm( false );
    }
    
    public function Update()
    {
        $sid = getParam('sid');
        $software = $this->model->getSoftware( $sid );
        $this->view->renderForm( true, $sid, $software->name);
    }
    
    public function Update_Software()
    {
        $this->validateSoftware( true );
    }
    
    public function Add_Software()
    {
        $this->validateSoftware( false );
    }
    
    public function Delete_Software()
    {
        $sid = getParam( 'sid' );
        $this->model->deleteSoftware( $sid );
        $this->startFresh();
    }
    
    public function validateSoftware($isUpdate)
	{
        $sid        = getParam('sid', null);
        $name       = $this->validateInputNotEmpty( getParam('name', null) );

        if ( $isUpdate )
        {
            $result = $this->model->updateSoftware($sid, $name);
        }
        else
        {
            $result = $this->model->addSoftware($name);
        }

        if( $result )
        {
            $this->startFresh();
        }
	}
}
?>
