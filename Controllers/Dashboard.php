<?php
class Dashboard extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        session_start();
        getPermissions(MD_USERS);
    }

    /**
     * @throws Exception
     */
    public function dashboard(): void
    {
        $data["pageName"]     = "dashboard";


        $this->views->getViews($this, 'dashboard', $data);
    }
}