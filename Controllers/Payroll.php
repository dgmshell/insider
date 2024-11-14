<?php
class Payroll extends Controllers
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
    public function payroll(): void
    {
        $data["pageName"]     = "payroll";

//        debug($_SESSION['permissionsModule']);
//        debug($_SESSION['permissions']);
        $this->views->getViews($this, 'payroll', $data);
    }
}