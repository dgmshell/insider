<?php
/** @var Users $data1 */
$payrolls=$data1;

?>
<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>

<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
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
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Identity</th>
                        <th scope="col">User Name</th>
                        <th scope="col">User Email</th>
                        <th scope="col">Profile Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($payrolls as $row): ?>
                        <tr>
                            <td><?php echo $row['payrollId']; ?></td>
                            <td scope="row"><?php echo $row['codeFortnight']; ?></td>
                            <td><?php echo $row['startDate']; ?> <?php echo $row['endDate']; ?></td>
                            <td><?php echo $row['payrollCreationDate']; ?></td>
                            <td><a href="http://localhost/insider/payrolls/overview/<?php echo $row['payrollId']; ?>">Crear</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Footer
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>