<?php

add_action('admin_init', 'sssoon_general_options_init');
add_action('admin_init', 'sssoon_content_options_init');
add_action('admin_init', 'sssoon_design_options_init');
add_action('admin_init', 'sssoon_mailing_options_init');
add_action('admin_menu', 'sssoon_admin_add');
add_action('admin_enqueue_scripts', 'sssoon_stylesheet_admin');

function sssoon_general_options_init()
{
    register_setting('sssoon_general', 'sssoon_options_settings', 'sssoon_general_options_validate');

}

function sssoon_content_options_init()
{
    register_setting('sssoon', 'sssoon_options', 'sssoon_content_options_validate');

}

function sssoon_design_options_init()
{
    register_setting('sssoon_design', 'sssoon_design_options', 'sssoon_design_options_validate');

}

function sssoon_mailing_options_init()
{
    register_setting('sssoon_mail_list', 'sssoon_mailing_options', 'sssoon_mailing_options_validate');

}

/**
 * Add stylesheet to the admin page
 */
function sssoon_stylesheet_admin()
{
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');

    wp_enqueue_style('prefix-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('prefix-style', plugins_url('js/scripts-admin.js', __FILE__));
    //  wp_enqueue_script( 'prefix-style', plugins_url('js/jquery.js', __FILE__) );
}

/**
 * Load up the menu page
 */
function sssoon_admin_add()
{
    add_theme_page(__('Sssoon Options', 'soon'), __('Sssoon Coming Soon', 'soon'), 'edit_sssoon_options', 'sssoon_options', '');
}

/**
 * Create arrays for our select and radio options
 */
$select_options = array(
    '0' => array(
        'value' => 'color',
        'label' => __('Background Color', 'soon')
    ),
    '1' => array(
        'value' => 'image',
        'label' => __('Background Image', 'soon')
    )
);

$radio_options = array(
    'enabled' => array(
        'value' => 'enabled',
        'label' => __('Enabled', 'soon')
    ),
    'disabled' => array(
        'value' => 'disabled',
        'label' => __('Disabled', 'soon')
    )
);

/**
 * Create the options page
 */
function sssoon_admin_settings()
{
    global $select_options, $radio_options;

    if (!isset($_REQUEST['settings-updated']))
        $_REQUEST['settings-updated'] = false;

    ?>
    <div class="wrap">

        <h2 class="wpmm-title"><?php _e('Coming Sssoon Page', 'soon'); ?></h2>

        <?php if (false !== $_REQUEST['settings-updated']) : ?>
            <div class="updated fade"><p><strong><?php _e('Options saved', 'sssoon'); ?></strong></p></div>
        <?php endif; ?>

        <div class="nav-tab-wrapper">
            <a class="nav-tab nav-tab-active" href="#general"><?php _e('General Settings', 'sssoon'); ?></a>
            <a class="nav-tab" href="#content"><?php _e('Page Content', 'sssoon'); ?></a>
            <a class="nav-tab" href="#design"><?php _e('Design Page', 'sssoon'); ?></a>
            <a class="nav-tab" href="#maillist"><?php _e('Mail List Options', 'sssoon'); ?></a>
        </div>

        <div class="wpmm-wrapper">
            <div id="content" class="wrapper-cell">
                <div class="tabs-content">
                    <div id="tab-general" class="">
                        <form method="post" id="genralform" action="options.php">
                            <?php settings_fields('sssoon_general'); ?>
                            <?php $options = get_option('sssoon_options_settings'); ?>

                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row"><?php _e('Mode', 'sssoon'); ?></th>
                                    <td>
                                        <fieldset>
                                            <legend class="screen-reader-text">
                                                <span><?php _e('Radio buttons', 'sssoon'); ?></span></legend>
                                            <?php
                                            if (!isset($checked))
                                                $checked = '';
                                            foreach ($radio_options as $option) {
                                                $radio_setting = $options['radioinput'];

                                                if ('' != $radio_setting) {
                                                    if ($options['radioinput'] == $option['value']) {
                                                        $checked = "checked=\"checked\"";
                                                    } else {
                                                        $checked = '';
                                                    }
                                                }
                                                ?>
                                                <label class="description"><input type="radio"
                                                                                  name="sssoon_options_settings[radioinput]"
                                                                                  value="<?php esc_attr_e($option['value']); ?>" <?php echo $checked; ?> /> <?php echo $option['label']; ?>
                                                </label><br/>
                                                <?php
                                            }
                                            ?>
                                        </fieldset>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Footer Credits', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_options_settings[credits]"
                                               name="sssoon_options_settings[credits]" type="checkbox"
                                               value="1" <?php checked('1', $options['credits']); ?> />
                                        <label class="description"
                                               for="sssoon_options_settings[credits]"><?php _e('Include plugin developer link', 'sssoon'); ?></label>
                                    </td>
                                </tr>


                            </table>
                            <p class="submit">
                                <input type="submit" name="sssoon_save" class="button-primary" value="<?php _e('Save Options', 'sssoon'); ?>"/>
                            </p>
                        </form>

                        <?php

                        echo "<img src='" . plugin_dir_url(__FILE__) . "images/loading.gif' class='sssoon_social_load'/>";

                        ?>

                        <script type="text/javascript">

                            jQuery(document).ready(function () {

                                jQuery(".sssoon_social_load").hide();

                                jQuery('#genralform').submit(function (e) {
                                    e.preventDefault();

                                    jQuery(".sssoon_social_load").show();

                                    jQuery(this).ajaxSubmit({


                                        success: function () {

                                            jQuery(".sssoon_social_load").hide();

                                            jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");

                                            jQuery('#saveMessage').append("<p><?php	echo htmlentities(__('Settings Saved Successfully', 'wp'), ENT_QUOTES);	?></p>").show();

                                        },

                                        timeout: 5000,
                                        error: function (data) {
                                            jQuery(".sssoon_social_load").hide();

                                            jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");

                                            jQuery('#saveMessage').append("<p><?php

					echo htmlentities(__('Settings Saved Successfully', 'wp'), ENT_QUOTES);

					?></p>").show();
                                        }
                                    });

                                    setTimeout("jQuery('#saveMessage').hide('slow');", 5000);

                                    return false;

                                });

                            });

                        </script>

                    </div>
                    <div id="tab-content" class="hidden">


                        <form method="post" action="options.php" id="contenttab">
                            <?php settings_fields('sssoon'); ?>
                            <?php $options = get_option('sssoon_options'); ?>

                            <table class="form-table">
                                <?php
                                /**
                                 * A sample text input option
                                 */
                                ?>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Page Title', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_options[title]" class="regular-text" type="text"
                                               name="sssoon_options[title]" value="<?php if ($options['title']) {
                                            esc_attr_e($options['title']);
                                        } else {
                                            esc_attr_e('Coming Sssoon');
                                        }; ?>"/>
                                        <label class="description"
                                               for="sssoon_options[title]"><?php _e('Html Title Tag ', 'sssoon'); ?></label>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><?php _e('Page Heading', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_options[heading]" class="regular-text" type="text"
                                               name="sssoon_options[heading]" value="<?php if ($options['heading']) {
                                            esc_attr_e($options['heading']);
                                        } else {
                                            esc_attr_e('Coming Sssoon');
                                        }; ?>"/>
                                        <label class="description"
                                               for="sssoon_options[heading]"><?php _e('H1 Tag', 'sssoon'); ?></label>
                                    </td>
                                </tr>


                                <?php
                                /**
                                 * A sample textarea option
                                 */
                                ?>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Description', 'sssoon'); ?></th>
                                    <td>

                                        <?php if ($options['abouttext']) {
                                        } else {
                                            $options['abouttext'] = 'Find the best Bootstrap 3 freebies and themes on the web.';
                                        } ?>

                                        <?php wp_editor($options['abouttext'], 'desired_id_of_textarea', $settings = array('textarea_name' => 'sssoon_options[abouttext]')); ?>


                                    </td>
                                </tr>
                            </table>

                            <p class="submit">
                                <input type="submit" name="sssoon_comingsoon_save" class="button-primary"
                                       value="<?php _e('Save Options', 'sssoon'); ?>"/>
                            </p>
                        </form>

                        <?php

                        echo "<img src='" . plugin_dir_url(__FILE__) . "images/loading.gif' class='sssoon_social_load'/>";

                        ?>

                        <script type="text/javascript">

                            jQuery(document).ready(function () {

                                jQuery(".sssoon_social_load").hide();

                                jQuery('#contenttab').submit(function (e) {
                                    e.preventDefault();

                                    jQuery(".sssoon_social_load").show();

                                    jQuery(this).ajaxSubmit({


                                        success: function () {

                                            jQuery(".sssoon_social_load").hide();

                                            jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");

                                            jQuery('#saveMessage').append("<p><?php

					echo htmlentities(__('Settings Saved Successfully', 'wp'), ENT_QUOTES);

					?></p>").show();

                                        },

                                        timeout: 5000,
                                        error: function (data) {
                                            jQuery(".sssoon_social_load").hide();

                                            jQuery('#saveResult').html("<div id='saveMessage' class='successModal'></div>");

                                            jQuery('#saveMessage').append("<p><?php

					echo htmlentities(__('Settings Saved Successfully', 'wp'), ENT_QUOTES);

					?></p>").show();
                                        }
                                    });

                                    setTimeout("jQuery('#saveMessage').hide('slow');", 5000);

                                    return false;

                                });

                            });

                        </script>


                    </div>
                    <div id="tab-design" class="hidden">

                        <form method="post" action="options.php">
                            <?php settings_fields('sssoon_design'); ?>
                            <?php $options = get_option('sssoon_design_options'); ?>

                            <table class="form-table">
                                <?php
                                /**
                                 * A sample select input option
                                 */
                                ?>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Background type', 'sssoon'); ?></th>
                                    <td>

                                        <select name="sssoon_design_options[bg]" id="bg_type">
                                            <?php
                                            $selected = $options['bg'];
                                            $p = '';
                                            $r = '';

                                            foreach ($select_options as $option) {
                                                $label = $option['label'];
                                                if ($selected == $option['value']) // Make default first in list
                                                    $p = "\n\t<option style=\"padding-right: 10px;\" selected='selected' value='" . esc_attr($option['value']) . "'>$label</option>";
                                                else
                                                    $r .= "\n\t<option style=\"padding-right: 10px;\" value='" . esc_attr($option['value']) . "'>$label</option>";
                                            }
                                            echo $p . $r;
                                            ?>
                                        </select>
                                        <label class="description"
                                               for="sssoon_options[bg]"><?php _e(' ', 'sssoon'); ?></label>
                                    </td>
                                </tr>

                                <tr valign="top" id="customcolor">
                                    <th scope="row"><?php _e('Background Color', 'sssoon'); ?></th>
                                    <td>
                                        <input type="text" name="sssoon_design_options[customcolor]"
                                               value="<?php esc_attr_e($options['customcolor']); ?>"
                                               class="color-picker"/>
                                    </td>
                                </tr>
                                <tr valign="top" id="bgimg" style="display:none;">
                                    <th scope="row"><?php _e('Background Image', 'sssoon'); ?></th>
                                    <td>

                                        <input type="text" name="sssoon_design_options[bgimg]"
                                               value="<?php esc_attr_e($options['bgimg']); ?>" id="image_url"
                                               class="regular-text">
                                        <input type="button" name="upload-btn" id="upload-btn" class="button-secondary"
                                               value="Upload Image">

                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><?php _e('Social Media Share', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_design_options[social] allowsocial"
                                               name="sssoon_design_options[social]"
                                               type="checkbox" value="1" <?php checked('1', $options['social']); ?> />
                                        <label class="description"
                                               for="sssoon_design_options[social]"><?php _e('Include Social Media Sharing', 'sssoon'); ?></label>
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Facebook Share', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_design_options[fb]" name="sssoon_design_options[fb]"
                                               type="checkbox" value="1" <?php checked('1', $options['fb']); ?> />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Twitter Share', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_design_options[tw]" name="sssoon_design_options[tw]"
                                               type="checkbox" value="1" <?php checked('1', $options['tw']); ?> />
                                    </td>
                                </tr>
                                <tr valign="top">
                                    <th scope="row"><?php _e('Mail Sharing', 'sssoon'); ?></th>
                                    <td>
                                        <input id="sssoon_design_options[email]" name="sssoon_design_options[email]"
                                               type="checkbox" value="1" <?php checked('1', $options['email']); ?> />
                                    </td>
                                </tr>
                            </table>

                            <p class="submit">
                                <input type="submit" name="sssoon_save" class="button-primary"
                                       value="<?php _e('Save Options', 'sssoon'); ?>"/>
                            </p>
                        </form>


                    </div>
                    <div id="tab-maillist" class="hidden">
                        <form method="post" action="options.php">
                            <?php settings_fields('sssoon_mail_list'); ?>
                            <?php $options = get_option('sssoon_mailing_options'); ?>

                            <table class="form-table">
                                <tr valign="top">
                                    <th scope="row"><?php _e('Enable Mail List Form', 'sssoon'); ?></th>
                                    <td>

                                        <legend class="screen-reader-text">
                                            <span><?php _e('Enable Mail List Form', 'sssoon'); ?></span></legend>
                                        <input id="sssoon_mailing_options[enable]"
                                               name="sssoon_mailing_options[enable]"
                                               type="checkbox" value="1" <?php checked('1', $options['enable']); ?> />
                                        <label class="description"
                                               for="sssoon_mailing_options[enable]"><?php _e('Check to enable the form in front-end', 'sssoon'); ?></label>
                                    </td>
                                </tr>

                                <tr valign="top">
                                    <th scope="row"><?php _e('MailChimp API Key', 'sssoon'); ?></th>
                                    <td>

                                        <legend class="screen-reader-text">
                                            <span><?php _e('MailChimp API Key', 'sssoon'); ?></span></legend>
                                        <input id="sssoon_mailing_options[mailchimp_api]"
                                               name="sssoon_mailing_options[mailchimp_api]"
                                               type="text" value="<?php esc_attr_e($options['mailchimp_api']); ?>" />
                                        <label class="description"
                                               for="sssoon_mailing_options[enable]"><?php _e('Head over to MailChimp to get the API Key', 'sssoon'); ?></label>
                                    </td>
                                </tr>
                        <?php if($options['mailchimp_api']!='' && isset($options['mailchimp_api'])){

                            include_once("MailChimp.php");
                            $MailChimp = new MailChimp($options['mailchimp_api']);
                            $lists = $MailChimp->get('lists');
                            $lists = $lists['lists'];
                            ?>
                                <tr valign="top">
                                    <th scope="row"><?php _e('MailChimp List', 'sssoon'); ?></th>
                                    <td>

                                        <legend class="screen-reader-text">
                                            <span><?php _e('MailChimp List', 'sssoon'); ?></span></legend>
                                        <select name="sssoon_mailing_options[mclist]" id="sssoon_mailing_options[mclist]">
                                            <?php foreach($lists as $mclist){ ?>
                                                <option value="<?php echo $mclist['id']; ?>" <?php echo ($options['mclist']==$mclist['id'] ? 'selected':''); ?>><?php echo $mclist['name']; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label class="description"
                                               for="sssoon_mailing_options[mclist]"><?php _e('These are all the lists you have on MailChimp', 'sssoon'); ?></label>
                                    </td>
                                </tr>
    <?php } ?>


                            </table>

                            <p class="submit">
                                <input type="submit" name="sssoon_save" class="button-primary"
                                       value="<?php _e('Save Options', 'sssoon'); ?>"/>
                            </p>
                        </form>


                    </div>

                </div>
            </div>
        </div>

        <div id="saveResult"></div>
        <div id="sidebar">
            <div class="sidebar_box info_box"> 
                <h4 class="text-center">Design your website with a Premium Bootstrap UI KIT</h4>
                <a href="http://www.creative-tim.com/product/get-shit-done-pro?ref=cswplugin" target="_blank">
                    <img src="<?php echo plugins_url( 'images/adv.jpg', __FILE__ ); ?>" alt="Get Shit Done Kit"/>
                </a>
            </div>
        </div>

    </div>
    <?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */


function sssoon_general_options_validate($input)
{
    global $select_options, $radio_options;
    return $input;
}


function sssoon_content_options_validate($input)
{
    global $select_options, $radio_options;

    // Say our textarea option must be safe text with the allowed tags for pos();
    $input['abouttext'] = $input['abouttext'];

    return $input;
}


function sssoon_design_options_validate($input)
{
    global $select_options, $radio_options;

    //$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );

    return $input;
}

function sssoon_mailing_options_validate($input){
    return $input;
}

// adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/