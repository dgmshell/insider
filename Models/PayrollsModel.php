
<?php
/**
 *
 */
class PayrollsModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getPayrolls(): array
    {
        $query = "SELECT * FROM payrolls";
        $request = $this->findAll($query, []);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_PAROLLS_NOT_FOUND",
                "message" => "No hay planillas para mostrar."
            ]);
        }


        return $request;
    }

    /**
     * @throws Exception
     */
    public function getPayrollDetails($id): array
    {
        $query = "SELECT * FROM payrolls WHERE payrollId =?";
        $request = $this->find($query, [$id]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_PAROLLS_NOT_FOUND"
            ]);
        }
        return $request;
    }

    /**
     * @throws Exception
     */
    public function getEmployees(): false|array|string
    {
        $query = "SELECT 
            employees.employeeCode,
            employees.monthlySalary,
            employees.bankName,
            employees.accountNumber,
            profiles.profileNames,
            profiles.profileSurnames,
            profiles.profileIdentity
                FROM employees
                INNER JOIN profiles ON employees.profileId = profiles.profileId";
        $request = $this->findAll($query, []);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_EMPLOYEES_NOT_FOUND"
            ]);
        }
        return $request;
    }
}

