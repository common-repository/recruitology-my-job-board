
<?php
    function getlink($path, $cid ='', $domain = 'https://wordpress.recruitology.com'){
        $url = $domain.$path;

        $url .= ( $cid != '' ) ? '?company_id='.$cid : '';

        echo esc_url ( $url );
    }

    $company_data = get_option('recruitology_company_data');

    $cid = $company_data['company_id'];

    $plugin_dir =  plugin_dir_url(__DIR__);
?>
<div class="container" >

    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <div id="welcome-banner" style="background: url('<?php echo esc_attr( $plugin_dir .'images/wp_dashboard_img.png'); ?>') no-repeat #FFFBF5;">

                <h2>
                    Welcome to Recruitology’s Wordpress Plug-in
                </h2>

                <p>
                    Easily post jobs and have them appear on your Wordpress company website, free!
                </p>

                <br/>

                <a href="<?php getlink('/ats/employer-jobs/post/distribution', $cid);?>" target="_blank">Post a job now<span class="dashicons dashicons-arrow-right-alt"></span></a>

            </div>

            <br/>&nbsp;<br/>

            <div class="box box-menu" >

                <a href="<?php getlink('/ats/', $cid);?>" target="_blank">
                    <img src="<?php echo esc_attr( $plugin_dir .'images/fa-home.png'); ?>" />
                    <br/>&nbsp;<br/>

                    Dashboard<br/>
                </a>

                <a href="<?php getlink('/ats/employer-jobs/post/distribution', $cid);?>" target="_blank" >
                    <img src="<?php echo esc_attr( $plugin_dir .'images/fa-edit.png'); ?>" />
                    <br/>&nbsp;<br/>
                    Post a Job<br/>&nbsp;
                </a>

                <a href="<?php getlink('/ats/jobs', $cid);?>" target="_blank">
                    <img src="<?php echo esc_attr( $plugin_dir .'images/fa-briefcase.png'); ?>" />
                    <br/>&nbsp;<br/>
                    View Jobs
                </a>


                <a href="<?php getlink('/ats/talent-pools/', $cid);?>" target="_blank">
                    <img src="<?php echo esc_attr( $plugin_dir .'images/fa-users.png'); ?>" />
                    <br/>&nbsp;<br/>

                    View / Manage<br/>Candidates
                </a>


                <a href="<?php getlink('/ats/settings/company-team', $cid);?>" target="_blank">
                    <img src="<?php echo esc_attr( $plugin_dir . 'images/fa-user-edit.png'); ?>" />
                    <br/>&nbsp;<br/>

                    View / Add<br/>Teammates
                </a>

            </div>

            <br/>

            <h2>Active Job Postings</h2>

            <?php
                $jobs_url = 'https://api.recruitology.com/api/company/job-listings/?results_per_page=30&api_key='.$this->rc_api_key;

                $jobs_resp = wp_remote_retrieve_body( wp_remote_get( $jobs_url ) );

                $jobs = json_decode($jobs_resp, 1);

//                print_r($jobs);
            ?>

            <div class="box" id="job-postings">

                <?php if(!$jobs || $jobs['total'] == '0'): ?>
                <?php #if($jobs): ?>

                <div style="padding:10px 20px;text-align:center;">
                    <div style="background:#F1F2F6;min-height:100px;border-radius:4px;display: flex;justify-content: center;align-items: center;">
                        <div>
                            <strong>No job postings yet.</strong>
                            <br/>&nbsp;<br/>
                            <a href="<?php getlink('/ats/employer-jobs/post/distribution', $cid);?>" target="_blank" class="btn btn-default">
                                Post a job to get started
                            </a>
                        </div>
                    </div>

                </div>

                <?php else: ?>
                        <table>
                            <thead>
                                <td>Job Title</td>
                                <td>Location</td>
                                <td>Status</td>
                                <td>Views</td>
                                <td>Candidates</td>
                                <td>&nbsp</td>
                            </thead>

                            <?php
                                $i = 1;
        //                        for ($x = 1; $x <= 4; $x++ ) :
                                foreach( $jobs['results'] as $job ):
                            ?>

                            <?php
                              $hide_class = ( $jobs['total'] > 10 && $i >= 11 ) ? 'hidden' : '';
                            ?>


                                <tr class="<?php echo esc_attr($hide_class);?>">
                                    <td>
                                        <a href="<?php echo esc_url( $job['view_job_url'] );?>" target="_blank">
                                            <?php echo esc_html( $job['job_title'] ); ?>
                                        </a>
                                    </td>
                                    <td> <?php echo  esc_html( $job['location'] ); ?>  </td>

                                    <td> Active </td>
<!--                                    <td> --><?php //echo $job['status']; ?><!-- </td>-->

                                    <td style="text-align:center;"> <?php echo  esc_html( $job['views'] ); ?>  </td>
                                    <td style="text-align:center;">
<!--                                        <a href="--><?php //getlink('/ats/talent-pools/466821/candidates');?><!--" target="_blank" >-->
                                        <a href="<?php echo  esc_url( $job['talent_pool_url'] );?>" target="_blank" >

                                        <?php echo esc_html( $job['candidates'] ); ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?php echo str_replace('edit/', '', esc_url( $job['edit_url'] ));?>"  target="_blank">
                                            View Job Details
                                        </a>
                                    </td>
                                </tr>


                            <?php
                                $i++;
                                endforeach;
                            ?>

                        </table>
                <?php endif; ?>
            </table>
<!--            --><?php //print_r($jobs); ?>
            <?php if( $jobs['total'] > 10 ): ?>
                <div style="padding: 20px 25px;text-align:center; font-weight: bold;">
                    <a href="#" id="show-hide-all">View all jobs</a>
                </div>
            <?php endif; ?>

            </div>

            <br/>

            <div class="row" id="callout-boxes">
                <div class="col-md-6 p0" style="padding-right:15px;">
                    <div class="box">
                        <h3>Preview your job board</h3>
                        <p>
                            Check out your custom, free job board.  It's a free easy way to show jobs on your WordPress website!<br/>&nbsp;<br/>

                            <a href="/jobs" target="_blank">
                                Go to your job board now
                            </a>
                        </p>

                    </div>
                </div>


                <div class="col-md-6 p0" style="padding-left:15px;">
                    <div class="box">
                        <h3>Not getting enough candidates?</h3>
                        <p>Purchase one of our recommended job advertising packages, promoting your job on LinkedIn, ZipRecruiter as well as social sites like Facebook, and Twitter.<br/>&nbsp;<br/>

                            <a href="<?php getlink('/recruitmentproducts');?>" target="_blank">
                                Learn more
                            </a>
                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).ready(function($){

        $('#show-hide-all').click( function(){

            if( $(this).html() == 'View all jobs' ){
                $('table .hidden').show();
                $(this).html('View less');
            } else {
                $('table .hidden').hide();
                $(this).html('View all active jobs');
            }

            return false;
        });
    });

</script>