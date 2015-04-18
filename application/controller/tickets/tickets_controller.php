<?php
require_once('../../globals.php');
require APP . 'controller\Base_Controller.php';

class Tickets_Controller Extends Base_Controller
{
    public function noAction()
    {
        $this->showAllTickets( 0 );
    }

	public function showAllTickets( $start )
	{
		$ticket_objects = $this->model->showAllTickets($start);
		$rows = array();
		foreach( $ticket_objects as $ticket )
		{
			$tid			= isset($ticket->tid) ? $ticket->tid : "";
			$title			= isset($ticket->title) ? $ticket->title : "";
			$cname			= isset($ticket->cname) ? $ticket->cname : "";
			$pname			= isset($ticket->pname) ? $ticket->pname : "";
			$lname			= isset($ticket->lname) ? $ticket->lname : "";
			$insrt_tmst		= isset($ticket->insrt_tmst) ? $ticket->insrt_tmst : "";
			$last_mdfd_tmst = isset($ticket->last_mdfd_tmst) ? $ticket->last_mdfd_tmst : "";
			$rows[] = array( $tid, $title, $cname, $pname, $lname, $insrt_tmst, $last_mdfd_tmst );
		}
		$this->view->renderTickets($rows, $start);
	}

    public function Next()
    {
        $start = (int)getParam( 'start' , 0 );
        $prev_displayed = getParam( 'displayed', '10' );
        if ( $prev_displayed == '10' )
        {
            $start += 10; 
        }

        $this->showAllTickets( $start );
    }

    public function Previous()
    {
        $start = (int)getParam( 'start' , 10 ) - 10;
        if ( $start < 0 ) $start = 0;
        $this->showAllTickets( $start );
    }

	public function Add_Ticket()
	{
		$cust_menu = $this->model->getMenu("stprsninst");
		$assign_menu = $this->model->getMenu("stuserinst");
		$categ_menu = $this->model->getMenu("stcatgconf");
		$aff_menu = $this->model->getMenu("stafflvlconf");
		$sev_menu = $this->model->getMenu("stsvrlvlconf");

		$this->view->renderForm($cust_menu, $assign_menu, $categ_menu, $aff_menu, $sev_menu);
	}

	public function validate_input($data)
    {
    	if(!$data)
    	{
    		return "";
    	}
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

	public function validateTicket()
	{
       if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $title = $this->validate_input($_POST["title"]);
            $description = $this->validate_input($_POST["des"]);
            $customer = $this->validate_input($_POST["cust"]);
            $assignee = $this->validate_input($_POST["assignee"]);
            $category = $this->validate_input($_POST["category"]);
            $affLvl = $this->validate_input($_POST["affLvl"]);
            $severity = $this->validate_input($_POST["sev"]);
            $location = $this->validate_input($_POST["location"]);
            $estTime = $this->validate_input($_POST["estHrs"]);
        }

        $result = $this->model->addTicket($title, $description, $customer, $assignee, $category, $affLvl, $severity, $location, $estTime);
        if(!$result)
        {
            renderBody("Error: New ticket insert failed in database");
        }
        else
        {
            ?>
                <script type="text/javascript">
                    window.location.href = 'http://127.0.0.1/application/view/tickets/tickets_index.php';
                </script>
            <?php
        }
	}
}

?>
