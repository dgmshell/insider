<!--== #HEADER ==-->
<?php adminHeader($data); ?>
<!--== #NAV ==-->
<?php adminNav($data); ?>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

    </style>
<h1>Lista de Planillas</h1>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Codigo Planilla</th>
        <th>Fechas</th>
        <th>Creado el</th>
        <th>Acción</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Recorrer los datos y generar filas dinámicamente
    foreach ($data1 as $row) {
        ?>
    <tr>
        <td><?php echo $row['payrollId']; ?></td>
        <td><?php echo $row['codeFortnight']; ?></td>
        <td><?php echo $row['startDate']; ?> <?php echo $row['endDate']; ?></td>
        <td><?php echo $row['payrollCreationDate']; ?></td>
        <td><a href="http://localhost/insider/payrolls/details/<?php echo $row['codeFortnight']; ?>">Ver Planilla</a></td>
    </tr>
        <?php
    }
    ?>
    </tbody>
</table>

<!--== #FOOTER ==-->
<?php adminFooter($data); ?>