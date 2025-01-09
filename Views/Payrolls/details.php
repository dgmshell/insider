<!--== #HEADER ==-->
<?php /** @var Payrolls $data */
adminHeader($data); ?>
<!--== #NAV ==-->
<?php adminNav($data); ?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 12px;
        table-layout: auto;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
        text-align: center;
    }
    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    input {
        width: 100px; /* Asegura que el input ocupe todo el espacio disponible en la celda */
        box-sizing: border-box; /* Incluye padding y borde en el ancho total */
    }
</style>

<h1>Planilla Detallada</h1>
<form action="" id="form-data">
    <input type="text" name="payrollId" value="<?php echo $data1['payrollId']; ?>">

    <table>
        <thead>
        <tr>
            <th>No.</th>
            <th>Código Planilla</th>
            <th>Código Quincena</th>
            <th>Código Colaborador</th>
            <th>Nombre</th>
            <th>No. DNI</th>
            <th>Banco</th>
            <th>Cuenta</th>
            <th>Sueldo Mensual</th>
            <th>Sueldo Base Quincenal</th>
            <th>Comisiones</th>
            <th>Bonificaciones</th>
            <th>Otros Ingresos</th>
            <th>Total Ingresos</th>
            <th colspan="2">Dias Faltados</th>
            <th>Otras deducciones</th>
            <th>IHSS</th>
            <th>RAP FIO Piso</th>
            <th>RAP FIO</th>
            <th>ISR</th>
            <th>Total deducciones</th>
            <th>Total Quincena</th>
            <th>Options</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $n=1;
        /** @var Permissions $data1 */
        $employees = $data1['employees'];
        for ($i=0; $i < count($employees); $i++) {
            $details = $employees[$i]['details'];
            $bankName = $details['bankName'] ?? $employees[$i]['bankName'];
            $accountNumber = $details['accountNumber'] ?? $employees[$i]['accountNumber'];
            $monthlySalary = $details['monthlySalary'] ?? $employees[$i]['monthlySalary'];

            $biweeklyBaseSalary = $monthlySalary /2;

            $commissions = $details['commissions'];
            $bonuses = $details['bonuses'];
            $otherIncome = $details['otherIncome'];

            $totalRevenue =  $biweeklyBaseSalary +$commissions +$bonuses +$otherIncome;

            $daysAbsent = $details['daysAbsent'];
            $deductionLostDays = $biweeklyBaseSalary /15*$daysAbsent;
            $otherDeductions = $details['otherDeductions'];
            $ihss = $details['ihss'];
            $rapFioPiso = $details['rapFioPiso'];
            $rapFio = $details['rapFio'];
            $isr = $details['isr'];

            $totalDeductions = $deductionLostDays + $otherDeductions + $ihss + $rapFio + $isr;
            $totalFortnight = $totalRevenue - $totalDeductions;
            $employeeId = $employees[$i]['employeeId'];
            //debug($details);
            //echo "commissions".$details['commissions'];
            ?>
            <tr>
                <td>
                    <?php echo $n; ?>
                    <input type="hidden" name="employee[<?php echo $i; ?>][employeeId]" value="<?php echo $employeeId; ?>">
                </td>
                <td><?php echo $details['codeFortnight']; ?><?php echo $employees[$i]['employeeCode']; ?></td>
                <td><?php echo $details['codeFortnight']; ?></td>
                <td><?php echo $employees[$i]['employeeCode']; ?></td>
                <td><?php echo $employees[$i]['profileNames']; ?></td>
                <td><?php echo $employees[$i]['profileIdentity']; ?></td>
                <td><input type="text" value="<?php echo $bankName; ?>" name="employee[<?php echo $i?>][bankName]"<?php echo $bankName; ?>></td>
                <td><input type="text" value="<?php echo $accountNumber; ?>" name="employee[<?php echo $i?>][accountNumber]"<?php echo $accountNumber; ?>></td>
                <td><input type="text" value="<?php echo $monthlySalary; ?>" name="employee[<?php echo $i?>][monthlySalary]"<?php echo $monthlySalary; ?>></td>
                <td><?php echo $biweeklyBaseSalary; ?></td>
                <td><input type="text" value="<?php echo $commissions; ?>" name="employee[<?php echo $i?>][commissions]"<?php echo $commissions; ?>></td>
                <td><input type="text" value="<?php echo $bonuses; ?>" name="employee[<?php echo $i?>][bonuses]"<?php echo $bonuses; ?>></td>

                <td><input type="text" value="<?php echo $otherIncome; ?>" name="employee[<?php echo $i?>][otherIncome]"<?php echo $otherIncome; ?>></td>
                <td><?php echo $totalRevenue; ?></td>
                <td><input type="text" value="<?php echo $daysAbsent; ?>" name="employee[<?php echo $i?>][daysAbsent]"<?php echo $daysAbsent; ?>></td>
                <td><?php echo $deductionLostDays; ?></td>
                <td><input type="text" value="<?php echo $otherDeductions; ?>" name="employee[<?php echo $i?>][otherDeductions]"<?php echo $otherDeductions; ?>></td>

                <td><input type="text" value="<?php echo $ihss; ?>" name="employee[<?php echo $i?>][ihss]"<?php echo $ihss; ?>></td>
                <td><input type="text" value="<?php echo $rapFioPiso; ?>" name="employee[<?php echo $i?>][rapFioPiso]"<?php echo $rapFioPiso; ?>></td>
                <td><input type="text" value="<?php echo $rapFio; ?>" name="employee[<?php echo $i?>][rapFio]"<?php echo $rapFio; ?>></td>
                <td><input type="text" value="<?php echo $isr; ?>" name="employee[<?php echo $i?>][isr]"<?php echo $isr; ?>></td>
                <td><?php echo $totalDeductions; ?></td>
                <td><?php echo $totalFortnight; ?></td>

            </tr>
            <?php
            $n++;
        }
        ?>
        </tbody>
    </table>
    <button>Save</button>
</form>
<!--== #FOOTER ==-->
<?php adminFooter($data); ?>

<!--CALCULAR TOTAL DEDUCCIONES-->