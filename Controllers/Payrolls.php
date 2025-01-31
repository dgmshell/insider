<?php
class Payrolls extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        session_start();


        if (!isset($_SESSION['userId']) || !isset($_SESSION['login'])) {

            header('Location:'.router().'auth/login');
            exit();
        }
        getPermissions(MD_PAYROLLS);

    }

    /**
     * @throws Exception
     */
    public function payrolls(): void
    {
//        if (!isset($_SESSION['permissionsModule']['r']) || $_SESSION['permissionsModule']['r'] !== 1) {
//            header('Location:'.router().'dashboard');
//            die();
//        }

        $data["pageName"]     = "payrolls";
         debug($_SESSION['permissionsModule']);
//        debug($_SESSION['permissions']);
            $payrolls = $this->model->getPayrolls();
            echo $_SESSION['userId'];
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
    public function details($id): void
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
        $payroll = $this->model->getPayroll($id);
        $employees = $this->model->getEmployees();

        $detailPayroll = $this->model->detailPayrollId($id);


        $defaultDetail = [
            'codeFortnight' => $payroll['codeFortnight'],
            'commissions' => 0,
            'bonuses' => 0,
            'otherIncome' => 0,
            'daysAbsent' => 0,
            'otherDeductions' => 0,
            'ihss' => 0,
            'rapFioPiso' => 0,
            'rapFio' => 0,
            'isr' => 0,
            'notes' => 0,
        ];

        $data1 = ['payrollId' => $id];
//        if (empty($payroll)) {
//            return;
//        }
        $bankName="";
        //debug($detailPayroll);
        foreach ($employees as &$detail) {
            $detail['details'] = $defaultDetail;

            foreach ($detailPayroll as $employee) {

                    if ($employee['bankName']===""){
                        $bankName =$detail['bankName'];
                    }else{
                        $bankName =$employee['bankName'];
                    }
                if ($employee['accountNumber']===""){
                    $accountNumber =$detail['accountNumber'];
                }else{
                    $accountNumber =$employee['accountNumber'];
                }
                if ($employee['biweeklyBaseSalary']===""){
                    $monthlySalary =$detail['biweeklyBaseSalary'];
                }else{
                    $monthlySalary =$employee['biweeklyBaseSalary']*2;
                }

                if ($employee['employeeId'] === $detail['employeeId']) {
                    $detail['details'] = [
                        'employeeId' => $detail['employeeId'],
                        'codeFortnight' => $employee['codeFortnight'],
                        'employeeCode' => $detail['employeeCode'],
                        'profileNames' => $detail['profileNames'],
                        'profileIdentity' => $detail['profileIdentity'],
                        'bankName' => $bankName,
                        'accountNumber' => $accountNumber,
                        'monthlySalary' => $monthlySalary,
                        'commissions' => $employee['commissions'],
                        'bonuses' => $employee['bonuses'],
                        'otherIncome' => $employee['otherIncome'],
                        'daysAbsent' => $employee['daysAbsent'],
                        'otherDeductions' => $employee['otherDeductions'],
                        'ihss' => $employee['ihss'],
                        'rapFioPiso' => $employee['rapFioPiso'],
                        'rapFio' => $employee['rapFio'],
                        'isr' => $employee['isr'],
                        'notes' => $employee['notes']
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

        $data = $_POST;

        $request =   $this->model->setPayrollDetail($data,$id);

    }
}