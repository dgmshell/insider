
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
    public function getEmployee(): false|array|string
    {
        $query = "SELECT * FROM employees WHERE employeeStatus !=?";
        $request = $this->findAll($query, [0]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_EMPLOYEES_NOT_FOUND"
            ]);
        }
        return $request;
    }
    public function detailPayrollId($id): false|array|string
    {
        $query = "SELECT * 
          FROM payroll_details 
          INNER JOIN payrolls 
          ON payrolls.payrollId = payroll_details.payrollId 
          WHERE payroll_details.payrollId = ?";
        $request = $this->findAll($query, [$id]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_DETAILS_NOT_FOUND"
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
            employees.employeeId,
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
    public function setPayrollDetail(array $payrolls, int $payrollId): array
    {
        $this->beginTransaction();
        $insertedIds = [];

        try {
            $this->deletePayrollDetail($payrollId);
            foreach ($payrolls as $details) {

                $query = "INSERT INTO payroll_details (payrollId, employeeId,biweeklyBaseSalary, commissions, bonuses, otherIncome, totalIncome, daysAbsent, otherDeductions, ihss, rapfiop, rapfio, isr, totalSalary, note) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $setData = array(
                    $payrollId,                  // payrollId: ID de la nómina
                    $details["employeeId"],                    // employeeId: ID del empleado
                    $details["biweeklyBaseSalary"],                // baseSalary: Salario base
                    $details["commissions"],                 // commissions: Comisiones
                    $details["bonuses"],                 // bonuses: Bonificaciones
                    $details["otherIncome"],                 // otherIncome: Otros ingresos
                    $details["totalRevenue"],                // totalIncome: Total de ingresos
                    $details["daysMissed"],                    // daysAbsent: Días ausentes
                    $details["otherDeductions"],                 // otherDeductions: Otras deducciones
                    $details["ihss"],                 // ihss: Deducción de IHSS
                    $details["rapFioPiso"],                 // rapfiop: Deducción RAP FIO Piso
                    $details["rapFio"],                  // rapfio: Deducción RAP FIO
                    $details["isr"],                 // isr: Deducción ISR
                    $details["totalFortnight"],                // totalSalary: Salario total después de deducciones
                    'Ausencias justificadas.' // note: Nota sobre la nómina o permisos
                );


                $insertedId = $this->save($query, $setData);
                $insertedIds[] = $insertedId;
            }

            $this->commitTransaction();
            debug($insertedIds);
            return $insertedIds;
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $this->rollbackTransaction();
            throw $e; // Lanzar la excepción original para conservar el stack trace
        }
    }

    public function deletePayrollDetail(int $payrollId): string
    {
        // Solo inicia una transacción si no hay una activa
        if (!$this->inTransaction()) {
            $this->beginTransaction();
        }

        try {
            // Eliminar los permisos asociados al roleId recibido
            $sql = "DELETE FROM payroll_details WHERE payrollId = ?";
            $this->deleteRecord($sql, [$payrollId]);

            // Confirmar la transacción si no había una activa previamente
            if (!$this->inTransaction()) {
                $this->commitTransaction();
            }

            return 'DATA_DELETE';  // Devuelve un mensaje indicando que se eliminaron los permisos
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            if ($this->inTransaction()) {
                $this->rollbackTransaction();
            }
            throw $e; // Lanzar la excepción original para conservar el stack trace
        }
    }

}

