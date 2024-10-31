<?php
    add_thickbox();
    $plugin_img_path = plugin_dir_url(__DIR__) . '/admin/images/';
?>


<div id="simple-preview" style="display:none;">
    <img src="<?php echo esc_attr($plugin_img_path .'basic_job_listings_module.png');?>" style="width:750px;"/>
</div>

<div id="search-module-preview" style="display:none;">
    <img src="<?php echo esc_attr($plugin_img_path .'simple_job_search_module.png');?>" />
</div>

<div id="jobs-page-preview" style="display:none;">
    <img src="<?php echo esc_attr($plugin_img_path .'$job-board-page-preview.png');?>" style="width:950px;"/>
</div>


<div class="container" id="my-job-board-tab">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 white-bg">

                <h2>Set up Job Listings & Search Modules</h2>

                <p>
                    Easily incorporate your job listings within the Careers section of your website using embedded modules. By placing a short snippet of code on your company’s Careers section, prospective employees can search and view your company’s open positions. Installation instructions.
                </p>

                <br/>

                <table id="modules-table">
                    <thead>
                        <td style="width:190px;">Module Name</td>
                        <td>Description</td>
                        <td style="width:200px;"></td>
                    </thead>

                    <tr>
                        <td>
                            Job Listings Module<br/>

                            <a href="#" class="modal" data-target="#simple-preview">See Example</a>

                        </td>

                        <td>
                            Show all available job listings on your site.
                        </td>

                        <td>
                            Short Code:<br/>
                            <strong>[rc-job-board /]</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Job Search Module<br/>
                            <a href="#" class="modal"  data-target="#search-module-preview">See Example</a>

                        </td>

                        <td>
                            Provides a simple way for job seekers to search and view your open positions.
                        </td>

                        <td>
                            Short Code:<br/>
                            <strong>[rc-job-board-search /]</strong>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            My Job Board Page<br/>
                            <a href="#" class="modal"  data-target="#jobs-page-preview">See Example</a>

                        </td>
                        <td>
                            Creates a jobs page in WordPress. Shows all available job listings on your site.
                        </td>

                        <?php
                            $postId = get_option('recruitology_jobspage_postid');
                        ?>
                        <td>
<!--                            <a href="/wp-admin/post.php?post=--><?php //echo $postId?><!--&action=edit">Edit Page</a>-->
                            <a href="/wp-admin/admin.php?page=rc-wp-job-board&tab=customize">Edit Page</a>
                            |
                            <a href="/jobs" target="_blank">
                            View Page
                            </a>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($){
        $('.modal').click(function(){

            var target = $(this).attr('data-target');

            $(target).dialog({
                autoResize: true,
                width: "auto",
                height: "auto",
                modal: true,
                open: function (event, ui) {
                    $(".ui-widget-overlay").css({
                        opacity: .8,
                        filter: "Alpha(Opacity=100)",
                        backgroundColor: "black"
                    });
                },
            });
        });
    })

</script>
