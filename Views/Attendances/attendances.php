<!-- Admin Header -->
<?php adminHeader($data); ?>
<!-- Admin Nav -->
<?php adminNav($data); ?>

<!-- Admin Sidebar -->
<?php adminSidebar($data); ?>
<!-- Content Wrapper. Contains page content -->
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
                    <div class="container">
                        <label id="switch" class="switch"><input type="checkbox" />    <div></div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-body">
                Start creating your amazing application!
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
<!-- /.content-wrapper -->
<!-- Admin Sidebar -->
<?php adminFooter($data); ?>

    <style>

        /** Switch
         -------------------------------------*/

        .switch input {
            position: absolute;
            opacity: 0;
        }

        /**
         * 1. Adjust this to size
         */

        .switch {
            display: inline-block;
            font-size: 20px; /* 1 */
            height: 1em;
            width: 2em;
            background: #BDB9A6;
            border-radius: 1em;
            cursor: pointer;
        }

        .switch div {
            height: 1em;
            width: 1em;
            border-radius: 1em;
            background: #FFF;
            box-shadow: 0 0.1em 0.3em rgba(0,0,0,0.3);
            -webkit-transition: all 300ms;
            -moz-transition: all 300ms;
            transition: all 300ms;
        }

        .switch input:checked + div {
            -webkit-transform: translate3d(100%, 0, 0);
            -moz-transform: translate3d(100%, 0, 0);
            transform: translate3d(100%, 0, 0);
        }
        .switch-on{
            background-color: #00a87d;
        }
        .switch-off{
            background-color: #df2e1b;
        }
    </style>
<script>
    const bswitch = document.querySelector("#switch");

    bswitch.addEventListener("change", function (e) {
        if (e.target.checked) {
            console.log("Encendido");
            bswitch.classList.remove("switch-off")
            bswitch.classList.add("switch-on")
        } else {
            console.log("Apagado");
            bswitch.classList.remove("switch-on")
            bswitch.classList.add("switch-off")
        }
    });
</script>
