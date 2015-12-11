<?php


function sssoon_front_view()
{

//require_once ('sssoon-front-view.php' );
    $content = get_option('sssoon_options');
    $settings = get_option('sssoon_design_options');
    $general = get_option('sssoon_options_settings'); ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <title><?php echo get_bloginfo('name'); ?> - <?php echo $content['title']; ?></title>

        <link rel="stylesheet" href="<?php echo plugins_url('inc/css/coming-sssoon.css', dirname(__FILE__)); ?>">
        <link rel="stylesheet" href="<?php echo plugins_url('inc/css/bootstrap.css', dirname(__FILE__)); ?>">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
        <?php
        $background = get_option('sssoon_design_options');
        if ($background['bg'] == 'color') {
            echo '<style>';
            echo 'html{';
            echo 'background:' . $background['customcolor']; //xss okay
            echo '}';
            echo '</style>';
        }

        if ($background['bg'] == 'image') {
            echo '<style>';
            echo 'html{';
            echo 'background:url(' . $background['bgimg'] . ')   no-repeat;';
            echo 'height:100%;';
            echo '}';
            echo '</style>';
        }


        ?>


    </head>
    <body>

    <div id="outercont" class="clearfix">
        <div id="innercont" class="clearfix">

            <div id="content" class="bodycontainer clearfix">

                <h1>  <?php echo $content['heading']; ?> </h1>


                <div class="clearfix"></div>

                <!--
                <div id="countdowncont" class="clearfix">
                    <ul id="countscript">
                        <li>
                            <span class="days">00</span>
                            <p>Days</p>
                        </li>
                        <li>
                            <span class="hours">00</span>
                            <p>Hours</p>
                        </li>
                        <li class="clearbox">
                            <span class="minutes">00</span>
                            <p>Minutes</p>
                        </li>
                        <li>
                            <span class="seconds">00</span>
                            <p>Seconds</p>
                        </li>
                    </ul>
                </div> -->

                <?php echo $content['abouttext']; ?>


                <?php if (!empty($settings['social'])) {
                ?>
                <div id="socialmedia" class="clearfix">
                    <div class="clearfix"></div>
                    <ul>
                        <li><a title="" href="<?php _e($settings['fb']) ?>" rel="external"><span
                                    class="fa fa-facebook"></span></a></li>
                        <li><a title="" href="<?php _e($settings['tw']) ?>" rel="external"><span
                                    class="fa fa-twitter"></span></a></li>
                        <li><a title="" href="<?php _e($settings['gplus']) ?>" rel="external"><span
                                    class="fa fa-google-plus"></span></a></li>
                        <li><a title="" href="<?php _e($settings['link']) ?>" rel="external"><span
                                    class="fa fa-linkedin"></span></a></li>
                        <li><a title="" href="<?php _e($settings['in']) ?>" rel="external"><span
                                    class="fa fa-instagram"></span></a></li>
                    </ul>

                    <?php
                    } else {
                        // Not checked
                    }
                    ?>


                </div>


                <?php if (!empty($general['credits'])) {
                    ?>
                    <div id="copyright" class="bodycontainer">

                        <p>Made with <i class="fa fa-heart"></i> &nbsp;By <a title="PhotonTechnologies"
                                                                             href="http://www.photontechs.com"
                                                                             rel="external">Photon Technologies</a></p>

                    </div>
                <?php }

                ?>
            </div>
        </div>

        <?php wp_footer(); ?>

        <script src="<?php echo plugins_url('inc/js/scripts.js', dirname(__FILE__)); ?>"></script>


    </body>
    </html>


<?php }

?>