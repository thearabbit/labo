<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Laboratory System - Help Docs</title>

    <?php
    // bootstrap 3.0.2
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/bootstrap.min.css');
    // font Awesome
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/font-awesome.min.css');
    // custom docs
    echo HTML::style('packages/rabbit/cpanel/asset/doc/simple-sidebar.css');
    ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Laboratory Documentation
                </a>
            </li>
            <li class="menu-header">
                <a href="<?php echo URL::route('doc.introduction'); ?>">Introduction</a>
            </li>
            <li>
                <span class="menu-header">Manage Data</span>
                <a href="#"><i class="fa fa-angle-double-right"></i> Company</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> User</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Backup</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Restore</a>

            </li>
            <li>
                <span class="menu-header">Reports</span>
                <a href="<?php echo URL::route('doc.company'); ?>"><i class="fa fa-angle-double-right"></i> Company</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> User</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Backup</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Restore</a>

            </li>
            <li>
                <span class="menu-header">Settings</span>
                <a href="#"><i class="fa fa-angle-double-right"></i> Company</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> User</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Backup</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Restore</a>

            </li>
            <li>
                <span class="menu-header">Tools</span>
                <a href="#"><i class="fa fa-angle-double-right"></i> Company</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> User</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Backup</a>
                <a href="#"><i class="fa fa-angle-double-right"></i> Restore</a>

            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars"></i></a>
                    <a href="<?php echo URL::to('/'); ?>" class="btn btn-default" target="_blank">Laboratory System</a>

                    {{ $content }}

                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php

// jQuery 2.0.2
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/jquery-2.1.1.min.js');
// Bootstrap Core JavaScript
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/bootstrap.min.js');

?>

<!-- Menu Toggle Script -->
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>
