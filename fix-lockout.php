
<?php
/**
 * Plugin Name: Emergency Redirect Bypass & Safe Mode
 * Description: Drop this file into your WordPress root directory or mu-plugins to break an infinite redirect loop.
 * Usage: Visit yoursite.com/fix-lockout.php once to trigger it, then delete this file.
 */

// 1. Prevent this script from getting stuck in the theme's redirect loop
define('WP_ADMIN', true);

// 2. Load the core WordPress environment
require_once(__DIR__ . '/wp-load.php');

// 3. Force-disable the common code snippet plugins causing the issue
if (function_exists('deactivate_plugins')) {
    require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    
    // Array of common snippet plugins. Add yours if it's different.
    $plugins_to_deactivate = [
        'code-snippets/code-snippets.php',
        'wpcode-light/wpcode.php',
        'insert-headers-and-footers/ihaf.php'
    ];
    
    foreach ($plugins_to_deactivate as $plugin) {
        if (is_plugin_active($plugin)) {
            deactivate_plugins($plugin);
            echo "Successfully deactivated: " . esc_html($plugin) . "<br>";
        }
    }
}

// 4. Force override and unhook custom template redirects that cause loops
remove_all_actions('template_redirect');
remove_all_actions('init');

echo "<h2>Safe Mode Active</h2>";
echo "<p>Global loops broken. Try accessing your dashboard here: <a href='/wp-admin/'>Go to WP Admin</a></p>";
echo "<p><strong>CRITICAL:</strong> Once you gain access and delete the bad code snippet, delete this <code>fix-lockout.php</code> file immediately for security purposes.</p>";
