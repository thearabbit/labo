@extends(Config::get('cpanel::layout_login'))

@section('content')
<div class="form-box" id="login-box">
    <div class="header bg-blue"><?php echo Config::get('cpanel::project.logo'); ?></div>
    <form action="<?php echo URL::route('cpanel.post_login'); ?>" method="post">
        <div class="body bg-gray">
            <p></p>
            <?php
            echo Notification::showAll();

            echo Former::text('username', '')
                ->autocomplete('off')
                ->autofocus()
                ->placeholder('user name')
                ->required();
            echo '<br>';
            echo Former::password('password', '')
                ->placeholder('user password')
                ->required();
            ?>
            <p></p>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-light-blue btn-block">Log In</button>
        </div>
    </form>

    <div class="margin text-center">
        <span><?php echo Config::get('cpanel::config.project.footer'); ?></span>
    </div>
</div>
@stop