<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo Config::get('cpanel::config.project.title'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>


    <!----------------->
    <!-- CSS Section -->
    <!----------------->
    <?php
    // bootstrap 3.0.2
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/bootstrap.min.css');
    // font Awesome
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/font-awesome.min.css');
    // Ionicons
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/ionicons.min.css');


    // Date Range Picker
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/daterangepicker/daterangepicker-bs3.css');
    // Select2
    echo HTML::style('packages/rabbit/cpanel/asset/plugins/select2/select2.css');
    // Data Table
    echo HTML::style('packages/rabbit/cpanel/asset/plugins/datatable/css/jquery.dataTables.min.css');
    // Date Picker
    echo HTML::style('packages/rabbit/cpanel/asset/plugins/datepicker/css/datepicker.css');


    // Theme style
    echo HTML::style('packages/rabbit/cpanel/asset/lte/css/AdminLTE.css');
    ?>

    @yield('css')

    <!-- Rabbit style -->
    <?php echo HTML::style('packages/rabbit/cpanel/asset/rabbit.css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php echo URL::to('favicon.ico'); ?>"/>

    <!------------------>
    <!-- jQuery 2.0.2 -->
    <!------------------>
    <?php echo HTML::script('packages/rabbit/cpanel/asset/lte/js/jquery-2.1.1.min.js'); ?>

</head>
<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="<?php echo URL::to('/'); ?>" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <?php echo Config::get('cpanel::config.project.logo'); ?>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        @include('cpanel::layout.lte.menu_top')

    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    @include('cpanel::layout.lte.menu_left')

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">
        <!-- Header and Breadcrumb -->
        <section class="content-header">
            <?php
            // Header
            echo PageProperty::getHeader();

            // Breadcrumb
            echo Breadcrumbs::render();
            ?>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Alert Message -->
            <div id="alert" class="alert alert-success alert-dismissable" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <span></span>
            </div>
            <?php echo Notification::showAll(); ?>

            <!-- Toolbar -->
            <?php echo PageProperty::getToolbar(); ?>

            @yield('content')

        </section>
        <!-- /.content -->
    </aside>
    <!-- /.right-side -->
</div>
<!-- ./wrapper -->

<!---------------->
<!-- JS Section -->
<!---------------->
<?php
// Bootstrap
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/bootstrap.min.js');


// Input Mask
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/plugins/input-mask/jquery.inputmask.js');
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/plugins/input-mask/jquery.inputmask.date.extensions.js');
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/plugins/input-mask/jquery.inputmask.numeric.extensions.js');
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/plugins/input-mask/jquery.inputmask.extensions.js');
// Date Picker
echo HTML::script('packages/rabbit/cpanel/asset/plugins/datepicker/js/bootstrap-datepicker.js');
// Date Range Picker
echo HTML::script('packages/rabbit/cpanel/asset/lte/js/plugins/daterangepicker/daterangepicker.js');
// Select2
echo HTML::script('packages/rabbit/cpanel/asset/plugins/select2/select2.min.js');
// Data Table
echo HTML::script('packages/rabbit/cpanel/asset/plugins/datatable/js/jquery.dataTables.min.js');
// Boot Box
echo HTML::script('packages/rabbit/cpanel/asset/plugins/bootbox/bootbox.min.js');
// Block UI
echo HTML::script('packages/rabbit/cpanel/asset/plugins/blockUI/jquery.blockUI.js');
// Query Print
echo HTML::script('packages/rabbit/cpanel/asset/plugins/jQuery.print/jQuery.print.js');

?>

@yield('js')

<!-- AdminLTE App -->
<?php echo HTML::script('packages/rabbit/cpanel/asset/lte/js/AdminLTE/app.js'); ?>

<!-- Rabbit -->
<?php echo HTML::script('packages/rabbit/cpanel/asset/rabbit.js'); ?>
<!-- Boot Box Custom (delete confirm) -->
@include('cpanel::layout._partial.bootbox_confirm')
<!-- Block UI Custom -->
<?php echo HTML::script('packages/rabbit/cpanel/asset/blockUI.js'); ?>


</body>
</html>