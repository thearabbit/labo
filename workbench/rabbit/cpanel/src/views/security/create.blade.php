<!DOCTYPE html>
<html>
<head>
    <title>Rabbit Security</title>
    <?php echo HTML::style('packages/rabbit/cpanel/asset/security.css'); ?>
</head>
<body>

<div class="security-width">
    <!--    <h2 style="background-color: #357ebd; color: #ffffff; text-align: center;">-->
    <h2 class="security-header-info">
        Please create security file.
    </h2>
    <table class="security-content">
        <?php
        if (Session::has('msg')) {
            echo '<h3>' . Session::get('msg') . '</h3>';
        }

        echo Form::open(array('url' => URL::route('security'), 'method' => 'post'));

        echo '<tr><td>';
        echo Form::label('User Name: ');
        echo '</td><td>';
        echo Form::text('username');
        echo '</td></tr>';

        echo '<tr><td>';
        echo Form::label('Password: ');
        echo '</td><td>';
        echo Form::password('password');
        echo '</td></tr>';

        echo '<tr><td></td><td>';
        echo Form::submit('Create Security File');
        echo '</td></tr>';

        echo Form::close();
        ?>
    </table>

</div>

</body>
</html>