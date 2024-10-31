<div id="rc-admin-container">
    <?php require_once $this->get_plugin_path() . 'admin/partials/_header.php'; ?>

    <div class="container">

        <?php

            require_once $this->get_plugin_path() . 'admin/partials/_nav_tabs.php';

            if( in_array( $this->active_tab, ['customize', 'my_job_board', 'home']  ) ) {

                $tab_file = '_' . str_replace(' ', '_', strtolower($this->active_tab)) . '_tab.php';

                require_once $this->get_plugin_path() . 'admin/partials/' . $tab_file;
            }

        ?>

    </div>
</div>

<?php if( isset( $_GET['tab'] ) && $_GET['tab'] == 'customize' ): ?>

    <?php
        $widgets = [];
        $widgets['simple'] = $this->getWidgetUrl('simple');
        $widgets['basic'] = $this->getWidgetUrl('basic');
//        $widgets['advanced'] = $this->getWidgetUrl('advanced');

//        echo $widgets['simple'];

        wp_register_script( 'rc-jb-simple', $widgets['simple'] );
        wp_register_script( 'rc-jb-basic', $widgets['basic'] );
//        wp_register_script( 'rc-jb-advanced', $widgets['advanced'] );

        wp_enqueue_script('rc-jb-basic');

        wp_enqueue_script('rc-jb-simple');
//        wp_enqueue_script('rc-jb-advanced');

    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 white-bg">

                <div id="simple-widget-preview" class="widget-preview">

                </div>

                <div id="job-search-widget-preview" class="widget-preview" style="display: none;">

                </div>

                <div id="advanced-widget-preview" class="widget-preview" style="display: none;">

                </div>


            </div>
        </div>
    </div>
<?php endif;

require_once $this->get_plugin_path() . 'admin/partials/_footer.php';
