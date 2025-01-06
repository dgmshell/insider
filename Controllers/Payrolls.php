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

    /**
     * @throws Exception
     */
    function create($id) : void {

        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }

        $verifiedId = verifyId('payrolls', 'payrollId', $id);
        if (empty($verifiedId['total']) || $verifiedId['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }


        $data["pageName"]     = "createPayroll";
        $data["payrollId"] = $id;



        $employees = $this->model->getEmployees($id);

        $payroll = $this->model->getPayrollDetails($id);

        if (empty($payroll)) {
            return;
        }

        //debug($employees);
        //debug($payroll);
        $this->views->getViews($this, 'create', $data,$payroll,$employees);
    }
    /**
     * @throws Exception
     */
    public function details($id) : void
    {

        // Verifica si el ID es válido
        if (!validateId($id)) {
            handleError();
            exit();
        }

        $verifiedId = verifyId('payrolls', 'payrollId', $id);
        if (empty($verifiedId['total']) || $verifiedId['total'] == 0) {
            handleError();
            echo "id no encontrado";
            exit();
        }


        $data["pageName"]     = "createPayroll";
        $data["payrollId"] = $id;

        $employees = $this->model->getEmployees($id);

        $detailPayroll = $this->model->detailPayrollId($id);

        $defaultDetail = ['commissions' => 0];
        $data1 = ['payrollId' => $id];
//        if (empty($payroll)) {
//            return;
//        }

        foreach ($employees as &$detail) {
            $detail['details'] = $defaultDetail;

            foreach ($detailPayroll as $employee) {
                //debug($employee);
                if ($employee['employeeId'] === $detail['employeeId']) {
                    $detail['details'] = [
                        'codeFortnight' => $employee['codeFortnight'],
                        'employeeCode' => $detail['employeeCode'],
                        'profileNames' => $detail['profileNames'],
                        'profileIdentity' => $detail['profileIdentity'],
                        'bankName' => $detail['bankName'],
                        'accountNumber' => $detail['accountNumber'],
                        'monthlySalary' => $detail['monthlySalary'],
                        'commissions' => $employee['commissions']
                    ];
                    break;
                }
            }
        }

        $data1['employees'] = $employees;

        $data["userId"] = $id;
        //debug($data1['employees']);




        //debug($employees);
        //debug($payroll);
        $this->views->getViews($this, 'details', $data,$data1);
    }

    public function setDetails($id) : void
    {
        $data["pageName"]     = "setDetails";

        $data = file_get_contents('php://input');
        $json = json_decode($data, true);

        $request =   $this->model->setPayrollDetail($json,$id);

    }
}