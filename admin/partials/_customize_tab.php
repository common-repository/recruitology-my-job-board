<?php
    add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
    function mw_enqueue_color_picker( $hook_suffix ) {
        wp_enqueue_style( 'wp-color-picker' );
    }

    wp_enqueue_style( 'wp-color-picker');
    wp_enqueue_script( 'wp-color-picker');

    wp_enqueue_script('rc-wp-admin', plugin_dir_url(__DIR__) . 'js/rc-wp-job-board-admin.js');
?>

<?php
    $rc_css = get_option('recruitology_custom_settings');
?>

<style id="rc-widget-styles">

</style>

<div class="container" id="customize-tab">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 white-bg">

            <h2>Customize</h2>

            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" id="rc-customize">
                <table>
                    <tr>
                        <td style="width: 200px;">Show Border</td>
                        <td>

                            <?php
                                $border_checked = 'checked';

                                if(  isset($rc_css['show-border']) && $rc_css['show-border'] == false ){
                                    $border_checked = '';
                                }
                            ?>

                            <input type="checkbox" value="true" class="rc-border" name="show-border" <?php echo esc_attr( $border_checked ); ?> />
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Show Logo</td>
                        <td>

                            <?php
                            $logo_checked = 'checked';

                            if(  isset($rc_css['show-logo']) && $rc_css['show-logo'] == false ){
                                $logo_checked = '';
                            }
                            ?>

                            <input type="checkbox" value="true" class="rc-logo" name="show-logo"  <?php echo esc_attr( $logo_checked ); ?>  />
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <hr/>
                        </td>
                    </tr>

                    <tr>
                        <td>Show Header Text</td>
                        <td>

                            <?php
                            $header_text_checked = 'checked';

                            if(  isset($rc_css['show-header-text']) && $rc_css['show-header-text'] == false ){
                                $header_text_checked = '';
                            }
                            ?>

                            <input type="checkbox" value=true class="rc-header-text" name="show-header-text" <?php echo esc_attr( $header_text_checked ); ?>  />
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Title</td>
                        <td>

                            <?php
                                $title_text = ( isset($rc_css['title-text']) ) ? $rc_css['title-text'] : '';
                            ?>
                            <input type="text" value="<?php echo wp_kses( $title_text, [] );?>" class="rc-title-text" name="title-text" />
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Tagline Text</td>
                        <td>

                            <?php
                                $tagline_text = ( isset($rc_css['tagline-text']) ) ? $rc_css['tagline-text'] : '';
                            ?>
                            <input type="text" value="<?php echo wp_kses(  $tagline_text, [] );?>" class="rc-tagline-text" name="tagline-text"/>
                        </td>
                        <td></td>
                    </tr>


    <!--                <tr>
                        <td>Font Size</td>
                        <td>
                            <input type="number" value="16" class="border"  />
                        </td>
                        <td></td>
                    </tr>
    -->

                    <tr>
                        <td colspan="3">
                            <hr/>
                        </td>
                    </tr>

                    <tr>
                        <td>Primary Color</td>
                        <td>

                            <?php
                                $primary_color = ( isset($rc_css['primary-color']) ) ? $rc_css['primary-color'] : '#427eb4';
                            ?>
                            <input type="text" class="color-picker rc-primary-color" value="<?php echo esc_attr($primary_color); ?>" data-default-color="#427eb4" name="primary-color" />
                        </td>
                        <td></td>
                    </tr>


                    <tr class="alt-color-row">
                        <td>Alt Row Color</td>
                        <td>

                            <?php
                                $alt_color = ( isset($rc_css['alt-row-color']) ) ? $rc_css['alt-row-color'] : '';
                            ?>
                            <input type="text" class="color-picker rc-alt-row-color" value="<?php echo esc_attr($alt_color); ?>" data-default-color="#effeff" name="alt-row-color" />
                        </td>
                        <td></td>
                    </tr>

                </table>
                <br/>
                <input type="hidden" name="action" value="customize_css" />
                <input type="submit" class="" value="Save" style="margin-left:20px;">
            </form>

            <br/>

        </div>
    </div>



</div>


<br/>
<div class="container" id="customize-tab">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 white-bg">
            <strong>Preview: </strong>
            <select id="select-widget-preview" style="margin-left:15px;">
                <option value="simple">Job Listings</option>
                <option value="job-search">Job Search</option>
                <!--                                <option value="advanced">Advanced</option>-->
            </select>
        </div>
    </div>
</div>




<script>
    jQuery(document).ready(function($){


        $('#select-widget-preview').change( function(){
            $('.widget-preview').hide();

            var active_widget = $(this).val();

            $('#'+active_widget+'-widget-preview').show();
        })

        function updateCss(){

            var styles = '';

            if ( $('#rc-customize .rc-border').is(":checked") ) {
                styles += ".job-listings-outer-container{   }";
            } else {
                styles += ".job-listings-outer-container{  border: none !important; }";
            }


            if ( $('#rc-customize .rc-logo').is(":checked") ) {
                styles += "#header_logo{   }";
            } else {
                styles += "#header_logo{  display: none !important; }";
            }



            if ( $('#rc-customize .rc-logo').is(":checked") ) {
                styles += "#header_logo{   }";
            } else {
                styles += "#header_logo{  display: none !important; }";
            }


            if ( $('#rc-customize .rc-header-text').is(":checked") ) {
                styles += ".job-listings-header-container{   }";
            } else {
                styles += ".job-listings-header-container{  display: none !important; }";
            }



            var primary_color = $('.rc-primary-color').val();
            styles += ".recruitology-widget th,.recruitology-widget a{ color: " + primary_color + " !important; }";
            styles += ".recruitology-widget button{ background-color: " + primary_color + " !important; border-color: " + primary_color + " !important; }";


            var alt_row_color = $('.rc-alt-row-color').val();
            styles += ".recruitology-widget table tr:nth-child(even){ background-color: " + alt_row_color + " !important; }";


            $('#rc-widget-styles').html(styles);


            $('.job-listings-headline strong').html( $('.rc-title-text').val()  );
            $('.job-listings-tagline').html( $('.rc-tagline-text').val() );
        }

        $('.color-picker').wpColorPicker({
            change: function(event, ui) {
                setTimeout( updateCss , 1000);
            }
        });

        $('.rc-border, .rc-logo, .rc-header-text').change(function(){
            updateCss();
        })

        $('.rc-title-text').keyup( function(){
            $('.job-listings-headline strong').html( $(this).val() );
        });

        $('.rc-tagline-text').keyup( function(){
            $('.job-listings-tagline').html( $(this).val() );
        });

        <?php if( !$rc_css ): ?>

            $('.rc-title-text').val( $('.job-listings-headline strong').html() );
            $('.rc-tagline-text').val( $('.job-listings-tagline').html() );

        <?php endif; ?>

        updateCss();
    });
</script>
