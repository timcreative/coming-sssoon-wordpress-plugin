<?php

/*
Plugin Name: Coming Sssoon Page
Plugin URI: www.creative-tim.com
Description: Light and easy to use bootstrap based coming soon plugin.
Version: 1.0.
Author: Jacob Ekanem
Copyright: 2015
*/

// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'sssoon_activate');

function sssoon_activate(){
    $sssoon_options = array(
        'title'=>'Comming Sssoon',
        'heading'=>'Comming Sssoon',
        'abouttext'=>'Find the best Bootstrap 3 freebies and themes on the web.'
    );

    $sssoon_design_options = array(
        'bg'=>'image',
        'bgimg'=>plugins_url( 'lib/images/default.jpg', __FILE__ ),
        'fb'=>1,
        'tw'=>1,
        'email'=>1
    );

    $sssoon_options_settings = array(
        'radioinput'=>'enabled',
        'credits'=>1
    );

    $sssoon_mailing_options = array(
        'enable'=>0
    );

    update_option('sssoon_options',$sssoon_options);
    update_option('sssoon_design_options',$sssoon_design_options);
    update_option('sssoon_options_settings',$sssoon_options_settings);
    update_option('sssoon_mailing_options',$sssoon_mailing_options);
}

require_once ('lib/sssoon-options.php' );
require_once ('lib/sssoon-front-view.php' );

add_action('admin_menu','sssoon_menu');
function sssoon_menu() {
    add_menu_page('Sssoon', 'Coming Soon', 'administrator', 'settings-sssoon', 'pluginSettingsPage', 'dashicons-admin-tools');
}

function pluginSettingsPage() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-form');
    sssoon_admin_settings();
}

function sssoon_enable() {

    if(is_admin()){
        return;
    }

    $status = get_option('sssoon_options_settings');
    //$options = get_option('sssoon_options');
    if ($status['radioinput'] === 'disabled'){
        return;
    }

    if (!current_user_can('edit_posts') && !in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ))) {
        $protocol = "HTTP/1.0";
        if ("HTTP/1.1" == $_SERVER["SERVER_PROTOCOL"]) {
            $protocol = "HTTP/1.1";
        }
        header("$protocol 503 Service Unavailable", true, 503);
        header("Retry-After: 3600");
        wp_enqueue_script('jquery');
        sssoon_front_view();

        exit();
    }
}
add_action('init', 'sssoon_enable');

add_action('plugins_loaded', 'sssoon_send_mail');
function sssoon_send_mail()
{
    if (isset($_POST['sssoon_email'])) {
        $email = $_POST['sssoon_email'];
        $message = get_bloginfo('name') . ' (' . get_bloginfo('url') . ') is coming soon. Please keep an eye on this space.';
        $subject = get_bloginfo('name') . ' is coming soon';
        wp_mail($email, $subject, $message);
    }
}

add_action('plugins_loaded', 'mc_nl_mail');
function mc_nl_mail()
{
    if (isset($_POST['nl_mail'])) {
        $email_address = $_POST['nl_mail'];
        include_once("lib/MailChimp.php");
        $mc_api = get_option('sssoon_mailing_options');
        $mc_api_key = $mc_api['mailchimp_api'];

        $mc_list = $mc_api['mclist'];

        $MailChimp = new MailChimp($mc_api_key);

        $MailChimp->post('lists/'.$mc_list.'/members', array(
            'email_address'     => $email_address,
            'status'            => 'subscribed'
        ));
    }
}

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( $hook_suffix ) {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');
    //wp_enqueue_script( 'wp-color-picker-script-handle', plugins_url('wp-color-picker-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
}