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
    <input type="text" name="roleId" value="<?php echo $data1['payrollId']; ?>">

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
            <th>Dias Faltados</th>
            <th>Otras deducciones</th>
            <th>IHSS</th>
            <th>RAP FIO Piso</th>
            <th>RAP FIO</th>
            <th>ISR</th>
            <th>Total deducciones</th>
            <th>Total Quincena</th>
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

            $commissions = $details['commissions'] ?? '';
            $employeeId = $employees[$i]['employeeId'];
            debug($employees);
            echo "bankName".$bankName;
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
                <td><?php echo $accountNumber; ?></td>
                <td><?php echo $monthlySalary; ?></td>
                <td><?php echo $monthlySalary / 2; ?></td>
                <td><input type="text" value="<?php echo $commissions; ?>" name="employee[<?php echo $i?>][commissions]"<?php echo $commissions; ?>></td>
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

<!--VERIFICAR COMO GUARDAR EL BANCO Y OBTNERLO-->