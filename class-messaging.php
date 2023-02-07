<?php

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
            $accountSid = get_option( 'twilio_account_sid' );
            $authToken = get_option( 'twilio_auth_token' );
        
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