
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
    public function getPayroll(int $id): array
    {
        $query = "SELECT * FROM payrolls WHERE payrollId =?";
        $request = $this->find($query, [$id]);

        if (empty($request)) {
            return json_encode([
                "status" => "ERROR_PAROLL_NOT_FOUND",
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
            return [];
//            return json_encode([
//                "status" => "ERROR_DETAILS_NOT_FOUND"
//            ]);
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
    public function setPayrollDetail(array $payrolls, int $payrollId): false|string
    {
        $this->beginTransaction();
        //$insertedIds = [];

        // Asegúrate de que existe la clave 'employee' y es un array
        if (!isset($payrolls['employee']) || !is_array($payrolls['employee'])) {
            throw new InvalidArgumentException("The 'employee' key is missing or is not an array.");
        }

        $employeeDetails = $payrolls['employee'];

        try {
            // Elimina detalles anteriores
            $this->deletePayrollDetail($payrollId);

            // Itera sobre los detalles de empleados
            foreach ($employeeDetails as $details) {
                $query = "INSERT INTO payroll_details (payrollId, employeeId, bankName, accountNumber, biweeklyBaseSalary, commissions, bonuses, otherIncome, daysAbsent, otherDeductions, ihss, rapFioPiso, rapFio, isr, notes) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Usa las claves correctas y convierte el salario mensual a salario quincenal
                $setData = array(
                    $payrollId,
                    $details["employeeId"],
                    $details["bankName"],
                    $details["accountNumber"],
                    $details["monthlySalary"] / 2, // Salario mensual convertido a quincenal
                    $details["commissions"],
                    $details["bonuses"],
                    $details["otherIncome"],
                    $details["daysAbsent"],
                    $details["otherDeductions"],
                    $details["ihss"],
                    $details["rapFioPiso"],
                    $details["rapFio"],
                    $details["isr"],
                    $details["notes"]
                );

                $insertedId = $this->save($query, $setData);
                //$insertedIds[] = $insertedId;
            }

            $this->commitTransaction();
            // Retornar JSON de éxito
            return json_encode([
                "status" => "SUCCESS_PAYROLL_UPDATE"
            ]);
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw $e; // Relanzar la excepción original
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

