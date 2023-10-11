<?php
/*
Plugin Name: Simple Google Analytics
Description: Easily integrate Google Analytics tracking code into your website.
Version: 1.0
Author: Abhinav Saxena
*/

// Add the Google Analytics tracking code to the footer
function add_google_analytics_code() {
    $tracking_code = get_option('google_analytics_code');
    if (!empty($tracking_code)) {
        ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($tracking_code); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo esc_attr($tracking_code); ?>');
        </script>
        <?php
    }
}
add_action('wp_footer', 'add_google_analytics_code');

// Create a settings page for the Google Analytics tracking code
function simple_google_analytics_menu() {
    add_menu_page('Google Analytics Settings', 'Google Analytics', 'manage_options', 'simple-google-analytics', 'simple_google_analytics_settings');
}
add_action('admin_menu', 'simple_google_analytics_menu');

function simple_google_analytics_settings() {
    if (isset($_POST['submit'])) {
        $tracking_code = sanitize_text_field($_POST['tracking_code']);
        update_option('google_analytics_code', $tracking_code);
        echo '<div class="updated"><p>Google Analytics tracking code updated.</p></div>';
    }
    $current_code = get_option('google_analytics_code');
    ?>
    <div class="wrap">
        <h2>Google Analytics Settings</h2>
        <form method="post">
            <label for="tracking_code">Google Analytics Tracking Code:</label>
            <input type="text" name="tracking_code" id="tracking_code" value="<?php echo esc_attr($current_code); ?>" size="30" />
            <p>Enter your Google Analytics tracking code (e.g., UA-XXXXXXXXX-X).</p>
            <p><em>This code will be added to the footer of your website.</em></p>
            <input type="submit" name="submit" value="Save" class="button-primary" />
        </form>
    </div>
    <?php
}

?>

