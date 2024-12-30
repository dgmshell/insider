<?php
class Payrolls extends Controllers
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
    public function payrolls(): void
    {
        $data["pageName"]     = "payrolls";

//        debug($_SESSION['permissionsModule']);
//        debug($_SESSION['permissions']);
        $payrolls = $this->model->getPayrolls();
        $this->views->getViews($this, 'payrolls', $data,$payrolls);
    }
    function create($id) : void {
        $data["pageName"]     = "createPayroll";
        $data["payrollId"] = $id;
        $employees = $this->model->getEmployees($id);
        $payroll = $this->model->getEmployees($id);
        $details = $this->model->getPayrollDetails($id);

        if (empty($payroll)) {
            return;
        }
        // debug($payroll);
        // debug($details);
        $this->views->getViews($this, 'create', $data,$payroll,$details);
    }
    /**
     * @throws Exception
     */
    public function details($id) : void
    {
        $data["pageName"]     = "details";
        $employees = $this->model->getEmployees($id);
        $payroll = $this->model->getEmployees($id);
        $details = $this->model->getPayrollDetails($id);

        if (empty($payroll)) {
            return;
        }
//        debug($payroll);
//        debug($details);
        $this->views->getViews($this, 'details', $data,$payroll,$details);
    }

    public function setDetails($id) : void
    {
        $data["pageName"]     = "setDetails";

        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        debug($json);
    }
}