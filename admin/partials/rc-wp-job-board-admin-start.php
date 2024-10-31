<?php
    $plugin_img_path = plugin_dir_url(__DIR__);
?>
<div id="companyid-preview" style="display:none;"  title="Where do I find my Company ID?">
 <div style="padding:10px 75px;">
     <ul style="list-style-type: disc;font-size: 16px;">
         <li>
             If you haven't yet, <a href="https://wordpress.recruitology.com/signup/wp//" target="_blank">set up your free Recruitology account</a> to obtain your Company ID.
         </li>
         <li>
             Once your Recruitology account is activated, check your email to obtain your Company ID, or you can always go to <strong>Products > My Job Board</strong> in the employer portal.
         </li>
     </ul>
     <br/>

     <div style="text-align:center">
         <img src="<?php echo esc_attr($plugin_img_path.'/images/company-id.png');?>" style="max-width:600px;"/>
     </div>
 </div>

</div>

<div id="rc-admin-container">
    <?php
        require_once $this->get_plugin_path() . 'admin/partials/_header.php' ;
    ?>

    <div class="container" >


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box text-center">

                    <h1 class="text-center">Your One-Stop Shop for Recruitment</h1>

                    <p>
                        Connect your Wordpress site with Recruitology to easily add a job board to your site. You can advertise your open positions to the top job destinations, and manage candidates through the hiring process.
                    </p>

                    <br/>

                    <a href="https://wordpress.recruitology.com/signup/wp/" target="_blank" class="btn">Set up your free Recruitology account</a>

                    <br/>&nbsp;

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box">
                    <p>
                        Connect your Wordpress Plugin to your Recruitology Account
                    </p>

                    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                        <input type="hidden" name="action" value="rc_set_company_id" />
                        <input type="text" placeholder="Enter your Recruitoloy Company ID" style="width: 400px;" name="rc_api_key"/>

                        <input type="submit" class="btn btn-outline" value="Connect with Company ID" />
                    </form>
                    <br/>
                    <a href="#" class="modal" data-target="#companyid-preview">Where do I find my Company ID?</a>


                </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($){
        $('.modal').click(function(){

            var target = $(this).attr('data-target');

            $(target).dialog({
                autoResize: true,
                width: 750,
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
