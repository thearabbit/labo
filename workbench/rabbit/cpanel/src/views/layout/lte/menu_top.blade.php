<div class="navbar-right">
    <ul class="nav navbar-nav">
        <!-- Notifications: Refresh page (style can be found in dropdown.less) -->
        <li class="dropdown notifications-menu">
            <a href="<?php echo URL::current(); ?>" title="Refresh this page">
                <i class="fa fa-refresh"></i>
            </a>
        </li>
        <!-- Notifications: Open new windows (style can be found in dropdown.less) -->
        <li class="dropdown notifications-menu">
            <a href="<?php echo URL::current(); ?>" title="New tab" target="_blank">
                <i class="fa fa-desktop"></i>
            </a>
        </li>
        <!-- Notifications: Documents (style can be found in dropdown.less) -->
        <li class="dropdown notifications-menu">
            <a href="<?php echo URL::route('doc.introduction'); ?>" title="Documents" target="_blank">
                <i class="fa fa-book"></i>
            </a>
        </li>
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="glyphicon glyphicon-user"></i>
                <span><?php echo Auth::user()->full_name; ?> <i class="caret"></i></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header bg-light-blue">
                    <?php
                    echo HTML::image(
                        'packages/rabbit/cpanel/asset/lte/img/avatar5.png',
                        'User Image',
                        array('class' => 'img-circle')
                    );
                    ?>
                    <p>
                        <?php
                        echo Auth::user()->full_name . ' - ';
                        echo Auth::user()->type;
                        ?>

                    <p>
                        <small><?php echo Config::get('cpanel::config.project.footer'); ?></small>
                    </p>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="<?php echo URL::route('cpanel.profile.edit'); ?>" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo URL::route('cpanel.logout'); ?>" class="btn btn-default btn-flat">Log
                            Out</a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>