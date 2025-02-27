<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>

<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>
<?php
/** @var Payrolls $data1 */
$payroll=$data1;

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Overview</h1>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <form action="#" class="form-data" id="create-details" data-destination="payrolls" calling-method="updatePayroll" data-type="">
        <div class="card">

            <div class="card-header">
                <h3 class="card-title">Title</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body scrol-x tree-wrapper">
                    <input type="hidden" name="payrollId" value="<?php echo $payroll['payrollId']; ?>">
                    <table class="table db-table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">Código Planilla</th>
                            <th scope="col">Código Quincena</th>
                            <th scope="col">Código Colaborador</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">No. DNI</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Cuenta</th>
                            <th scope="col">Sueldo Mensual</th>
                            <th scope="col">Sueldo Base Quincenal</th>
                            <th scope="col">Comisiones</th>
                            <th scope="col">Bonificaciones</th>
                            <th scope="col">Otros Ingresos</th>
                            <th scope="col">Total Ingresos</th>
                            <th scope="col" colspan="2">Dias Faltados</th>
                            <th scope="col">Otras deducciones</th>
                            <th scope="col">IHSS</th>
                            <th scope="col">RAP FIO Piso</th>
                            <th scope="col">RAP FIO</th>
                            <th scope="col">ISR</th>
                            <th scope="col">Total deducciones</th>
                            <th scope="col">Total Quincena</th>
                            <th scope="col">Notes</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $n=1;
                        $employees = $payroll['employees'];
                        for ($i=0; $i < count($employees); $i++) {
                            $details = $employees[$i]['details'];
                            $employeeId = $details['employeeId'] ?? $employees[$i]['employeeId'];
                            $bankName = $details['bankName'] ?? $employees[$i]['bankName'];
                            $accountNumber = $details['accountNumber'] ?? $employees[$i]['accountNumber'];
                            $monthlySalary = $details['monthlySalary'] ?? $employees[$i]['monthlySalary'];

                            $biweeklyBaseSalary = $monthlySalary /2;

                            $commissions = $details['commissions'];
                            $bonuses = $details['bonuses'];
                            $otherIncome = $details['otherIncome'];

                            $totalRevenue =  $biweeklyBaseSalary +$commissions +$bonuses +$otherIncome;

                            $daysAbsent = $details['daysAbsent'];
                            $deductionLostDays = round($monthlySalary / 30 * $daysAbsent, 2);
                            $otherDeductions = $details['otherDeductions'];
                            $ihss = $details['ihss'];
                            $rapFioPiso = $details['rapFioPiso'];
                            $rapFio = $details['rapFio'];
                            $isr = $details['isr'];
                            $notes = $details['notes'];
                            $totalDeductions = $deductionLostDays + $otherDeductions + $ihss + $rapFioPiso + $rapFio + $isr;
                            $totalFortnight = $totalRevenue - $totalDeductions;

                            //debug($details);
                            //echo "commissions".$employeeId ;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $n; ?>
                                    <input type="hidden" value="<?php echo $employeeId; ?>" name="employee[<?php echo $i?>][employeeId]">
                                </td>
                                <td><?php echo $details['codeFortnight']; ?><?php echo $employees[$i]['employeeCode']; ?></td>
                                <td><?php echo $details['codeFortnight']; ?></td>
                                <td><?php echo $employees[$i]['employeeCode']; ?></td>
                                <td><?php echo $employees[$i]['profileNames']; ?></td>
                                <td><?php echo $employees[$i]['profileIdentity']; ?></td>
                                <td><input type="text" class="form-control form-control-db" value="<?php echo $bankName; ?>" name="employee[<?php echo $i?>][bankName]"></td>
                                <td><input type="text" class="form-control form-control-db" value="<?php echo $accountNumber; ?>" name="employee[<?php echo $i?>][accountNumber]"></td>
                                <td><input class="monthly-salary form-control form-control-db" type="text" value="<?php echo $monthlySalary; ?>" name="employee[<?php echo $i?>][monthlySalary]"></td>
                                <td><input class="biweekly-base- form-control form-control-db" type="text" value="<?php echo $biweeklyBaseSalary; ?>"></td>
                                <td><input class="commissions form-control form-control-db" type="text" value="<?php echo $commissions; ?>" name="employee[<?php echo $i?>][commissions]"></td>
                                <td><input class="bonuses form-control form-control-db" type="text" value="<?php echo $bonuses; ?>" name="employee[<?php echo $i?>][bonuses]"></td>

                                <td><input class="other-income form-control form-control-db" type="text" value="<?php echo $otherIncome; ?>" name="employee[<?php echo $i?>][otherIncome]"></td>
                                <td><input class="total-revenue form-control form-control-db" type="text" value="<?php echo $totalRevenue; ?>"></td>
                                <td><input class="days-absent form-control form-control-db" type="text" value="<?php echo $daysAbsent; ?>" name="employee[<?php echo $i?>][daysAbsent]"></td>
                                <td><input class="deduction-lost-days form-control form-control-db" type="text" value="<?php echo $deductionLostDays; ?>"></td>
                                <td><input class="other-deductions form-control form-control-db" type="text" value="<?php echo $otherDeductions; ?>" name="employee[<?php echo $i?>][otherDeductions]"></td>

                                <td><input class="ihss form-control form-control-db" type="text" value="<?php echo $ihss; ?>" name="employee[<?php echo $i?>][ihss]"></td>

                                <td><input class="rap-fio-piso form-control form-control-db" type="text" value="<?php echo $rapFioPiso; ?>" name="employee[<?php echo $i?>][rapFioPiso]"></td>
                                <td><input class="rap-fio form-control form-control-db" type="text" value="<?php echo $rapFio; ?>" name="employee[<?php echo $i?>][rapFio]"></td>
                                <td><input class="isr form-control form-control-db" type="text" value="<?php echo $isr; ?>" name="employee[<?php echo $i?>][isr]"></td>
                                <td><input class="total-deductions form-control form-control-db" type="text" value="<?php echo $totalDeductions; ?>"></td>
                                <td><input class="total-fort-night form-control form-control-db" type="text" value="<?php echo $totalFortnight; ?>"></td>
                                <td><input class="notes form-control form-control-db" type="text" value="<?php echo $notes; ?>" name="employee[<?php echo $i?>][notes]"></td>
                            </tr>
                            <?php
                            $n++;
                        }
                        ?>
                        </tbody>

                    </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <div class="buttons-payroll">
                    <button type="submit" id="send-payroll" class="btn btn-success btn-block">Guardar Planilla</button>
                </div>
            </div>

            <!-- /.card-footer-->
        </div>
        </form>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- JS Funtions Payrolls-->
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const elements = {
                baseSalary: row.querySelector('.monthly-salary'),
                commissions: row.querySelector('.commissions'),
                bonuses: row.querySelector('.bonuses'),
                otherIncome: row.querySelector('.other-income'),
                totalRevenue: row.querySelector('.total-revenue'),
                daysAbsent: row.querySelector('.days-absent'),
                deductionLostDays: row.querySelector('.deduction-lost-days'),
                otherDeductions: row.querySelector('.other-deductions'),
                ihss: row.querySelector('.ihss'),
                rapFioPiso: row.querySelector('.rap-fio-piso'),
                rapFio: row.querySelector('.rap-fio'),
                isr: row.querySelector('.isr'),
                totalDeductions: row.querySelector('.total-deductions'),
                totalFortNight: row.querySelector('.total-fort-night'),
            };

            const getBaseSalary = () => parseFloat(elements.baseSalary.value) || 0;

            const recalculateTotal = () => {
                const commissionValue = parseFloat(elements.commissions.value) || 0;
                const bonusValue = parseFloat(elements.bonuses.value) || 0;
                const otherIncomeValue = parseFloat(elements.otherIncome.value) || 0;
                elements.totalRevenue.value = (getBaseSalary() / 2 + commissionValue + bonusValue + otherIncomeValue).toFixed(2);
            };

            const recalculateDaysAbsentDeduction = () => {
                const daysAbsentValue = parseFloat(elements.daysAbsent.value) || 0;
                elements.deductionLostDays.value = ((getBaseSalary() / 30) * daysAbsentValue).toFixed(2);
            };

            const recalculateTotalDeductions = () => {
                recalculateDaysAbsentDeduction();

                const deductionLostDaysValue = parseFloat(elements.deductionLostDays.value) || 0;
                const otherDeductionsValue = parseFloat(elements.otherDeductions.value) || 0;
                const ihssValue = parseFloat(elements.ihss.value) || 0;
                const rapFioPisoValue = parseFloat(elements.rapFioPiso.value) || 0;
                const rapFioValue = parseFloat(elements.rapFio.value) || 0;
                const isrValue = parseFloat(elements.isr.value) || 0;

                elements.totalDeductions.value = (
                    deductionLostDaysValue +
                    otherDeductionsValue +
                    ihssValue +
                    rapFioPisoValue +
                    rapFioValue +
                    isrValue
                ).toFixed(2);
            };

            const recalculateAll = () => {
                recalculateTotal();
                recalculateTotalDeductions();

                const totalRevenueValue = parseFloat(elements.totalRevenue.value) || 0;
                const totalDeductionsValue = parseFloat(elements.totalDeductions.value) || 0;

                elements.totalFortNight.value = (totalRevenueValue - totalDeductionsValue).toFixed(2);
            };

            // Agregar eventos a los campos relevantes
            const inputsToWatch = [
                elements.commissions,
                elements.bonuses,
                elements.otherIncome,
                elements.daysAbsent,
                elements.otherDeductions,
                elements.ihss,
                elements.rapFioPiso,
                elements.rapFio,
                elements.isr,
            ];

            inputsToWatch.forEach(input => input.addEventListener('input', recalculateAll));
        });
    });

</script>

<script>
    /*
    const payrollId = <?= json_encode($data["payrollId"]) ?>;
    const form = document.getElementById('create-details');

    // Escuchar el evento de envío del formulario
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevenir el envío por defecto del formulario

        // Capturar los datos del formulario en este punto
        const formData = new FormData(form);
        const obj = Object.fromEntries(formData.entries());

        fetch('http://localhost/insider/payrolls/setDetails/' + payrollId, {
            method: 'POST', // Método de envío
            body: formData, // Datos del formulario
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Procesar la respuesta como JSON
            })
            .then((data) => {
                console.log('Success:', data);
                // Opcional: Puedes mostrar un mensaje de éxito en la interfaz
            })
            .catch((error) => {
                console.error('Error:', error);
                // Opcional: Mostrar un mensaje de error en la interfaz
            });
    });
*/
</script>
