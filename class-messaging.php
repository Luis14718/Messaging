<?php

require_once MESSAGING__PLUGIN_DIR . "/library/twilio/src/Twilio/autoload.php";
use Twilio\Rest\Client;

class Messaging
{
    public static function init()
    {
        add_action("admin_menu", ["Messaging", "program_test_function"]);
    }
    //adding the main page with icon 
    public static function program_test_function()
    {
        add_menu_page(
            "Text Message", // Page Title
            "Text Message", // Menu Title
            "manage_options", // Capability
            "text-message", // Menu Slug
            ["Messaging", "program_test_display_form"],
            "dashicons-email",
            20
        );
    }
    public static function program_test_display_form()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . "messaging";
        $table_status_name = $wpdb->prefix . "messaging_status";

        if (isset($_POST["submit"])) {
            $phone = sanitize_text_field($_POST["phone"]);
            $message = sanitize_text_field($_POST["message"]);
            $accountSid = get_option("twilio_account_sid");
            $authToken = get_option("twilio_auth_token");

            // Creating a Twilio client
            $client = new Client($accountSid, $authToken);

            // checking if the site is local or server to be able to receive data with endpoint 
            if (
                strpos(get_site_url(), "localhost") !== false ||
                strpos(get_site_url(), "127.0.0.1") !== false
            ) {
                // Send the message
                $message_result = $client->messages->create($phone, [
                    "from" => "+19135132360",
                    "body" => $message,
                    // 'statusCallback' => "/wp-json/twilio/v1/callback",
                ]);
            } else {
                // Send the message
                $message_result = $client->messages->create($phone, [
                    "from" => "+19135132360",
                    "body" => $message,
                    "statusCallback" =>
                        get_site_url() . "/wp-json/twilio/v1/callback",
                ]);
            }

            $wpdb->insert(
                $table_name,
                [
                    "phone" => $phone,
                    "message" => $message,
                    "timestamp" => current_time("mysql"),
                ],
                ["%s", "%s", "%s"]
            );
            $message_id = $wpdb->insert_id;
            // inserting data to the database
            $wpdb->insert(
                $table_status_name,
                [
                    "id_api_message" => $message_result->sid,
                    "id_message" => $message_id,
                    "status_message" => $message_result->status,
                    "message" => $message,
                    "date_sent" => $message_result->dateSent,
                    "timestamp" => current_time("mysql"),
                ],
                ["%s", "%s", "%s", "%s", "%s"]
            );
        }

        self::view("form");
    }
    //retrieving the views 
    public static function view($name)
    {
        $file = MESSAGING__PLUGIN_DIR . "views/" . $name . ".php";
        include $file;
    }
}
