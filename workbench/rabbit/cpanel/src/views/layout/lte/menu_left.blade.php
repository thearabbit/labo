<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- search form -->
        <form action="" method="post" class="sidebar-form" role="form" style="text-align: center;">
            <?php echo CpanelWidget::currentDate(); ?>
        </form>

        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <?php
            // Don't have tree
            $tmpMenuLink = '<li>
                                <a href=":url" target=":target">
                                    <i class="fa fa-:icon"></i>
                                    <span>:title</span>
                                </a>
                            </li>';
            // Have tree
            $tmpMenuNoLink = '<a href="#">
                                    <i class="fa fa-:icon"></i>
                                    <span>:title</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>';
            $tmpTree = '<a href=":url" target=":target">
                            <i class="fa fa-angle-double-right"></i>
                             :title
                        </a>';
            $data = '';

            $menus = Config::get('cpanel::menu');
            foreach ($menus as $key => $val) {
                $getIcon = array_get($menus, $key . '.icon');
                $getUrl = array_get($menus, $key . '.url');
                $getTree = array_get($menus, $key . '.tree');
                if (is_null($getTree) or empty($getTree)) {
                    // Don't have tree
                    $getTarget = '_self';
                    $tmpGetTarget = array_get($menus, $key . '.target');
                    if(!is_null($tmpGetTarget) or !empty($tmpGetTarget)){
                        $getTarget = $tmpGetTarget;
                    }

                    $data .= str_replace(
                        array(':url', ':icon', ':title', ':target'),
                        array($getUrl, $getIcon, $key, $getTarget),
                        $tmpMenuLink
                    );
                } else {
                    // Have tree
                    $data .= '<li class="treeview">';
                    $data .= str_replace(array(':icon', ':title'), array($getIcon, $key), $tmpMenuNoLink);

                    // Get tree
                    $data .= '<ul class="treeview-menu">';
                    $getTargetTree = '_self';
                    foreach ($getTree as $keyTree => $valTree) {
                        $getUrlTree = array_get($getTree, $keyTree . '.url');
                        $tmpGetTargetTree = array_get($getTree, $keyTree . '.target');
                        if (!is_null($tmpGetTargetTree) or !empty($tmpGetTargetTree)) {
                            $getTargetTree = $tmpGetTargetTree;
                        }
                        $data .= '<li>';
                        $data .= str_replace(
                            array(':url', ':title', ':target'),
                            array($getUrlTree, $keyTree, $getTargetTree),
                            $tmpTree
                        );
                        $data .= '</li>';
                    }
                    $data .= '</ul>';

                    $data .= '</li>';
                }
            }

            echo $data;

            ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>