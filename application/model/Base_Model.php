<?php

class Base_Model
{
	protected $db;

	public function __construct()
	{
		$this->db = DBconnect::getInstance();
        $this->SetUpQueries();
        date_default_timezone_set('America/Chicago');
	}

    public function startTransaction()
    {
        $this->db->beginTransaction();
    }

    public function endTransaction( $succeeded )
    {
        if ( $succeeded )
        {
            $this->db->commit();
        }
        else
        {
            $this->db->rollback();
        }
    }

    public function GetUpdatedTicketTimeByTid( $tid )
    {
        $this->query_GetTicket->execute( array( ':tid' => $tid ) );
        $ticket = $this->query_GetTicket->fetch();

        return $this->GetUpdatedTicketTime( $ticket );
    }

    public function GetUpdatedTicketTime( $ticket )
    {
        $life_cycl_id = $ticket->life_cycl_id;
        $this->query_GetLifeCyclIsTimed->execute( array( ':life_cycl_id' => $life_cycl_id ) );
        $life_cycl = $this->query_GetLifeCyclIsTimed->fetch();

        $last_open_time = $ticket->last_open_time;

        if ( $life_cycl->is_timed && !$ticket->logl_del )
        {
            $last_open_time = $last_open_time + (time() - strtotime($ticket->last_mdfd_tmst))/3600;
        }

        return $last_open_time;
    }

    protected function SetUpQueries()
    {
        $this->sql_GetLifeCyclIsTimed = "
            SELECT
                `is_timed`
            FROM
                `StLfeCyclConf`
            WHERE
                `life_cycl_id` = :life_cycl_id";
        $this->query_GetLifeCyclIsTimed = $this->db->prepare($this->sql_GetLifeCyclIsTimed);

        $this->sql_GetTicket = "
            SELECT
                *
            FROM
                `StTktInst`
            WHERE
                `tid` = :tid";
        $this->query_GetTicket = $this->db->prepare($this->sql_GetTicket);
    }
}

?>