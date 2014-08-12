<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <title><?php echo Config::get('cpanel::config.project.title'); ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <?php echo HTML::style('packages/rabbit/cpanel/asset/lte/css/bootstrap.min.css'); ?>
    <!-- font Awesome -->
    <?php echo HTML::style('packages/rabbit/cpanel/asset/lte/css/font-awesome.min.css'); ?>
    <!-- Theme style -->
    <?php echo HTML::style('packages/rabbit/cpanel/asset/lte/css/AdminLTE.css'); ?>

    <!-- Rabbit style -->
    <?php echo HTML::style('packages/rabbit/cpanel/asset/rabbit.css'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php echo URL::to('favicon.ico'); ?>"/>

    <!-- jQuery 2.0.2 -->
    <?php echo HTML::script('packages/rabbit/cpanel/asset/lte/js/jquery-2.1.1.min.js'); ?>

</head>
<body class="bg-black">

@yield('content')

<!-- Bootstrap -->
<?php echo HTML::script('packages/rabbit/cpanel/asset/lte/js/bootstrap.min.js'); ?>

</body>
</html>