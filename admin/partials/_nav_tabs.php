<?php
    $tabs = ['Home', 'My Job Board', 'Customize'];
?>

<div class="row" id="rc-nav">
    <div class="col-md-8 col-md-offset-2" style="padding-bottom:0px;">

        <h2 class="nav-tab-wrapper">
            <?php
                foreach($tabs as $t){

                    $tab_url = str_replace(' ', '_', strtolower($t) );

                    $active = ($this->active_tab == $tab_url) ? 'active' : '';
                    $url = esc_url( admin_url('admin.php') ) . '?page=rc-wp-job-board&tab=' . $tab_url ;
                    $tab = "<a href=\"$url\" class=\"nav-tab $active\"> $t </a>";

                    echo $tab;
                }
            ?>
        </h2>

    </div>
</div>
