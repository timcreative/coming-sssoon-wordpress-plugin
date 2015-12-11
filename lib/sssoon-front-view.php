<?php


function sssoon_front_view()
{
    $content = get_option('sssoon_options');
    $mailing_list = get_option('sssoon_mailing_options');
    $general = get_option('sssoon_options_settings'); ?>


    <!DOCTYPE html>
    <html lang="en" itemscope itemtype="http://schema.org/Article">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />

        <title><?php echo get_bloginfo('name'); ?> - <?php echo substr($content['title'],0,50); ?></title>
        <meta name="description" content="<?php echo substr($content['abouttext'], 0, 155); ?>" />

        <link rel="stylesheet" href="<?php echo plugins_url('lib/css/coming-sssoon.css', dirname(__FILE__)); ?>">
        <link rel="stylesheet" href="<?php echo plugins_url('lib/css/bootstrap.css', dirname(__FILE__)); ?>">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
        <?php
        $design_options = get_option('sssoon_design_options');
        echo '<style>';


        if ($design_options['bg'] == 'color'):
            echo '.main{
                    background:' . $design_options['customcolor'] . ';
                 }';
        elseif ($design_options['bg'] == 'image'):
            echo '.main{
                    background:url(' . $design_options['bgimg'] . ') no-repeat;
                  }';
        endif;

        echo '</style>';
        ?>

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo get_bloginfo('name'); ?> - <?php echo $content['title']; ?>">
        <meta itemprop="description" content="<?php echo $content['abouttext']; ?>">
        <meta itemprop="image" content="<?php echo plugins_url( 'default.jpg', __FILE__ ); ?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo $content['title']; ?>">
        <meta name="twitter:description" content="<?php echo substr($content['abouttext'], 0, 200); ?>">
        <meta name="twitter:image:src" content="<?php echo plugins_url( 'default.jpg', __FILE__ ); ?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $content['title']; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo get_bloginfo('url'); ?>" />
        <meta property="og:image" content="<?php echo plugins_url( 'default.jpg', __FILE__ ); ?>" />
        <meta property="og:description" content="<?php echo $content['abouttext']; ?>" />
        <meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>" />

    </head>
    <body>

    <nav class="navbar navbar-transparent navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <?php if ($design_options['social'] == '1'): ?>
                <ul class="nav navbar-nav navbar-right">
                    <?php if ($design_options['fb'] == '1') { ?>
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_bloginfo('url'); ?>" target="_blank">
                            <i class="fa fa-facebook-square"></i>
                            Share
                        </a>
                    </li>
                    <?php } ?>
                    <?php if ($design_options['tw'] == '1') { ?>
                    <li>
                        <a href="https://twitter.com/home?status=<?php echo get_bloginfo('name'); ?>%20is%20coming%20soon.%20Check%20back%20later%20at%20<?php echo get_bloginfo('url'); ?>." target="_blank">
                            <i class="fa fa-twitter"></i>
                            Tweet
                        </a>
                    </li>
                    <?php } ?>

                    <?php if ($design_options['email'] == '1') { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown"
                               href="#">
                                <i class="fa fa-envelope-o"></i>
                                <?php _e('Email','sssoon'); ?>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <form class="sendmailform" method="post" action="">
                                    <input type="email" class="form-control"
                                           placeholder="<?php _e('Send to Email', 'sssoon'); ?>" name="sssoon_email"
                                           id="sssoon_email"/>
                                    <input type="submit" class="btn btn-success btn-fill btn-block" value="Submit"/>
                                </form>
                            </ul>
                        </li>
                    <?php } ?>

                </ul>
                <?php endif; ?>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
    </nav>
    <div class="main" <!--style="background-image: url('images/default.jpg')-->">

        <!--    Change the image source '/images/default.jpg' with your favourite image.     -->

    <?php if ($design_options['bg'] == 'image'): ?>
            <div class="cover black" data-color="black"></div>
        <?php endif; ?>

        <!--   You can change the black color for the filter with those colors: blue, green, red, orange       -->

        <div class="container">
            <h1 class="logo cursive">
                <?php echo $content['heading']; ?>
            </h1>
            <!--  H1 can have 2 designs: "logo" and "logo cursive"           -->

            <div class="content">
                <h4 class="motto"><?php echo $content['abouttext']; ?></h4>

                <?php if($mailing_list['enable']==1): ?>
                <div class="subscribe">
                    <h5 class="info-text">
                        <?php _e('Join the waiting list for the beta. We keep you posted.','sssoon'); ?>
                    </h5>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4 col-sm6-6 col-sm-offset-3 ">
                            <form class="form-inline" role="form" method="post" action="">
                                <div class="form-group">
                                    <label class="sr-only" for="nl_mail"><?php _e('Email address','sssoon'); ?></label>
                                    <input type="email" name="nl_mail" class="form-control transparent" placeholder="<?php _e('Your email here...','sssoon'); ?>">
                                </div>
                                <button type="submit" class="btn btn-danger btn-fill"><?php _e('Notify Me','sssoon'); ?></button>
                            </form>

                        </div>
                    </div>
                </div>
                <?php endif; ?>


            </div>
        </div>
        <div class="footer">
            <div class="container">
                <?php if(!empty($general['credits'])):?>
                Made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>.</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    </body>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
    <script src="<?php echo plugins_url('lib/js/bootstrap.min.js', dirname(__FILE__)); ?>" type="text/javascript"></script>
    </html>
<?php }

?>