<?php
/*
Plugin Name: Messaging
Description: Programming test for Job application 
Version: 1.0
Author: Luis Daniel Rodriguez Sanchez
*/


/* error_reporting(E_ALL);
ini_set("display_errors", 1); */
define("MESSAGING__PLUGIN_DIR", plugin_dir_path(__FILE__));

//getting styles 
wp_register_style(
    "style.css",
    plugins_url("assets/css/style.css", __FILE__),
    [],
    "v00"
);
wp_enqueue_style(
    "program-test-style",
    plugins_url("assets/css/style.css", __FILE__)
);

//including the webhook
add_action( 'rest_api_init', 'register_twilio_callback_endpoint' );
function register_twilio_callback_endpoint() {
    register_rest_route( 'twilio/v1', '/callback', array(
        'methods' => 'POST',
        'callback' => 'twilio_callback_handler',
    ) );
}

function twilio_callback_handler( $request ) {

    $messageSid = $request->get_param("SmsSid");
    global $wpdb;
    $table_name = $wpdb->prefix . "messaging_status";
    $data = [
        "status_message" => $request->get_param("MessageStatus"),
        "date_sent"=> current_time("mysql")
    ];
    $where = [
        "id_api_message" => $messageSid,
    ];
    $wpdb->update($table_name, $data, $where);
    $response = array(
        'status' => 'success',
        'message' => 'Callback received',
    );
    return rest_ensure_response( $response );
}

/// registering databases when turning on the plugin 
register_activation_hook(__FILE__, "program_test_activate");

function program_test_activate()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "messaging";
    $table_name2 = $wpdb->prefix . "messaging_status";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id INT AUTO_INCREMENT PRIMARY KEY,
        phone VARCHAR(20) NOT NULL,
        message TEXT NOT NULL,
        timestamp DATETIME NOT NULL
    ) $charset_collate;
    CREATE TABLE $table_name2 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_api_message VARCHAR(150) NOT NULL,
        id_message VARCHAR(150) NOT NULL,
        status_message VARCHAR(150) NOT NULL,
        message TEXT NOT NULL,
        date_sent VARCHAR(150) NULL,
        timestamp DATETIME NOT NULL
    ) $charset_collate;
    ";

    require_once ABSPATH . "wp-admin/includes/upgrade.php";
    dbDelta($sql);
}

/// getting this page when admin 
if (is_admin() || (defined("WP_CLI") && WP_CLI)) {
    $twilio_account_sid = get_option("twilio_account_sid");
    $twilio_auth_token = get_option("twilio_auth_token");

    if (!empty($twilio_account_sid) && !empty($twilio_auth_token)) {
        require_once MESSAGING__PLUGIN_DIR . "class-messaging.php";
        add_action("init", ["Messaging", "init"]);
        require_once MESSAGING__PLUGIN_DIR . "class-table-messaging.php";
        add_action("init", ["Tablemessaging", "init"]);
        require_once MESSAGING__PLUGIN_DIR . "class-table-status-messaging.php";
        add_action("init", ["TableStatusmessaging", "init"]);
    } else {
        require_once MESSAGING__PLUGIN_DIR . "class-options.php";
        add_action("init", ["Tokenization", "init"]);
    }
}

/// getting scripts 
function my_plugin_enqueue_scripts()
{
    wp_enqueue_script(
        "my-plugin-script",
        plugin_dir_url(__FILE__) . "assets/js/main.js",
        [],
        "1.0.0",
        true
    );
}
add_action("admin_enqueue_scripts", "my_plugin_enqueue_scripts");
