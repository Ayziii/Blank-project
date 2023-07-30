<?php
/*
Plugin Name: IP Redirect Plugin
Description: Redirects users with IP addresses starting with 77.29 away from the site.
*/

function ip_redirect() {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if the IP address starts with "77.29"
    if (strpos($user_ip, '77.29') === 0) {
        // Redirect the user away from the site
        wp_redirect('https://abc.com/redirected-away-page/');
        exit;
    }
}
add_action('template_redirect', 'ip_redirect');
