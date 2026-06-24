<?php
/**
 * Plugin Name: Emergency Safe Mode Override
 * Description: Instantly disables all standard plugins to break redirect loops.
 */

// 1. Intercept the active plugins list right as WordPress pulls it from the database
add_filter('option_active_plugins', 'emergency_disable_all_plugins', 999);

function emergency_disable_all_plugins($plugins) {
    // Return an empty array so WordPress thinks zero plugins are active
    return array();
}

// 2. Break common redirect loops happening on the template engine
remove_all_actions('template_redirect');

?>
