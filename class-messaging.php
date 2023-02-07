<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once MESSAGING__PLUGIN_DIR.'/library/twilio/src/Twilio/autoload.php';
use Twilio\Rest\Client;

class Messaging {

    public static function init(){
        add_action('admin_menu', array( 'Messaging', 'program_test_function' ));
    }
    public static function program_test_function() {
        add_menu_page(
            'Text Message', // Page Title
            'Text Message', // Menu Title
            'manage_options', // Capability
            'text-message', // Menu Slug
            array( 'Messaging', 'program_test_display_form' ), // Callback Function
            'dashicons-admin-generic', // Icon URL
            20 // Position
        );
     
    }
    public static function program_test_display_form() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'messaging';
        
        if (isset($_POST['submit'])) {
            $phone = sanitize_text_field($_POST['phone']);
            $message = sanitize_text_field($_POST['message']);
            $accountSid = 'AC928488ac2532f50724f6e37245088ee5';
            $authToken = '7e2bf43a2b9baacdff52f56ae6bea92b';
        
            // Create a Twilio client
            $client = new Client($accountSid, $authToken);
        
            // Send the message
            $client->messages->create(
                '+50363106539',
                array(
                    'from' => '+19135132360',
                    'body' => $message
                )
            );
         print_r($client);
            $wpdb->insert(
                $table_name,
                array(
                    'phone' => $phone,
                    'message' => $message,
                    'timestamp' => current_time('mysql')
                ),
                array(
                    '%s',
                    '%s',
                    '%s'
                )
            );       
        }

        self::view('form');
        
    }
    
    public static function view( $name ) {
		$file = MESSAGING__PLUGIN_DIR . 'views/'. $name . '.php';
		include( $file );
        
	}
    

}